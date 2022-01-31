import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex);

const axiosBase = axios.create({
    // baseURL: '/api',
    baseURL: 'http://127.0.0.1:8000/api',
});
const store = new Vuex.Store({
    state: {
        message: '',
        user: sessionStorage.getItem('user') || null,
        accessToken: sessionStorage.getItem('access_token') || null,
    },
    mutations: {
        SET_MESSAGE(state, message) {
            state.message = message
        },
        SET_USER(state, user) {
            state.user = user;
            sessionStorage.setItem('user', user);
        },
        updateLocalStorage(state, {access, refresh}) {
            sessionStorage.setItem('access_token', access);
            state.accessToken = access;
        },
        updateAccess(state, access) {
            state.accessToken = access
        },
        destroyToken(state) {
            state.accessToken = null;
            state.refreshToken = null
        },
        updateUserData(state, data) {
            state.isowner = data;
            sessionStorage.setItem('isowner', data);
        },
        userEmail(state, data) {
            state.user_email = data;
            sessionStorage.setItem('userEmail', data);
        },
        updateUser(state, data) {
            state.user_photo = data.photo;
            state.user_name = data.name;
            sessionStorage.setItem('userPhoto', data.photo);
            sessionStorage.setItem('userName', data.name);
        }
    },
    getters: {
        loggedIn(state) {
            return state.accessToken != null
        },
        userEmail(state) {
            return state.user_email
        },
        accessToken(state) {
            return state.accessToken
        },
        userName(state) {
            return state.user_name
        },
        userPhoto(state) {
            return state.user_photo
        },
        user(state) {
            return JSON.parse(state.user)
        },
    },
    actions: {
        refreshToken(context) {
            return new Promise((resolve, reject) => {
                axiosBase.post('/auth/refresh/', {
                    refresh: context.state.refreshToken
                }) // send the stored refresh token to the backend API
                    .then(response => { // if API sends back new access and refresh token update the store
                        console.log('New access successfully generated');
                        context.commit('updateAccess', response.data.access);
                        resolve(response.data.access)
                    })
                    .catch(err => {
                        console.log('error in refreshToken Task');
                        reject(err) // error generating new access and refresh token because refresh token has expired
                    })
            })
        },
        registerUser(context, data) {
            return new Promise((resolve, reject) => {
                axiosBase.post('/register', {
                    name: data.name,
                    email: data.email,
                    username: data.username,
                    password: data.password,
                    confirm: data.confirm
                })
                    .then(response => {
                        resolve(response)
                    })
                    .catch(error => {
                        reject(error)
                    })
            })
        },
        logoutUser(context) {
            if (context.getters.loggedIn) {
                return new Promise((resolve, reject) => {
                    sessionStorage.removeItem('access_token');
                    sessionStorage.removeItem('user');
                    context.commit('destroyToken');
                    resolve(true);
                })
            }
        },
        loginUser(context, credentials) {

            return new Promise((resolve, reject) => {
                // send the username and password to the backend API:
                let obj = new FormData();
                obj.append('email', credentials.username);
                obj.append('password', credentials.password);
                axiosBase.post('/auth/login', obj)
                // if successful update local storage:
                    .then(response => {
                        context.commit('updateLocalStorage', {
                            access: response.data.access_token,
                            refresh: response.data.refresh
                        }); // store the access and refresh token in localstorage
                        context.dispatch('getDataUser', {token: response.data.access_token});
                        resolve(response)
                    })
                    .catch(err => {
                        console.log(err)
                        reject(err)
                    })
            })
        },
        getDataUser(context, data) {
            return new Promise((resolve, reject) => {
                axiosBase.post('/auth/me' + '?token=' + data.token)
                    .then(response => {
                        context.commit('SET_USER', JSON.stringify(response.data));
                        resolve()
                    })
                    .catch(err => {
                        reject(err)
                    })
            })
        },
        getUser(context) {
            return new Promise((resolve, reject) => {
                axiosBase.post(`/auth/me?token=${context.state.accessToken}`)
                    .then(response => {
                        context.commit('updateUser', response.data);
                        resolve()
                    })
                    .catch(err => {
                        context.dispatch('logoutUser');
                        reject(err)
                    })
            })
        }
    }
});

export default store
