import { defineStore } from 'pinia'
import axios from 'axios'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL;

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null,
  }),
  actions: {
    async login(email, password) {
      try {
        const response = await axios.post(
          `${API_BASE_URL}/api/login`,
          { email, password },
          { withCredentials: true }
        )
        if (response.data?.user) {
          this.user = response.data.user
        } else {
          await this.checkAuth()
        }
      } catch (error) {
        console.error('Login error:', error)
        throw new Error('Неверный логин или пароль')
      }
    },

    async logout() {
      try {
        await axios.post(`${API_BASE_URL}/api/logout`, {}, { withCredentials: true })
      } catch (e) {
        console.warn('Logout request failed')
      }
      this.user = null
      this.token = null
    },

    async checkAuth() {
      try {
        const response = await axios.get(`${API_BASE_URL}/api/check`, { withCredentials: true })

        if (response.data?.authenticated && response.data.user) {
          this.user = response.data.user
        } else {
          this.user = null
        }
      } catch (e) {
        console.warn('checkAuth error:', e)
        this.user = null
      }
    }
  }
})