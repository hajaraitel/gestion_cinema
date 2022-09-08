<template>
  <div class="auth-wrapper auth-v1">
    <div class="auth-inner">
      <v-card class="auth-card">
        <!-- logo -->
        <v-card-title class="d-flex align-center justify-center py-7">
          <router-link to="" class="d-flex align-center">
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
          <p class="text-2xl font-weight-semibold text--primary mb-2">L'aventure commence ici 🚀</p>
          <p class="mb-2">Inscription facile et rapide!</p>
        </v-card-text>

        <!-- register form -->
        <v-card-text>
          <!--Error alert-->
        <v-alert v-for="(error, idx) in errors" :key="idx" type="error">
          <span >{{ error }} </span>
        </v-alert>
        <!--End Error alert-->
          <v-form>
            <v-text-field
              v-model="user.nom"
              outlined
              label="nom"
              hide-details
              class="mb-3"
            ></v-text-field>
            <v-text-field
              v-model="user.prenom"
              outlined
              label="prenom"
              hide-details
              class="mb-3"
            ></v-text-field>

            <v-text-field
              v-model="user.email"
              outlined
              label="Email"
              hide-details
              class="mb-3"
            ></v-text-field>

            <v-text-field
              class="mb-5"
              v-model="user.password"
              outlined
              :type="isPasswordVisible ? 'text' : 'password'"
              label="Mot de passe"
              :append-icon="isPasswordVisible ? icons.mdiEyeOffOutline : icons.mdiEyeOutline"
              hide-details
              @click:append="isPasswordVisible = !isPasswordVisible"
            ></v-text-field>
            <span class="mt-5">Sexe</span>
            <v-radio-group
              v-model="user.sexe" row
              mandatory>
              <v-radio
                label="Femme"
                value="femme"
              ></v-radio>
              <v-radio
                label="Homme"
                value="homme"
              ></v-radio>
            </v-radio-group>
            <v-btn block color="primary" class="mt-6" @click.prevent="register"> S'inscrire</v-btn>
          </v-form>
        </v-card-text>

        <!-- create new account  -->
        <v-card-text class="d-flex align-center justify-center flex-wrap mt-2">
          <span class="me-2"> Vous avez déjà un compte ?</span>
          <router-link :to="{ name: 'login' }"> S'identifier </router-link>
        </v-card-text>


      </v-card>
    </div>

    <!-- background triangle shape  -->
    <img
      class="auth-mask-bg"
      height="190"
      :src="require(`@/assets/images/misc/mask-${$vuetify.theme.dark ? 'dark' : 'light'}.png`).default"
    />

    <!-- tree 
    <v-img class="auth-tree" width="247" height="185" :src="require('@/assets/images/misc/tree.png').default"></v-img>
-->
    <!-- tree  
    <v-img
      class="auth-tree-3"
      width="377"
      height="289"
      :src="require('@/assets/images/misc/tree-3.png').default"
    ></v-img>-->
  </div>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import { mdiEyeOutline, mdiEyeOffOutline } from '@mdi/js'
import { ref } from '@vue/composition-api'
import axiosClient from '@/axios'

export default {
  
  data () {
    return {
      user:{nom:'',prenom:'',email:'',password:'',sexe:''},
      errors:{}
    }
  },
methods: {
  register(){
    axiosClient.post('/register', this.user)
    .then(resp=>{
                if(resp.status==200)
                {
                  this.$router.push('/')
                  this.errors = {}
                }  
                })
    .catch((error) =>{
        this.errors = error.response.data;
    });
  },
  

  },
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
}
</script>

<style lang="scss">
@import '~@resources/sass/preset/pages/auth.scss';
</style>
