<template>
  <header>
    <nav>
      <div v-if="authStore.user" class="user-info">
        Привет, <strong>{{ authStore.user.name }}</strong> |
        <router-link to="/admin/news" class="admin-link">Админка</router-link> |
        <button @click="logout" class="btn-logout">Выйти</button>
      </div>
      <div v-else class="guest-links">
        <router-link to="/news" class="news-link">Новости</router-link> |
        <a href="http://localhost:5173/admin/login" class="login-link">Войти</a>
      </div>
    </nav>
  </header>
</template>

<script setup>
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

const authStore = useAuthStore()
const router = useRouter()

function logout() {
  authStore.logout()
  router.push('/')
}
</script>

<style scoped>
header {
  background-color: #2c3e50;
  padding: 12px 24px;
  color: #ecf0f1;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

nav {
  display: flex;
  justify-content: flex-end;
  align-items: center;
  gap: 10px;
}

.user-info,
.guest-links {
  font-size: 16px;
  display: flex;
  align-items: center;
  gap: 10px;
}

.admin-link,
.news-link,
.login-link {
  color: #3498db;
  text-decoration: none;
  font-weight: 600;
  cursor: pointer;
}

.admin-link:hover,
.news-link:hover,
.login-link:hover {
  text-decoration: underline;
  color: #2980b9;
}

.btn-logout {
  background-color: #e74c3c;
  border: none;
  color: white;
  padding: 6px 14px;
  border-radius: 4px;
  cursor: pointer;
  font-weight: 600;
  transition: background-color 0.3s ease;
}

.btn-logout:hover {
  background-color: #c0392b;
}
</style>