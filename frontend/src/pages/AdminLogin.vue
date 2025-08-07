<template>
  <div class="login-wrapper">
    <template v-if="auth.user">
      <p>Вы уже авторизованы как <strong>{{ auth.user.name }}</strong>.</p>
      <a href="/admin/news" class="btn">Перейти в управление новостями</a>
      <button @click="logout" class="btn btn-logout">Выйти</button>
    </template>

    <template v-else>
      <form @submit.prevent="submit" class="login-form">
        <input v-model="email" type="email" placeholder="Email" required />
        <input v-model="password" type="password" placeholder="Пароль" required />
        <button type="submit">Войти</button>
        <p v-if="error" class="error-message">{{ error }}</p>
      </form>
    </template>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

const auth = useAuthStore()
const router = useRouter()

const email = ref('')
const password = ref('')
const error = ref(null)

onMounted(async () => {
  await auth.checkAuth()
  if (auth.user) {
    router.push('/admin/news')
  }
})

async function submit() {
  try {
    error.value = null
    await auth.login(email.value, password.value)
    router.push('/admin/news')
  } catch (e) {
    error.value = e.message || 'Ошибка входа'
  }
}

function logout() {
  auth.logout()
}
</script>

<style scoped>
.login-wrapper {
  max-width: 320px;
  margin: 50px auto;
  font-family: Arial, sans-serif;
}

.login-form input {
  width: 100%;
  padding: 8px 10px;
  margin-bottom: 12px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

.login-form button {
  width: 100%;
  padding: 10px;
  background-color: #3498db;
  border: none;
  color: white;
  font-weight: 600;
  border-radius: 4px;
  cursor: pointer;
}

.login-form button:hover {
  background-color: #2980b9;
}

.error-message {
  color: #e74c3c;
  margin-top: 8px;
  font-size: 14px;
}

.btn {
  display: inline-block;
  padding: 8px 16px;
  background-color: #2ecc71;
  color: white;
  text-decoration: none;
  border-radius: 4px;
  margin-right: 10px;
}

.btn-logout {
  background-color: #e74c3c;
  border: none;
  color: white;
  padding: 8px 16px;
  border-radius: 4px;
  cursor: pointer;
}

.btn-logout:hover {
  background-color: #c0392b;
}
</style>