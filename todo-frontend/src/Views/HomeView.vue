<template>
  <div class="container mx-auto px-4 py-8">
    <!-- Stats Section -->
    <TaskStats :stats="taskStats" class="mb-8" />

    <div class="flex flex-col lg:flex-row gap-8">
      <!-- Filters Sidebar -->
      <div class="w-full lg:w-64">
        <TaskFilters v-model="filters" :categories="categories" />
      </div>

      <!-- Main Content -->
      <div class="flex-1">
        <!-- Header with Create Task Button -->
        <div class="flex justify-between items-center mb-6">
          <h1 class="text-2xl font-bold text-gray-900">Tasks</h1>
          <BaseButton variant="primary" @click="openTaskModal()">
            Create Task
          </BaseButton>
        </div>

        <!-- Tasks List -->
        <div v-if="isLoading" class="text-center py-8">
          Loading...
        </div>
        <div v-else-if="error" class="text-center py-8 text-red-600">
          {{ error }}
        </div>
        <div v-else>
          <!-- Active Tasks -->
          <div class="mb-8">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Active Tasks</h2>
            <div class="space-y-4">
              <TaskItem v-for="task in activeTasks" :key="task.id" :task="task" @toggle-complete="handleToggleComplete"
                @edit="openTaskModal" @delete="confirmDeleteTask" />
            </div>
          </div>

          <!-- Completed Tasks -->
          <div v-if="completedTasks.length">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Completed Tasks</h2>
            <div class="space-y-4">
              <TaskItem v-for="task in completedTasks" :key="task.id" :task="task"
                @toggle-complete="handleToggleComplete" @edit="openTaskModal" @delete="confirmDeleteTask" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Task Modal -->
    <Dialog v-model:visible="showTaskModal" :header="selectedTask ? 'Edit Task' : 'Create Task'" modal class="p-fluid">
      <TaskForm :task="selectedTask" :categories="categories" :loading="isSubmitting" @submit="handleTaskSubmit"
        @cancel="closeTaskModal" />
    </Dialog>
  </div>
</template>

<script setup>
import { ref, computed, onMounted, watch } from 'vue'
import Dialog from 'primevue/dialog'
import TaskStats from '../components/tasks/TaskStats.vue'
import TaskFilters from '../components/tasks/TaskFilters.vue'
import TaskItem from '../components/tasks/TaskItem.vue'
import TaskForm from '../components/tasks/TaskForm.vue'
import BaseButton from '../components/common/BaseButton.vue'
import { useTasks } from '../composables/useTasks'
import { useCategories } from '../composables/useCategories'
import { useFilters } from '../composables/useFilters'

// Composables
const {
  tasks,
  stats: taskStats,
  isLoading,
  error,
  fetchTasks,
  createTask,
  updateTask,
  deleteTask,
  toggleTaskComplete,
  fetchTaskStats
} = useTasks()

const {
  categories,
  fetchCategories
} = useCategories()

const { filters } = useFilters()

// Local state
const showTaskModal = ref(false)
const selectedTask = ref(null)
const isSubmitting = ref(false)

// Computed properties
const activeTasks = computed(() => {
  return tasks.value.filter(task => !task.is_completed)
}
)

const completedTasks = computed(() =>
  tasks.value.filter(task => task.is_completed)
)

// Methods
const openTaskModal = (task = null) => {
  if (task) {
    // Format the due date to local datetime-local format
    const dueDate = task.due_date ? new Date(task.due_date).toISOString().slice(0, 16) : '';

    selectedTask.value = {
      ...task,
      due_date: dueDate,
      category_ids: task.categories.map(cat => cat.id)
    }
  } else {
    selectedTask.value = null
  }
  showTaskModal.value = true
}

const closeTaskModal = () => {
  selectedTask.value = null
  showTaskModal.value = false
}

const handleToggleComplete = async (task) => {
  await toggleTaskComplete(task.id)
  await fetchTaskStats()
}

const handleTaskSubmit = async (taskData) => {
  isSubmitting.value = true
  try {
    if (selectedTask.value) {
      const updatedTask = await updateTask(selectedTask.value.id, taskData)
      // Find and update the task in the existing tasks array
      const index = tasks.value.findIndex(t => t.id === selectedTask.value.id)
      if (index !== -1) {
        tasks.value[index] = updatedTask
      }
    } else {
      const newTask = await createTask(taskData)
      // Add the new task to the tasks array
      tasks.value.unshift(newTask) // Add to beginning of array
    }
    closeTaskModal()
    // Refresh the tasks to ensure everything is in sync
    await fetchTasks(filters.value)
    await fetchTaskStats()
  } catch (err) {
    console.error('Failed to save task:', err)
  } finally {
    isSubmitting.value = false
  }
}

const confirmDeleteTask = async (task) => {
  if (confirm('Are you sure you want to delete this task?')) {
    await deleteTask(task.id)
    await fetchTaskStats()
  }
}

// Watch for filter changes
watch(filters, () => {
  fetchTasks(filters.value)
}, { deep: true })

// Initial data fetch
onMounted(async () => {
  await Promise.all([
    fetchTasks(),
    fetchCategories()
  ])
})
</script>