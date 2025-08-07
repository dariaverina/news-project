<template>
  <div v-if="news">
    <h1>{{ news.title }}</h1>
    <p>{{ news.content }}</p>
  </div>
  <div v-else>Загрузка...</div>
</template>

<script>
import axios from '../axios'

export default {
  props: ['slug'],
  data() {
    return {
      news: null
    }
  },
  async created() {
    try {
      const response = await axios.get(`/news/${this.slug}`)
      this.news = response.data
    } catch {
      this.news = null
    }
  }
}
</script>