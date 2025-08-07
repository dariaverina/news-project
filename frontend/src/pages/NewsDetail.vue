<template>
  <div v-if="news" class="news-detail">
    <h1 class="news-title">{{ news.title }}</h1>
    <p class="news-content" v-html="news.content"></p>
    <p class="news-date" v-if="news.published_at">Опубликовано: {{ formatDate(news.published_at) }}</p>
  </div>
  <div v-else class="loading">Загрузка...</div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from '../axios'
import { useRoute } from 'vue-router'

const route = useRoute()
const slug = route.params.slug || ''

const news = ref(null)

async function fetchNews() {
  try {
    const response = await axios.get(`/news/${slug}`)
    news.value = response.data
  } catch (error) {
    news.value = null
    console.error('Ошибка загрузки новости:', error)
  }
}

function formatDate(dateString) {
  if (!dateString) return ''
  const date = new Date(dateString)
  return date.toLocaleDateString('ru-RU', {
    year: 'numeric',
    month: 'long',
    day: 'numeric'
  })
}

async function updatePublishStatus() {
  try {
    await axios.patch(`/news/${slug}`, {
      is_published: news.value.is_published
    })
  } catch (error) {
    console.error('Ошибка при обновлении публикации', error)
    news.value.is_published = !news.value.is_published
  }
}

onMounted(() => {
  fetchNews()
})
</script>

<style scoped>
.news-detail {
  max-width: 700px;
  margin: 40px auto;
  padding: 0 15px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #333;
}

.news-title {
  font-size: 2.2rem;
  font-weight: 700;
  margin-bottom: 15px;
  color: #2c3e50;
}

.news-content {
  font-size: 1.15rem;
  line-height: 1.6;
  white-space: pre-line;
}

.news-date {
  margin-top: 25px;
  font-style: italic;
  color: #666;
}

.loading {
  text-align: center;
  padding: 50px 0;
  font-size: 1.2rem;
  color: #999;
}
</style>