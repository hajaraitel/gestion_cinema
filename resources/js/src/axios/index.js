import axios from 'axios';

const axiosClient = axios.create({
    withCredentials: true,
    baseURL: "http://127.0.0.1:8000/api",
    headers: {
        Accept: 'application/json'
    },
    
});

//authentication
axiosClient.interceptors.request.use(config=>{
    if (sessionStorage.getItem('userToken')){ 
     config.headers["Authorization"] = "Bearer " + sessionStorage.getItem('userToken')
   }
   return config;
 });

export default axiosClient;