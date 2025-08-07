<template>
  <div>
    <h1>Новости</h1>
    <ul>
      <li v-for="news in newsList" :key="news.id">
        <router-link :to="`/news/${news.slug}`">{{ news.title }}</router-link>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from '../axios'

export default {
  data() {
    return {
      newsList: []
    }
  },
  async created() {
    const response = await axios.get('/news')
    this.newsList = response.data
  }
}
</script>