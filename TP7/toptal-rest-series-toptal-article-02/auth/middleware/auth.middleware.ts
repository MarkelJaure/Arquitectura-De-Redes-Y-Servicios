import * as argon2 from "argon2";
import express from "express";
import usersService from "../../users/services/users.service";

class AuthMiddleware {
  async verifyUserPassword(
    req: express.Request,
    res: express.Response,
    next: express.NextFunction
  ) {
    const user: any = await usersService.getUserByEmailWithPassword(
      req.body.email
    );
    if (user) {
      const passwordHash = user.password;
      if (await argon2.verify(passwordHash, req.body.password)) {
        req.body = {
          userId: user.id,
          email: user.email,
          permissionLevel: user.permissionLevel,
          password: user.password
        };
        console.log(user)
        return next();
      }
    }

    res.status(400).send({ error: "Email o Password incorrecta" });
  }
}

export default new AuthMiddleware();
