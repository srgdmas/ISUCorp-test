import axios from 'axios'
import store from "./store";

const _axios = axios.create({
    // baseURL:  process.env.MIX_APP_URL+'/api',
    // baseURL: 'http://sg-mobpay.thecloudgroup.tech/api',
    baseURL: '/api',
    headers: {
        'Content-Type': 'application/json',
    }
});

_axios.interceptors.request.use(
    function (request) {
        request.metadata = {startTime: new Date()};
        if (request.url.indexOf('/login') === -1) {
            request.headers.authorization = 'Bearer ' + sessionStorage.getItem('access_token');
        }
        return request;
    },
    function (error) {
        if (err.response.status === 404) {
            throw new Error(`${error.config.url} not found`);
        }
        return Promise.reject(error);
    }
);

_axios.interceptors.response.use(
    (response) => {
        response.metadata = {
            'duration': new Date() - response.config.metadata.startTime
        };
        return response;
    },
    (error) => {
        if (error.response && error.response.status === 419) {
            window.location = "/login";
            return;
        }
        return Promise.reject(error);
    }
);

export default _axios;
