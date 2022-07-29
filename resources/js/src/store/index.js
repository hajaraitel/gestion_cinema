import axiosClient from '@/axios';
import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    currentUser:{
      data : {},
      token: sessionStorage.getItem('userToken'),
      role:null
    }
  },
  //il permet de changer les valeurs de state
  mutations: {
  },
  //methods
  actions: {

  },
  modules: {},
});
