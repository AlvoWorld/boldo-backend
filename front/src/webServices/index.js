import axios from 'axios';
let webService = axios.create({
    // baseURL: 'http://localhost/api/'
    baseURL: '/api/'
});

export default webService
