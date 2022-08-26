<template>
  <v-menu offset-y left nudge-bottom="14" min-width="230" content-class="user-profile-menu-content">
    <template v-slot:activator="{ on, attrs }">
      
        <v-avatar size="40px" v-bind="attrs" v-on="on">
          <v-img :src="user.photo"></v-img>
          <!--v-bind:src="this.user.photo"-->
        </v-avatar>
      
    </template>
    <v-list>
      <div class="pb-3 pt-2 ml-2">
          <v-avatar size="40px">
            <v-img :src="user.photo"></v-img>
          </v-avatar>
          
        <div class="d-inline-flex flex-column justify-center ms-3" style="vertical-align: middle">
          <span class="text--primary font-weight-semibold mb-n1"> {{ this.user.nom+" "+this.user.prenom }} </span>
          <!--<small class="text--disabled text-capitalize">Admin</small>-->
        </div>
      </div>

      <v-divider></v-divider>

      <!-- Profile
      <v-list-item :to="{ name: 'admin_profile' }" link>
        <v-list-item-icon class="me-2">
          <v-icon size="22">
            {{ icons.mdiAccountOutline }}
          </v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title >Profile</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
      

      <v-divider class="my-2"></v-divider>-->

      <!-- Logout -->
      <v-list-item @click="logout" link>
        <v-list-item-icon class="me-2">
          <v-icon size="22">
            {{ icons.mdiLogoutVariant }}
          </v-icon>
        </v-list-item-icon>
        <v-list-item-content>
          <v-list-item-title>Logout</v-list-item-title>
        </v-list-item-content>
      </v-list-item>
    </v-list>
  </v-menu>
</template>

<script>
import {
  mdiAccountOutline,
  mdiLogoutVariant,
} from '@mdi/js'

export default {
  data () {
    return {
      user:{}
    }
  },
  methods: {
    logout(){
      
      sessionStorage.removeItem('userToken');
      localStorage.removeItem('currentUser');
      this.$router.push('/');
    }
  },
  watch:{

  },
  mounted(){
    window.addEventListener('updateUser', (event) => {
    this.user = JSON.parse(event.detail.storage);
  });

    this.user = JSON.parse(localStorage.getItem('currentUser'));
  },
  setup() {
    return {
      icons: {
        mdiAccountOutline,
        mdiLogoutVariant,
      },
    }
  },
}
</script>

<style lang="scss">
.user-profile-menu-content {
  
  .v-list-item {
    min-height: 2.5rem !important;
  }
}
</style>
