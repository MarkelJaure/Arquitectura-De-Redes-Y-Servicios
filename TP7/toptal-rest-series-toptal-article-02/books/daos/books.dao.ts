import debug from "debug";
import shortid from "shortid";
import { CreateBookDto } from "../dto/create.book.dto";
import { PatchBookDto } from "../dto/patch.book.dto";
import { PutBookDto } from "../dto/put.book.dto";

const log: debug.IDebugger = debug("app:in-memory-dao");

/**
 * NEVER USER THIS CLASS IN REAL LIFE.
 * This class was created to ease the explanation of other topics in the corresponding article.
 * For any real-life scenario, consider using an ODM/ORM to manage your own database in a better way.
 */
class BooksDao {
  books: Array<CreateBookDto> = [];

  constructor() {
    log("Created new instance of BooksDao");
  }

  async addBook(book: CreateBookDto) {
    book.id = shortid.generate();
    this.books.push(book);
    return book.id;
  }

  async getBooks() {
    return this.books;
  }

  async getBookById(bookId: string) {
    return this.books.find((book: { id: string }) => book.id === bookId);
  }

  async putBookById(bookId: string, book: PutBookDto) {
    const objIndex = this.books.findIndex(
      (obj: { id: string }) => obj.id === bookId
    );
    this.books.splice(objIndex, 1, book);
    return `${book.id} updated via put`;
  }

  async patchBookById(bookId: string, book: PatchBookDto) {
    const objIndex = this.books.findIndex(
      (obj: { id: string }) => obj.id === bookId
    );
    let currentBook = this.books[objIndex];
    const allowedPatchFields = ["title", "autor"];
    for (let field of allowedPatchFields) {
      if (field in book) {
        // @ts-ignore
        currentBook[field] = book[field];
      }
    }
    this.books.splice(objIndex, 1, currentBook);
    return `${book.id} patched`;
  }

  async removeBookById(bookId: string) {
    const objIndex = this.books.findIndex(
      (obj: { id: string }) => obj.id === bookId
    );
    this.books.splice(objIndex, 1);
    return `${bookId} removed`;
  }

  async getBooksByUser(userId: string) {
    return this.books.filter((book) => book.userId == userId);
  }
}

export default new BooksDao();
