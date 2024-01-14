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
    component: () => import('@/views/Pages/Projects/ProjectsPage.vue')
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
  {
    name: 'CreateProjectForm',
    path: '/admin/create-project',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Projects/ProjectForm.vue')
  },
  {
    name: 'EditProjectForm',
    path: '/admin/edit-project/:id',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Projects/ProjectForm.vue')
  },
  {
    name: 'TasksProject',
    path: '/admin/project-tasks/:id',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Tasks/TasksPage.vue')
  },
  {
    name: 'StatisticPage',
    path: '/admin/statistic',
    meta: {
      requiresAuth: true,
    },
    component: () => import('@/views/Pages/Statistic/StatisticPage.vue')
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

export default router
