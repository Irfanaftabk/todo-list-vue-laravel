<template>
    <div class="p-4 rounded-lg border border-gray-300 bg-white hover:border-gray-400 transition-colors duration-200">
      <div class="flex items-start justify-between gap-4">
        <!-- Category info -->
        <div class="flex-1">
          <h3 class="text-lg font-medium text-gray-900">
            {{ category.name }}
          </h3>
          
          <div class="mt-2 text-sm text-gray-500">
            {{ taskCountText }}
          </div>
        </div>
        
        <!-- Actions -->
        <div class="flex items-center gap-2">
          <BaseButton
            variant="text"
            size="sm"
            @click="$emit('edit', category)"
          >
            Edit
          </BaseButton>
          <BaseButton
            variant="danger"
            size="sm"
            @click="confirmDelete"
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
  
  interface Category {
    id: number
    name: string
    tasks_count?: number
  }
  
  interface Props {
    category: Category
  }
  
  const props = defineProps<Props>()
  
  const emit = defineEmits<{
    (e: 'edit', category: Category): void
    (e: 'delete', category: Category): void
  }>()
  
  const taskCountText = computed(() => {
    const count = props.category.tasks_count || 0
    return `${count} ${count === 1 ? 'task' : 'tasks'}`
  })
  
  const confirmDelete = () => {
    if (props.category.tasks_count && props.category.tasks_count > 0) {
      if (confirm(`Are you sure you want to delete this category? It contains ${props.category.tasks_count} tasks.`)) {
        emit('delete', props.category)
      }
    } else {
      emit('delete', props.category)
    }
  }
  </script>