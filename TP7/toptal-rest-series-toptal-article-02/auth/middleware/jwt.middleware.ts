import express from 'express';
import jwt from 'jsonwebtoken';
import crypto from 'crypto';
import { Jwt } from '../../common/types/jwt';
import usersService from '../../users/services/users.service';

// @ts-expect-error
const jwtSecret: string = process.env.JWT_SECRET;

class JwtMiddleware {
    verifyRefreshBodyField(
        req: express.Request,
        res: express.Response,
        next: express.NextFunction
    ) {
        if (req.body && req.body.refreshToken) {
            return next();
        } else {
            return res
                .status(400)
                .send({ errors: ['Missing required field: refreshToken'] });
        }
    }

    async validRefreshNeeded(
        req: express.Request,
        res: express.Response,
        next: express.NextFunction
    ) {
        const user: any = await usersService.getUserByEmailWithPassword(
            res.locals.jwt.email
        );
        const salt = crypto.createSecretKey(
            Buffer.from(res.locals.jwt.refreshKey.data)
        );
        const hash = crypto
            .createHmac('sha512', salt)
            .update(res.locals.jwt.userId + process.env.JWT_SECRET!)
            .digest('base64');
        if (hash === req.body.refreshToken) {
            req.body = {
                userId: user.id,
                email: user.email,
                password: user.password,
                permissionLevel: user.permissionLevel
            };
            return next();
        } else {
            return res.status(400).send({ errors: ['Invalid refresh token'] });
        }
    }

    async validJWTNeeded(
        req: express.Request,
        res: express.Response,
        next: express.NextFunction
    ) {
        if (req.headers['authorization']) {
            try {
                const authorization = req.headers['authorization'].split(' ');
                if (authorization[0] !== 'Bearer' || !authorization[1]) {
                    return res.status(401).send({
                        error: `Usted no se encuentra logueado`
                    });
                } else {
                    res.locals.jwt = jwt.verify(
                        authorization[1],
                        process.env.JWT_SECRET!
                    ) as Jwt;

                    const user = await usersService.readById(res.locals.jwt.userId)
                    if (user) {
                        next();
                    } else {
                        res.status(401).send({
                            error: `Usted no se encuentra logueado`,
                        });
                    }
                }
            } catch (err) {
                console.log(err)
                return res.status(403).send({ error: err });
            }
        } else {
            return res.status(401).send({
                error: `Usted no se encuentra logueado`,
            });
        }
    }

    async GetLoggedUser(
        req: express.Request,
        res: express.Response,
    ) {
        if (req.headers['authorization']) {
            try {
                const authorization = req.headers['authorization'].split(' ');
                if (authorization[0] !== 'Bearer' || !authorization[1]) {
                    return res.status(401).send();
                } else {
                    res.locals.jwt = jwt.verify(
                        authorization[1],
                        process.env.JWT_SECRET!
                    ) as Jwt;

                    const user = await usersService.readById(res.locals.jwt.userId)
                    if (user) {
                        res.status(201).send(user);
                    } else {
                        res.status(401).send();
                    }
                }
            } catch (err) {
                console.log(err)
                return res.status(403).send();
            }
        } else {
            return res.status(401).send({
                error: `Usted no se encuentra logueado`,
            });
        }
    }

    async SetLoggedUser(
        req: express.Request,
        res: express.Response,
        next: express.NextFunction
    ) {
        if (req.headers['authorization']) {
            try {
                const authorization = req.headers['authorization'].split(' ');
                if (authorization[0] !== 'Bearer' || !authorization[1]) {
                    return res.status(401).send();
                } else {
                    res.locals.jwt = jwt.verify(
                        authorization[1],
                        process.env.JWT_SECRET!
                    ) as Jwt;

                    const user = await usersService.readById(res.locals.jwt.userId)
                    if (user) {
                        req.body.user = user
                        next();
                    } else {
                        res.status(401).send();
                    }
                }
            } catch (err) {
                console.log(err)
                return res.status(403).send();
            }
        } else {
            return res.status(401).send({
                error: `Usted no se encuentra logueado`,
            });
        }
    }
}

export default new JwtMiddleware();