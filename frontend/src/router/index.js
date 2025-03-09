import Vue from 'vue'
import VueRouter from 'vue-router'
import Auth from '../components/Auth.vue'
import Dashboard from '../views/Dashboard.vue'
import WorkOrder from '../views/WorkOrder.vue'
import ReportView from '../views/Report.vue'
import TableTracking from '../components/TableTracking.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Auth
  },
  {
    path: '/dashboard',
    component: Dashboard,
    beforeEnter: (to, from, next) => {
      if (!localStorage.getItem('token')) {
        next({ name: 'Home' });
      } else {
        next(); 
      }
    },
    children: [
      {
        path: 'report',
        name: 'Report',
        component: ReportView
      },
      {
        path: 'tracking',
        name: 'tracking',
        component: TableTracking
      },
      {
        path: '',
        name: 'WorkOrder',
        component: WorkOrder
      },
    ]
  },
  {
    path: '/about',
    name: 'About',
    component: () => import(/* webpackChunkName: "about" */ '../views/About.vue')
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token');
  if (to.name === 'Dashboard' && !token) {
    next('/');
  } else if (to.name === 'Home' && token) {
    next('/dashboard');
  } else {
    next();
  }
});

export default router
