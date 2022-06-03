import express from "express";
import jwtMiddleware from "../auth/middleware/jwt.middleware";
import { CommonRoutesConfig } from "../common/common.routes.config";
import UsersMiddleware from "../users/middleware/users.middleware";
import BooksController from "./controllers/books.controller";
import BooksMiddleware from "./middleware/books.middleware";

export class BooksRoutes extends CommonRoutesConfig {
  constructor(app: express.Application) {
    super(app, "BooksRoutes");
  }

  configureRoutes() {
    this.app.route(`/books`).get(BooksController.listBooks);

    //Nuevos metodos

    this.app.param(`userId`, BooksMiddleware.extractUserId);
    this.app
      .route(`/users/:userId/books`)
      .all(jwtMiddleware.validJWTNeeded, UsersMiddleware.validateUserExists)
      .get(BooksController.getBooksByUserId)
      .post(
        BooksMiddleware.validateRequiredBookBodyFields,
        BooksController.createBook
      );

    this.app.param(`bookId`, BooksMiddleware.extractBookId);
    this.app.param(`userId`, UsersMiddleware.extractUserId);
    this.app
      .route(`/users/:userId/books/:bookId`)
      .all([
        jwtMiddleware.validJWTNeeded,
        UsersMiddleware.validateUserExists,
        BooksMiddleware.validateBookExists,
      ])
      .get(BooksController.getBookByUserAndId)
      .delete(BooksController.removeBook);

    this.app.put(`/users/:userId/books/:bookId`, [
      UsersMiddleware.validateUserExists,
      BooksMiddleware.validateRequiredBookBodyFields,
      BooksController.put,
    ]);

    this.app.patch(`/users/:userId/books/:bookId`, [
      BooksController.patch,
    ]);

    return this.app;
  }
}
