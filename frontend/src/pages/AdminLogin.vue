<template>
  <div>
    <h1>Вход в админку</h1>
    <form @submit.prevent="submit">
      <input v-model="username" placeholder="Логин" />
      <input type="password" v-model="password" placeholder="Пароль" />
      <button type="submit">Войти</button>
    </form>
    <div v-if="error" style="color: red;">{{ error }}</div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useAuthStore } from '../stores/auth'
import { useRouter } from 'vue-router'

const username = ref('')
const password = ref('')
const error = ref('')

const auth = useAuthStore()
const router = useRouter()

async function submit() {
  const success = await auth.login(username.value, password.value)
  if (success) {
    router.push('/admin/news')
  } else {
    error.value = 'Неверный логин или пароль'
  }
}
</script>