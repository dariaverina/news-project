import { createRouter, createWebHistory } from 'vue-router'
import NewsList from '../pages/NewsList.vue'
import NewsDetail from '../pages/NewsDetail.vue'
import AdminLogin from '../pages/AdminLogin.vue'
import AdminNews from '../pages/AdminNews.vue'

const routes = [
  { path: '/news', component: NewsList },
  { path: '/news/:slug', component: NewsDetail, props: true },
  { path: '/admin/login', component: AdminLogin },
  { path: '/admin/news', component: AdminNews, meta: { requiresAuth: true } },
  { path: '/', redirect: '/news' }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const isAuthenticated = !!localStorage.getItem('token') 
  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/admin/login')
  } else {
    next()
  }
})

export default router