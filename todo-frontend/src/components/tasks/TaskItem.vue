<template>
    <div 
      :class="[
        'p-4 rounded-lg border transition-colors duration-200',
        task.is_completed ? 'bg-gray-50 border-gray-200' : 'bg-white border-gray-300',
        'hover:border-gray-400'
      ]"
    >
      <div class="flex items-start justify-between gap-4">
        <!-- Task info -->
        <div class="flex-1">
          <div class="flex items-center gap-3">
            <input
              type="checkbox"
              :checked="task.is_completed"
              @change="$emit('toggle-complete', task)"
              class="h-5 w-5 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
            />
            <h3 
              :class="[
                'text-lg font-medium',
                task.is_completed ? 'text-gray-500 line-through' : 'text-gray-900'
              ]"
            >
              {{ task.description }}
            </h3>
          </div>
          
          <div class="mt-2 flex flex-wrap items-center gap-3">
            <!-- Priority badge -->
            <span 
              :class="[
                'inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium',
                priorityClasses[task.priority]
              ]"
            >
              {{ task.priority }}
            </span>
            
            <!-- Due date -->
            <span 
              v-if="task.due_date"
              :class="[
                'text-sm',
                isOverdue ? 'text-red-600' : 'text-gray-500'
              ]"
            >
              Due {{ formatDate(task.due_date) }}
            </span>
            
            <!-- Categories -->
            <div class="flex flex-wrap gap-2">
              <span
                v-for="category in task.categories"
                :key="category.id"
                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800"
              >
                {{ category.name }}
              </span>
            </div>
          </div>
        </div>
        
        <!-- Actions -->
        <div class="flex items-center gap-2">
          <BaseButton
            variant="text"
            size="sm"
            @click="$emit('edit', task)"
          >
            Edit
          </BaseButton>
          <BaseButton
            variant="danger"
            size="sm"
            @click="$emit('delete', task)"
          >
            Delete
          </BaseButton>
        </div>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { computed } from 'vue'
  import BaseButton from '../common/BaseButton.vue'
  
  interface Task {
    id: number
    description: string
    due_date: string
    priority: 'high' | 'medium' | 'low'
    is_completed: boolean
    categories: Array<{ id: number; name: string }>
  }
  
  interface Props {
    task: Task
  }
  
  const props = defineProps<Props>()
  
  const emit = defineEmits<{
    (e: 'toggle-complete', task: Task): void
    (e: 'edit', task: Task): void
    (e: 'delete', task: Task): void
  }>()
  
  const priorityClasses = {
    high: 'bg-red-100 text-red-800',
    medium: 'bg-yellow-100 text-yellow-800',
    low: 'bg-green-100 text-green-800'
  }
  
  const isOverdue = computed(() => {
    if (!props.task.due_date || props.task.is_completed) return false
    return new Date(props.task.due_date) < new Date()
  })
  
  const formatDate = (date: string) => {
    return new Date(date).toLocaleDateString('en-US', {
      month: 'short',
      day: 'numeric',
      hour: 'numeric',
      minute: '2-digit'
    })
  }
  </script>