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
    meta:{
      requiresAuth:true,
      authorize : 'admin'
    }
   
  },
  {
    path: '/admin/gestionSalles',
    name: 'admin_gestion_salles',
    component: () => import('@/views/admin/gestionSalle.vue'),
    meta:{requiresAuth:true,authorize : 'admin'}
   
  },
  {
    path: '/admin/gestionFilms',
    name: 'admin_gestion_films',
   // component: () => import('@/views/admin/gestionSalle.vue'),
   meta:{requiresAuth:true,authorize : 'admin'}
   
  },
  {
    path: '/admin/gestionSeances',
    name: 'admin_gestion_seances',
  //  component: () => import('@/views/admin/gestionSalle.vue'),
  meta:{requiresAuth:true,authorize : 'admin'}
   
  },
  {
    path: '/admin/gestionReservations',
    name: 'admin_gestion_reservations',
  //  component: () => import('@/views/admin/gestionSalle.vue'),
  meta:{requiresAuth:true,authorize : 'admin'}
   
  },
  {
    path: '/admin/gestionUtilisateurs',
    name: 'admin_gestion_utilisateurs',
   // component: () => import('@/views/admin/gestionSalle.vue'),
   meta:{requiresAuth:true,authorize : 'admin'}
   
  },
  
  {
    path: '/admin/profile',
    name: 'admin_profile',
    component: () => import('@/views/pages/account-settings/AccountSettings.vue'),
    meta:{requiresAuth:true,authorize : 'admin'}
  },
  /*user routes*/
  {
    path: '/user/dashboard',
    name: 'user_dashboard',
    component: () => import('@/views/user/userDashboard.vue'),
    meta:{requiresAuth:true,authorize : 'user'}
  },
  
  {
    path: '/user/profile/:id',
    name: 'user_profile',
    component: () => import('@/views/pages/account-settings/AccountSettings.vue'),
    props:true,
    meta:{requiresAuth:true,authorize : 'user'}
  },
  {
    path: '/user/reservations',
    name: 'user_reservations',
    //component: () => import('@/views/pages/Login.vue'),
    meta:{requiresAuth:true,authorize : 'user'}
  },
  {
    path: '/user/seances',
    name: 'user_seances',
    //component: () => import('@/views/pages/Login.vue'),
    meta:{requiresAuth:true,authorize : 'user'}
  },
  {
    path: '/user/films',
    name: 'user_films',
    //component: () => import('@/views/pages/Login.vue'),
    meta:{requiresAuth:true,authorize : 'user'}
  },
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes,
});

function isLoggedIn()
{
  return 'userToken' in sessionStorage;
}

function isAdmin()
{
  let user = JSON.parse(localStorage.getItem('currentUser'));
  return user.is_admin
}

//prevent user from accessing  routes without being connected
//and prevent user from accessing admin routes and vice versa
router.beforeEach((to,from,next)=>{
  if(to.meta.requiresAuth  && !isLoggedIn())
  {
      next({'name':'login'});
  }
  else {
    if(
      (to.meta.authorize == 'admin' && !isAdmin())
      || 
      (to.meta.authorize == 'user' && isAdmin())
      )
      next({'name':'error-404'});
    else
      next();

  }
});

export default router
