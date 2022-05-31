import { CRUD } from "../../common/interfaces/crud.interface";
import BooksDao from "../daos/books.dao";
import { CreateBookDto } from "../dto/create.book.dto";
import { PatchBookDto } from "../dto/patch.book.dto";
import { PutBookDto } from "../dto/put.book.dto";

class BookService implements CRUD {
  async create(resource: CreateBookDto) {
    return BooksDao.addBook(resource);
  }

  async deleteById(id: string) {
    return BooksDao.removeBookById(id);
  }

  async list(limit: number, page: number) {
    return BooksDao.getBooks();
  }

  async patchById(id: string, resource: PatchBookDto): Promise<any> {
    return BooksDao.patchBookById(id, resource);
  }

  async putById(id: string, resource: PutBookDto): Promise<any> {
    return BooksDao.putBookById(id, resource);
  }

  async readById(id: string) {
    return BooksDao.getBookById(id);
  }

  async getBooksByUser(userId: string): Promise<any> {
    return BooksDao.getBooksByUser(userId);
  }
}

export default new BookService();
