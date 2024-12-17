import api from './api'

export const taskService = {
  /**
   * Get all tasks with optional filters
   */
  getTasks(filters = {}) {
    return api.get('/tasks', { params: filters })
  },

  /**
   * Get task statistics
   */
  getTaskStats() {
    return api.get('/tasks/stats')
  },

  /**
   * Get a specific task by ID
   */
  getTask(taskId) {
    return api.get(`/tasks/${taskId}`)
  },

  /**
   * Create a new task
   */
  createTask(taskData) {
    return api.post('/tasks', taskData)
  },

  /**
   * Update an existing task
   */
  updateTask(taskId, taskData) {
    return api.put(`/tasks/${taskId}`, taskData)
  },

  /**
   * Delete a task
   */
  deleteTask(taskId) {
    return api.delete(`/tasks/${taskId}`)
  },

  /**
   * Toggle task completion status
   */
  toggleTaskComplete(taskId) {
    return api.patch(`/tasks/${taskId}/toggle-complete`)
  }
}