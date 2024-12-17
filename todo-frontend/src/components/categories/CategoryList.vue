<template>
    <div class="space-y-4">
      <!-- Header with add button -->
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold text-gray-900">Categories</h2>
        <BaseButton 
          variant="primary"
          size="sm"
          @click="$emit('create')"
        >
          Add Category
        </BaseButton>
      </div>
  
      <!-- Categories grid -->
      <div v-if="categories.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <CategoryItem
          v-for="category in categories"
          :key="category.id"
          :category="category"
          @edit="$emit('edit', $event)"
          @delete="$emit('delete', $event)"
        />
      </div>
      
      <!-- Empty state -->
      <div 
        v-else 
        class="text-center py-8 bg-gray-50 rounded-lg"
      >
        <p class="text-gray-500">No categories found</p>
        <BaseButton 
          variant="primary"
          class="mt-4"
          @click="$emit('create')"
        >
          Create New Category
        </BaseButton>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import BaseButton from '../common/BaseButton.vue'
  import CategoryItem from './CategoryItem.vue'
  
  interface Category {
    id: number
    name: string
    tasks_count?: number
  }
  
  interface Props {
    categories: Category[]
  }
  
  defineProps<Props>()
  
  defineEmits<{
    (e: 'create'): void
    (e: 'edit', category: Category): void
    (e: 'delete', category: Category): void
  }>()
  </script>