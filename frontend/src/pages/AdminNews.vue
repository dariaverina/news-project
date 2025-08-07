<template>
  <div class="admin-wrapper">
    <h1>Управление новостями</h1>

    <button class="btn logout-btn" @click="logout">Выйти</button>

    <section class="create-news">
      <h2>Создать новость</h2>
      <input v-model="newTitle" placeholder="Заголовок" />
      <input v-model="newSlug" placeholder="Slug" />
      <textarea v-model="newContent" placeholder="Контент"></textarea>
      <button class="btn" @click="createNews">Создать</button>
    </section>

    <section class="news-list-section">
      <h2>Список новостей</h2>
      <ul class="news-list">
        <li v-for="item in newsList" :key="item.id" class="news-item">
          <div class="field-group">
            <label>Заголовок</label>
            <input v-model="item.title" placeholder="Заголовок" />
          </div>

          <div class="field-group">
            <label>Slug</label>
            <input v-model="item.slug" placeholder="Slug" />
          </div>

          <div class="field-group">
            <label>Контент</label>
            <textarea v-model="item.content" placeholder="Контент"></textarea>
          </div>

          <div class="field-group switch-group">
            <label>Опубликована</label>
            <label class="switch">
              <input type="checkbox" v-model="item.is_published" />
              <span class="slider"></span>
            </label>
          </div>

          <div class="field-group">
            <label>Дата публикации</label>
            <input type="date" v-model="item.published_at" />
          </div>

          <div class="actions">
            <button class="btn update-btn" @click="updateNews(item)">Обновить</button>
            <button class="btn delete-btn" @click="deleteNews(item.id)">Удалить</button>
          </div>
        </li>
      </ul>
    </section>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import axios from '../axios'
import { useAuthStore } from '../stores/auth'

const router = useRouter()
const auth = useAuthStore()

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL

const newsList = ref([])

const newTitle = ref('')
const newSlug = ref('')
const newContent = ref('')

async function loadNews() {
  try {
    const res = await axios.get(`${API_BASE_URL}/api/news`)
    newsList.value = res.data.map(item => ({
      ...item,
      published_at: item.published_at ? item.published_at.split('T')[0] : null,
      is_published: Boolean(item.is_published),
    }))
  } catch (e) {
    if (e.response?.status === 401) {
      router.push('/admin/login')
    }
  }
}

async function createNews() {
  try {
    await axios.post(`${API_BASE_URL}/api/news`, {
      title: newTitle.value,
      slug: newSlug.value,
      content: newContent.value,
      is_published: true,
      published_at: null,
    })
    newTitle.value = ''
    newSlug.value = ''
    newContent.value = ''
    await loadNews()
  } catch (e) {
    alert('Ошибка создания новости')
  }
}

async function updateNews(item) {
  try {
    await axios.put(`${API_BASE_URL}/api/news/${item.id}`, {
      title: item.title,
      slug: item.slug,
      content: item.content,
      is_published: item.is_published,
      published_at: item.published_at,
    })
    alert('Новость обновлена')
  } catch {
    alert('Ошибка обновления')
  }
}

async function deleteNews(id) {
  try {
    await axios.delete(`${API_BASE_URL}/api/news/${id}`)
    await loadNews()
  } catch {
    alert('Ошибка удаления')
  }
}

async function logout() {
  await auth.logout()
  router.push('/admin/login')
}

onMounted(() => {
  loadNews()
})
</script>

<style scoped>
.admin-wrapper {
  max-width: 900px;
  margin: 40px auto;
  padding: 0 20px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: #333;
}

h1, h2 {
  color: #2c3e50;
}

button {
  cursor: pointer;
  font-weight: 600;
  border-radius: 4px;
  border: none;
  transition: background-color 0.3s ease;
}

.btn {
  background-color: #3498db;
  color: white;
  padding: 8px 16px;
  margin-top: 10px;
  user-select: none;
}

.btn:hover {
  background-color: #2980b9;
}

.logout-btn {
  background-color: #e74c3c;
  float: right;
  margin-top: -40px;
  margin-bottom: 20px;
}

.logout-btn:hover {
  background-color: #c0392b;
}

.create-news,
.news-list-section {
  background-color: #f9f9f9;
  padding: 20px 25px;
  border-radius: 8px;
  box-shadow: 0 2px 5px rgb(0 0 0 / 0.1);
  margin-bottom: 30px;
}

input,
textarea {
  width: 100%;
  padding: 8px 10px;
  margin: 6px 0 12px 0;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
  font-size: 14px;
  resize: vertical;
  font-family: inherit;
  color: #333;
}

.news-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.news-item {
  background: white;
  padding: 20px 25px;
  margin-bottom: 20px;
  border-radius: 10px;
  box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
  display: flex;
  flex-direction: column;
  gap: 12px;
}

.field-group {
  display: flex;
  flex-direction: column;
  font-weight: 600;
  color: #444;
}

.field-group input,
.field-group textarea {
  margin-top: 6px;
  font-weight: 400;
}

.switch-group {
  display: flex;
  align-items: center;
  gap: 12px;
  font-weight: 600;
  color: #444;
}

.switch {
  position: relative;
  display: inline-block;
  width: 50px;
  height: 26px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
  position: absolute;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  border-radius: 26px;
  transition: 0.4s;
}

.slider::before {
  position: absolute;
  content: '';
  height: 20px;
  width: 20px;
  left: 3px;
  bottom: 3px;
  background-color: white;
  border-radius: 50%;
  transition: 0.4s;
}

.switch input:checked + .slider {
  background-color: #27ae60;
}

.switch input:checked + .slider::before {
  transform: translateX(24px);
}

.actions {
  display: flex;
  gap: 12px;
  justify-content: flex-start;
  flex-wrap: wrap;
  margin-top: 10px;
}

.update-btn {
  background-color: #27ae60;
}

.update-btn:hover {
  background-color: #1e8449;
}

.delete-btn {
  background-color: #e74c3c;
}

.delete-btn:hover {
  background-color: #c0392b;
}

.date-label {
  display: flex;
  flex-direction: column;
  font-weight: 600;
  color: #444;
  margin-bottom: 10px;
}

.date-label input {
  width: 150px;
  margin-top: 4px;
  padding: 6px 8px;
  font-size: 14px;
}
</style>