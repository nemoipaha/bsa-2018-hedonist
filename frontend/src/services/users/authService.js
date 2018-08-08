import StorageService from '../common/storageService';
import httpService from "../common/httpService";

export default {
    state: {
        token: '',
        user: null
    },

    getters: {
        isLoggedIn: state => {
            return state.user !== null;
        },
        getAuthenticatedUser: (state) => {
            return state.user;
        },
        getToken: state => {
            return state.token;
        }
    },

    mutations: {
        SET_TOKEN: (state, token) => {
            state.token = token;
        },
        USER_LOGOUT: (state, user) => {
            httpService.authRequest({
                url: '/user/logout',
                method: 'post',
                data: {
                    user
                }
            }).then(function (res) {
                StorageService.removeToken();
                state.token = '';
                state.user = null;
            }).catch(function (err) {
                // TODO: Handle error
            });
        },
        SET_AUTHENTICATED_USER: (state, user) => {
            state.currentUser = user;
        }
    },

    actions: {
        login: (context, username, password) => {
            httpService.request({
                url: '/user/login',
                method: 'post',
                data: {
                    username,
                    password
                }
            }).then(function (res) {
                state.token = res.token;
                state.user = res.user;
                StorageService.setToken(res.token);
            }).catch(function (err) {
                // TODO: Handle error
            });
        },
        logout: (context) => {
            context.commit('USER_LOGOUT', state.currentUser);
        },
        resetPassword: (context, email) => {
            httpService.request({
                url: '/user/resetPassword',
                method: 'post',
                data: {
                    email
                }
            }).then(function (res) {
            }).catch(function (err) {
                // TODO: Handle error
            });
        },
        refreshToken: (context, email) => {
            httpService.authRequest({
                url: '/user/refreshToken',
                method: 'post',
                params: {
                    email
                }
            }).then(function (res) {
                state.token = res.token;
                StorageService.setToken(res.token);
            }).catch(function (err) {
                // TODO: Handle error
            });
        },
        sendForgotEmail: (context, state) => {
            let data = state.user;
            httpService.authRequest({
                url: '/user/forgotEmail',
                method: 'post',
                data: {
                    data
                }
            }).then(function (res) {
            }).catch(function (err) {
                // TODO: Handle error
            });
        },
        fetchAuthenticatedUser: (context, token) => {
            httpService.authRequest({
                url: '/user/userInfo',
                method: 'get',
                params: {
                    token
                }
            }).then(function (res) {
            }).catch(function (err) {
                // TODO: Handle error
            });
        }
    }
};
