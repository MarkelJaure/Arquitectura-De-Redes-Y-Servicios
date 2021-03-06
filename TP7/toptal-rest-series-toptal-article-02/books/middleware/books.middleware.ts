import debug from "debug";
import express from "express";
import bookService from "../services/books.service";

const log: debug.IDebugger = debug("app:books-controller");
class BooksMiddleware {
  async validateRequiredBookBodyFields(
    req: express.Request,
    res: express.Response,
    next: express.NextFunction
  ) {
    if (req.body && req.body.title && req.body.autor) {
      next();
    } else {
      res.status(400).send({
        error: `Missing required fields title and autor`,
      });
    }
  }

  async validateBookExists(
    req: express.Request,
    res: express.Response,
    next: express.NextFunction
  ) {
    const book = await bookService.readById(req.params.bookId);
    if (book) {
      next();
    } else {
      res.status(404).send({
        error: `Book ${req.params.bookId} not found`,
      });
    }
  }

  async extractBookId(
    req: express.Request,
    res: express.Response,
    next: express.NextFunction
  ) {
    req.body.id = req.params.bookId;
    next();
  }

  async extractUserId(
    req: express.Request,
    res: express.Response,
    next: express.NextFunction
  ) {
    req.body.userId = req.params.userId;
    next();
  }
}

export default new BooksMiddleware();
