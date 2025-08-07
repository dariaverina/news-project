<template>
  <div>
    <h1>Управление новостями</h1>
    <button @click="fetchNews">Обновить список</button>
    <ul>
      <li v-for="news in newsList" :key="news.id">
        {{ news.title }}
        <button @click="editNews(news.id)">Редактировать</button>
        <button @click="deleteNews(news.id)">Удалить</button>
      </li>
    </ul>

    <!-- Здесь можно добавить форму для создания/редактирования -->
  </div>
</template>

<script>
import axios from '../axios'
import { useRouter } from 'vue-router'

export default {
  data() {
    return {
      newsList: []
    }
  },
  methods: {
    async fetchNews() {
      const response = await axios.get('/news')
      this.newsList = response.data
    },
    editNews(id) {
      // реализуй переход на страницу редактирования (если будет)
      alert('Редактирование новостей пока не реализовано')
    },
    async deleteNews(id) {
      if(confirm('Удалить новость?')) {
        await axios.delete(`/news/${id}`)
        this.fetchNews()
      }
    }
  },
  created() {
    this.fetchNews()
  }
}
</script>