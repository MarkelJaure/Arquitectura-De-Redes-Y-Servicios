import cors from "cors";
import debug from "debug";
import dotenv from "dotenv";
import express from "express";
import * as expressWinston from "express-winston";
import * as http from "http";
import * as winston from "winston";
import { AuthRoutes } from "./auth/auth.routes.config";
import { BooksRoutes } from "./books/books.routes.config";
import { CommonRoutesConfig } from "./common/common.routes.config";
import { UsersRoutes } from "./users/users.routes.config";
import rateLimit from 'express-rate-limit';
import { PermissionLevel } from "./common/middleware/common.permissionlevel.enum";
import { CreateUserDto } from "./users/dto/create.user.dto";
import jwtMiddleware from "./auth/middleware/jwt.middleware";
import jwtController from "./auth/controllers/jwt.controller";



const dotenvResult = dotenv.config();
if (dotenvResult.error) {
  throw dotenvResult.error;
} else {
  console.log(dotenvResult)
}
const app: express.Application = express();
const server: http.Server = http.createServer(app);
const port = 3000;
const routes: Array<CommonRoutesConfig> = [];
const debugLog: debug.IDebugger = debug("app");

const loginLimiter = rateLimit({
  windowMs: 60 * 1000, // 1 minute
  max: 5, // Limit each IP to 5 requests per `window` (here, per 1 minute)
  message: { error: 'Demasiadas solicitudes de login en 1 minuto (max 5)' },
  standardHeaders: true, // Return rate limit info in the `RateLimit-*` headers
  legacyHeaders: false, // Disable the `X-RateLimit-*` headers
})

const isAdmin = async (user: any) => {
  return user.permissionLevel == PermissionLevel.ADMIN_PERMISSION
}

const isLogged = async (user: any) => {
  return user.id !== null
}

const usersLimiter = rateLimit({
  windowMs: 60 * 1000, // 1 minute
  max: async (request, response) => {
    var user = await jwtController.getInfoJWT(response, request.headers['authorization']!);
    //Chequear que puede volver o no un usuario

    if ((await isLogged(user) && await isAdmin(user))) {
      console.log("Usuario Admin")
      return 15
    } else {
      console.log("Usuario Free")
      return 3
    }
  },// Limit each IP to 5 requests per `window` (here, per 1 minute)
  message: { error: 'Demasiadas solicitudes a /users en 1 minuto' },
  standardHeaders: true, // Return rate limit info in the `RateLimit-*` headers
  legacyHeaders: false, // Disable the `X-RateLimit-*` headers
})

app.post('/auth', loginLimiter)
app.get('/users', usersLimiter)
app.use(express.json());
app.use(cors());

const loggerOptions: expressWinston.LoggerOptions = {
  transports: [new winston.transports.Console()],
  format: winston.format.combine(
    winston.format.json(),
    winston.format.prettyPrint(),
    winston.format.colorize({ all: true })
  ),
};

if (!process.env.DEBUG) {
  loggerOptions.meta = false; // when not debugging, make terse
}

app.use(expressWinston.logger(loggerOptions));

routes.push(new UsersRoutes(app));
routes.push(new BooksRoutes(app));
routes.push(new AuthRoutes(app));

const runningMessage = `Server running at http://localhost:${port}`;
app.get("/", (req: express.Request, res: express.Response) => {
  res.status(200).send(runningMessage);
});
server.listen(port, () => {
  routes.forEach((route: CommonRoutesConfig) => {
    debugLog(`Routes configured for ${route.getName()}`);
  });
  console.log(runningMessage);
});
