import crypto from "crypto";
import debug from "debug";
import express from "express";
import jwt from "jsonwebtoken";
import { Jwt } from '../../common/types/jwt';
import usersService from "../../users/services/users.service";

class JWTController {

    async getInfoJWT(
        res: express.Response,
        aAuthorization: string) {
        const authorization = aAuthorization.split(' ');
        if (authorization[0] !== 'Bearer' || !authorization[1]) { //Corte por no token
            console.log("No hay JWT")
            res.status(401).send();
        } else {
            console.log("Leyendo JWT")
            res.locals.jwt = jwt.verify(
                authorization[1],
                process.env.JWT_SECRET!
            ) as Jwt;

            const user = await usersService.readById(res.locals.jwt.userId)
            if (user) { //JWT correcto
                console.log("JWT verificado")
                return user;
            } else { //Corte por token no valido
                console.log("Cookie no coincide con usuario real")
                res.status(401).send();
            }
        }
    }

}

export default new JWTController();
