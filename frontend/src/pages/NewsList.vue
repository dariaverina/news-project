<template>
  <div class="news-list-wrapper">
    <h1>Новости</h1>
    <ul class="news-list">
      <li v-for="news in newsList" :key="news.id" class="news-item">
        <router-link :to="`/news/${news.slug}`" class="news-link">
          {{ news.title }}
        </router-link>
      </li>
    </ul>
    <div v-if="loading" class="loading">Загрузка новостей...</div>
    <div v-if="error" class="error">Ошибка загрузки новостей</div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '../axios'

const newsList = ref([])
const loading = ref(false)
const error = ref(false)

async function fetchNews() {
  loading.value = true
  error.value = false
  try {
    const response = await axios.get('/news')
    newsList.value = response.data
  } catch (e) {
    error.value = true
  } finally {
    loading.value = false
  }
}

onMounted(() => {
  fetchNews()
})
</script>

<style scoped>
.news-list-wrapper {
  max-width: 700px;
  margin: 40px auto;
  padding: 0 15px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #333;
}

h1 {
  font-size: 2rem;
  margin-bottom: 20px;
  color: #2c3e50;
}

.news-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.news-item {
  margin-bottom: 15px;
  padding-bottom: 8px;
  border-bottom: 1px solid #ddd;
}

.news-link {
  font-size: 1.2rem;
  color: #3498db;
  text-decoration: none;
  transition: color 0.3s ease;
}

.news-link:hover {
  color: #2980b9;
  text-decoration: underline;
}

.loading {
  margin-top: 20px;
  color: #666;
  font-style: italic;
}

.error {
  margin-top: 20px;
  color: #e74c3c;
  font-weight: 600;
}
</style>