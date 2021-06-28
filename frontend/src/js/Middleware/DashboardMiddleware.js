import BaseMiddleware from "./BaseMiddleware";

export default class DashboardMiddleware extends BaseMiddleware
{
    static getUserCreate(successHandler) {
        this.get('/dashboard/users/create', successHandler);
    }

    static postUser(user, successHandler) {
        this.post('/dashboard/users', user, successHandler);
    }

    static deleteUser(userId, successHandler) {
        this.delete(`/dashboard/users/${userId}`, null, successHandler);
    }
}