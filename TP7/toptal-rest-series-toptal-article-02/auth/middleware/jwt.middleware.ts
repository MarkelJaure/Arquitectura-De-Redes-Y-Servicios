import express from 'express';
import jwt from 'jsonwebtoken';
import crypto from 'crypto';
import { Jwt } from '../../common/types/jwt';
import usersService from '../../users/services/users.service';
import usersMiddleware from '../../users/middleware/users.middleware';
import usersController from '../../users/controllers/users.controller';

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
                    console.log("No hay JWT")
                    return res.status(401).send();
                } else {
                    console.log(authorization)
                    res.locals.jwt = jwt.verify(
                        authorization[1],
                        process.env.JWT_SECRET!
                    ) as Jwt;

                    const user = await usersService.readById(res.locals.jwt.userId)
                    if (user) {
                        console.log("JWT verificado")
                        next();
                    } else {
                        console.log("Cookie no coincide con usuario real")
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