<template>
  <div class="auth-wrapper auth-v1">
    <div class="auth-inner">
      <v-card class="auth-card">
        <!-- logo -->
        <v-card-title class="d-flex align-center justify-center py-7">
          <router-link to="/" class="d-flex align-center">
            <v-img
              :src="require('@/assets/images/logos/logo.svg').default"
              max-height="30px"
              max-width="30px"
              alt="logo"
              contain
              class="me-3"
            ></v-img>

            <h2 class="text-2xl font-weight-semibold">MovieGo</h2>
          </router-link>
        </v-card-title>

        <!-- title -->
        <v-card-text>
          <p class="text-2xl font-weight-semibold text--primary mb-2">Bienvenue à MovieGo! 👋🏻</p>
        </v-card-text>

        <!-- login form -->
        <v-card-text>
        <!--Error alert-->
        <v-alert v-for="(error, idx) in errors" :key="idx" type="error">
          <span >{{ error }} </span>
        </v-alert>
        <!--End Error alert-->
          <v-form @submit.prevent="handleLogin">
            <v-text-field
              v-model="user.email"
              outlined
              label="Email"
              hide-details
              class="mb-3"
            ></v-text-field>

            <v-text-field
              v-model="user.password"
              outlined
              :type="isPasswordVisible ? 'text' : 'password'"
              label="Password"
              :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
              hide-details
              @click:append="isPasswordVisible = !isPasswordVisible"
            ></v-text-field>
            <v-btn type="submit" block color="primary" class="mt-6"> Login </v-btn>
          </v-form>
        </v-card-text>

        <!-- create new account  -->
        <v-card-text class="d-flex align-center justify-center flex-wrap mt-2">
          <span class="me-2"> Nouveau sur notre plateforme ? </span>
          <router-link :to="{ name: 'register' }"> Creer un compte </router-link>
        </v-card-text>
      </v-card>
    </div>

     <!-- background triangle shape  -->
     <img
      class="auth-mask-bg"
      height="190"
      :src="require(`@/assets/images/misc/mask-${$vuetify.theme.dark ? 'dark' : 'light'}.png`).default"
    />

    <!-- tree  -->
    <v-img
      class="auth-tree-3"
      width="377"
      height="289"
      :src="require('@/assets/images/misc/tree-3.png').default"
    ></v-img>
  </div>
</template>

<script>
import { mdiEyeOutline, mdiEyeOffOutline } from '@mdi/js'
import { ref } from '@vue/composition-api'
import axios from 'axios';
import axiosClient from '@/axios/index';
import store from '@/store';

export default {
  setup() {
    const isPasswordVisible = ref(false)
    return {
      isPasswordVisible,
      icons: {
        mdiEyeOutline,
        mdiEyeOffOutline,
      },
    }
  },
  data(){
    return{
      user:{email:"",password:""},
      errors:{}
    }
  },
  methods:{
    handleLogin(){
      axios.get('/sanctum/csrf-cookie').then(response => {
        axiosClient.post('login',this.user).then(response=>{
          if(response.status==200){

            sessionStorage.setItem('userToken', response.data.token);
            sessionStorage.setItem('userName',response.data.user.nom+' '+response.data.user.prenom)
            localStorage.setItem('userRole',response.data.user.is_admin)
            
            this.$store.state.currentUser.data = response.data.user;

            if(response.data.user.is_admin)
              this.$router.push('/admin/dashboard');
            else if(!response.data.user.is_admin)
              this.$router.push('/user/dashboard');  
            else
              this.$router.push('/'); 

            this.errors = {}
            
          }
        }).catch(error=>{
         
            this.errors = error.response.data;
            sessionStorage.removeItem('userToken');
        });
      });
    },
  },
  
}
</script>

<style lang="scss">
@import '~@resources/sass/preset/pages/auth.scss';
</style>
