import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

const routes = [
  /** Global routes */
  {
    path: '/',
    name: 'login',
    component: () => import('@/views/pages/Login.vue'),
    meta: {
      layout: 'blank',
    },
  },
  {
    path: '/register',
    name: 'register',
    component: () => import('@/views/pages/Register.vue'),
    meta: {
      layout: 'blank',
    },
  },
  /*error routes*/
  {
    path: '/error-404',
    name: 'error-404',
    component: () => import('@/views/Error.vue'),
    meta: {
      layout: 'blank',
    },
  },
  {
    path: '*',
    redirect: 'error-404',
  },
  /*admin routes*/
  {
    path: '/admin/dashboard',
    name: 'admin_dashboard',
    component: () => import('@/views/admin/adminDashboard.vue'),
   
  },
  {
    path: '/admin/gestionSalles',
    name: 'admin_gestion_salles',
    component: () => import('@/views/admin/gestionSalle.vue'),
   
  },
  {
    path: '/admin/gestionFilms',
    name: 'admin_gestion_films',
   // component: () => import('@/views/admin/gestionSalle.vue'),
   
  },
  {
    path: '/admin/gestionSeances',
    name: 'admin_gestion_seances',
  //  component: () => import('@/views/admin/gestionSalle.vue'),
   
  },
  {
    path: '/admin/gestionReservations',
    name: 'admin_gestion_reservations',
   component: () => import('@/views/admin/gestionReservation.vue'),
   
  },
  {
    path: '/admin/gestionUtilisateurs',
    name: 'admin_gestion_utilisateurs',
   component: () => import('@/views/admin/gestionUser.vue'),
   
  },
  
  {
    path: '/admin/profile',
    name: 'admin_profile',
    component: () => import('@/views/pages/account-settings/AccountSettings.vue'),
  },
  /*user routes*/
  {
    path: '/user/dashboard',
    name: 'user_dashboard',
    component: () => import('@/views/user/userDashboard.vue'),
  },
  
  {
    path: '/user/profile',
    name: 'user_profile',
    component: () => import('@/views/pages/account-settings/AccountSettings.vue'),
  },
  {
    path: '/user/reservations',
    name: 'user_reservations',
    //component: () => import('@/views/pages/Login.vue'),
  },
  {
    path: '/user/seances',
    name: 'user_seances',
    //component: () => import('@/views/pages/Login.vue'),
  },
  {
    path: '/user/films',
    name: 'user_films',
    //component: () => import('@/views/pages/Login.vue'),
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
});


export default router
