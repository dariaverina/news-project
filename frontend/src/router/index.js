import { createRouter, createWebHistory } from 'vue-router'
import AdminLogin from '../pages/AdminLogin.vue'
import AdminNews from '../pages/AdminNews.vue'
import NewsList from '../pages/NewsList.vue'
import NewsDetail from '../pages/NewsDetail.vue'
import { useAuthStore } from '../stores/auth'

const routes = [
  { path: '/admin/login', component: AdminLogin },
  { path: '/admin/news', component: AdminNews, meta: { requiresAuth: true } },
  { path: '/news', component: NewsList },
  { path: '/news/:slug', component: NewsDetail },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach(async (to, from, next) => {
  const auth = useAuthStore()

  if (!auth.user) {
    await auth.checkAuth()
  }

  if (to.meta.requiresAuth && !auth.user) {
    next('/admin/login')
  } else {
    next()
  }
})

export default router