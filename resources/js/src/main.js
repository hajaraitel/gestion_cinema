import '@/plugins/vue-composition-api'
import '@resources/sass/styles/styles.scss'
import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import router from './router'
import store from './store'
import axios from 'axios'
import axiosClient from '@/axios/index'
import VueAxios from 'vue-axios'

//require('./bootstrap');
//axios configuration : 
/*
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.axios.defaults.withCredentials = true;*/

Vue.use(VueAxios, axios);

//
Vue.config.productionTip = false



new Vue({
  router,
  store,
  vuetify,
  render: h => h(App),
}).$mount('#app')

