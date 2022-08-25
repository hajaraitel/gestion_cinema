<template>
  <v-navigation-drawer
    :value="isDrawerOpen"
    app
    floating
    width="260"
    class="app-navigation-menu"
    :right="$vuetify.rtl"
    @input="val => $emit('update:is-drawer-open', val)"
  >
    <!-- Navigation Header -->
    <div class="vertical-nav-header d-flex items-center ps-6 pe-5 pt-5 pb-2">
      <router-link to="/admin/dashboard" class="d-flex align-center text-decoration-none">
        <v-img
          :src="require('@/assets/images/logos/logo.svg').default"
          max-height="30px"
          max-width="30px"
          alt="logo"
          contain
          eager
          class="app-logo me-3"
        ></v-img>
        <v-slide-x-transition>
          <h2 class="app-title text--primary">MovieGo</h2>
        </v-slide-x-transition>
      </router-link>
    </div>

    <!-- Navigation Items -->
    <v-list expand shaped class="vertical-nav-menu-items pr-5">
      <nav-menu-link title="Accueil" :to="{ name: 'admin_dashboard' }" :icon="icons.mdiHomeOutline"></nav-menu-link>
      <nav-menu-link
        title="Profile"
        :to="{ name: 'admin_profile' , params: { id: this.user.idUser }}"
        :icon="icons.mdiAccountCogOutline"
      ></nav-menu-link>
      <v-divider class="mt-5 mb-5"></v-divider>
      <nav-menu-link title="Gestion films" :to="{ name: 'admin_gestion_films' }" :icon="icons.mdiMovieOpenCogOutline"></nav-menu-link>
      <nav-menu-link title="Gestion seances" :to="{ name: 'admin_gestion_seances' }" :icon="icons.mdiFileCogOutline"></nav-menu-link>
      <nav-menu-link title="Gestion salles" :to="{ name: 'admin_gestion_salles' }" :icon="icons.mdiGoogleClassroom"></nav-menu-link>
      <nav-menu-link title="Gestion reservation" :to="{ name: 'admin_gestion_reservations' }" :icon="icons.mdiCellphoneCog"></nav-menu-link>
      <nav-menu-link title="Gestion utilisateurs" :to="{ name: 'admin_gestion_utilisateurs' }" :icon="icons.mdiFormSelect"></nav-menu-link>
    </v-list>
    
  </v-navigation-drawer>
</template>

<script>
// eslint-disable-next-line object-curly-newline
import {
  mdiHomeOutline,
  mdiMovieOpenCogOutline,
  mdiFileCogOutline,
  mdiCellphoneCog,
  mdiFormSelect,
  mdiAccountCogOutline,
  mdiGoogleClassroom
} from '@mdi/js'
import NavMenuSectionTitle from './components/NavMenuSectionTitle.vue'
import NavMenuGroup from './components/NavMenuGroup.vue'
import NavMenuLink from './components/NavMenuLink.vue'

export default {
   data () {
    return {
      user:{}
    }
  },
  mounted(){
    this.user = JSON.parse(localStorage.getItem('currentUser'))
  },
  components: {
    NavMenuSectionTitle,
    NavMenuGroup,
    NavMenuLink,
  },
  props: {
    isDrawerOpen: {
      type: Boolean,
      default: null,
    },
  },
  setup() {
    return {
      icons: {
        mdiHomeOutline,
        mdiMovieOpenCogOutline,
        mdiFileCogOutline,
        mdiCellphoneCog,
        mdiFormSelect,
        mdiAccountCogOutline,
        mdiGoogleClassroom
      },
    }
  },
}
</script>

<style lang="scss" scoped>
@import '@resources/sass/preset/mixins.scss';

.app-title {
  font-size: 1.25rem;
  font-weight: 700;
  font-stretch: normal;
  font-style: normal;
  line-height: normal;
  letter-spacing: 0.3px;
}

// ? Adjust this `translateX` value to keep logo in center when vertical nav menu is collapsed (Value depends on your logo)
.app-logo {
  transition: all 0.18s ease-in-out;
  .v-navigation-drawer--mini-variant & {
    transform: translateX(-4px);
  }
}

@include theme(app-navigation-menu) using ($material) {
  background-color: map-deep-get($material, 'background');
}

.app-navigation-menu {
  .v-list-item {
    &.vertical-nav-menu-link {
      ::v-deep .v-list-item__icon {
        .v-icon {
          transition: none !important;
        }
      }
    }
  }
}


</style>
