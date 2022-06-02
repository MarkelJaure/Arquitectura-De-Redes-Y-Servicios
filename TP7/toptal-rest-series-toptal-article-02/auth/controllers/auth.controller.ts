import crypto from "crypto";
import debug from "debug";
import express from "express";
import jwt from "jsonwebtoken";

const log: debug.IDebugger = debug("app:auth-controller");

let jwtSecret: string;
const tokenExpirationInSeconds = 36000;

class AuthController {
  async createJWT(req: express.Request, res: express.Response) {
    jwtSecret = process.env.JWT_SECRET!;
    try {
      const refreshId = req.body.userId + jwtSecret;

      const salt = crypto.createSecretKey(crypto.randomBytes(16));

      const hash = crypto
        .createHmac("sha512", salt)
        .update(refreshId)
        .digest("base64");

      req.body.refreshKey = salt.export();
      const token = jwt.sign(req.body, jwtSecret, {
        expiresIn: tokenExpirationInSeconds,
      });

      return res.status(201).send({ accessToken: token, refreshToken: hash });
    } catch (err) {
      console.log("createJWT error: %O", err);
      return res.status(500).send();
    }
  }
}

export default new AuthController();
