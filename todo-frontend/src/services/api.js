import axios from 'axios'

const api = axios.create({
  baseURL: import.meta.env.VITE_API_BASE_URL || 'http://localhost:8000/api',
  headers: {
    'Content-Type': 'application/json',
    'Accept': 'application/json'
  }
})

// Response interceptor for handling common errors
api.interceptors.response.use(
  response => response,
  error => {
    const { response } = error

    // Handle specific error cases
    if (response) {
      switch (response.status) {
        case 422: // Validation errors
          throw new Error(Object.values(response.data.errors)[0][0])
        case 404:
          throw new Error('Resource not found')
        case 500:
          throw new Error('Internal server error')
        default:
          throw new Error('An error occurred')
      }
    }

    throw new Error('Network error')
  }
)

export default api