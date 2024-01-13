import {createRouter, createWebHistory, RouteRecordRaw} from "vue-router";

const routes: Array<RouteRecordRaw> = [
  {
    name: 'HomePage',
    path: '/',
    meta: {
      requiresAuth: true,
    },
    redirect: '/admin',
  },
  {
    name: 'ProjectsPage',
    path: '/admin',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/ProjectsPage.vue')
  },
  {
    name: 'Login',
    path: '/login',
    meta: {
      onlyGuests: true,
    },
    component: () => import('@/views/Auth/LoginPage.vue')
  },
  {
    name: 'Registration',
    path: '/register',
    meta: {
      onlyGuests: true,
    },
    component: () => import('@/views/Auth/RegisterPage.vue')
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router
