import { CommonRoutesConfig } from '../common/common.routes.config';
import UsersController from './controllers/users.controller';
import UsersMiddleware from './middleware/users.middleware';
import express from 'express';
import jwtMiddleware from '../auth/middleware/jwt.middleware';
import { PermissionLevel } from '../common/middleware/common.permissionlevel.enum';
import CommonPermissionMiddleware from '../common/middleware/common.permission.middleware';

export class UsersRoutes extends CommonRoutesConfig {
    constructor(app: express.Application) {
        super(app, 'UsersRoutes');
    }

    configureRoutes() {
        this.app
            .route(`/users`)
            .get(jwtMiddleware.validJWTNeeded, UsersController.listUsers)
            .post(
                UsersMiddleware.validateRequiredUserBodyFields,
                UsersMiddleware.validateSameEmailDoesntExist,
                UsersController.createUser
            );

        this.app.param(`userId`, UsersMiddleware.extractUserId);
        this.app
            .route(`/users/:userId`)
            .all(jwtMiddleware.validJWTNeeded, UsersMiddleware.validateUserExists)
            .get(UsersController.getUserById)
            .delete(
                [CommonPermissionMiddleware.permissionLevelRequired(
                    PermissionLevel.ADMIN_PERMISSION
                ),
                UsersController.removeUser]);

        this.app.put(`/users/:userId`, [
            jwtMiddleware.validJWTNeeded,
            CommonPermissionMiddleware.permissionLevelRequired(
                PermissionLevel.ADMIN_PERMISSION
            ),
            UsersMiddleware.validateRequiredUserBodyFields,
            UsersMiddleware.validateSameEmailBelongToSameUser,
            UsersController.put,
        ]);

        this.app.patch(`/users/:userId`, [
            UsersMiddleware.validatePatchEmail,
            UsersController.patch,
        ]);

        return this.app;
    }
}
