import axios from 'axios';

const axiosClient = axios.create({
    withCredentials: true,
    baseURL: "http://127.0.0.1:8000/api",
    headers: {
        Accept: 'application/json'
    },
    
});


export default axiosClient;