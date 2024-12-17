import { ref, computed } from 'vue'
import { taskService } from '../services/taskService'

export function useTasks() {
  const tasks = ref([])
  const isLoading = ref(false)
  const error = ref(null)

  // Task statistics
  const stats = ref({
    total: 0,
    completed: 0,
    pending: 0,
    high_priority: 0,
    overdue: 0
  })

  // Computed properties for filtered tasks
  const completedTasks = computed(() => 
    tasks.value.filter(task => task.is_completed)
  )

  const pendingTasks = computed(() => 
    tasks.value.filter(task => !task.is_completed)
  )

  // Fetch all tasks
  const fetchTasks = async (filters = {}) => {
    isLoading.value = true
    error.value = null
    try {
      const response = await taskService.getTasks(filters)
      console.log(`TASKsss***`, response.data)
      tasks.value = response.data.data;
      await fetchTaskStats()
    } catch (err) {
      error.value = err.message || 'Failed to fetch tasks'
    } finally {
      isLoading.value = false
    }
  }

  // Fetch task statistics
  const fetchTaskStats = async () => {
    try {
      const response = await taskService.getTaskStats()
      stats.value = response.data
    } catch (err) {
      console.error('Failed to fetch task statistics:', err)
    }
  }

  // Create a new task
  const createTask = async (taskData) => {
    isLoading.value = true
    error.value = null
    try {
      const response = await taskService.createTask(taskData)
      tasks.value.unshift(response.data.data)
      await fetchTaskStats()
      return response.data.data
    } catch (err) {
      error.value = err.message || 'Failed to create task'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  // Update an existing task
  const updateTask = async (taskId, taskData) => {
    isLoading.value = true
    error.value = null
    try {
      const response = await taskService.updateTask(taskId, taskData)
      const index = tasks.value.findIndex(t => t.id === taskId)
      if (index !== -1) {
        tasks.value[index] = response.data.data
      }
      await fetchTaskStats()
      return response.data.data
    } catch (err) {
      error.value = err.message || 'Failed to update task'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  // Delete a task
  const deleteTask = async (taskId) => {
    isLoading.value = true
    error.value = null
    try {
      await taskService.deleteTask(taskId)
      tasks.value = tasks.value.filter(t => t.id !== taskId)
      await fetchTaskStats()
    } catch (err) {
      error.value = err.message || 'Failed to delete task'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  // Toggle task completion status
  const toggleTaskComplete = async (taskId) => {
    isLoading.value = true
    error.value = null
    try {
      const response = await taskService.toggleTaskComplete(taskId)
      const updatedTask = response.data.data
      // Update the task in the local array
      const index = tasks.value.findIndex(t => t.id === taskId)
      if (index !== -1) {
        tasks.value[index] = updatedTask
      }
      return updatedTask
    } catch (err) {
      error.value = err.message || 'Failed to toggle task completion'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  return {
    tasks,
    completedTasks,
    pendingTasks,
    stats,
    isLoading,
    error,
    fetchTasks,
    createTask,
    updateTask,
    deleteTask,
    toggleTaskComplete,
    fetchTaskStats
  }
}
