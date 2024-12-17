<template>
    <div class="bg-white p-4 rounded-lg border border-gray-200">
      <h3 class="text-lg font-medium text-gray-900 mb-4">Filters</h3>
      
      <!-- Priority Filter -->
      <div class="mb-4">
        <BaseSelect
          v-model="localFilters.priority"
          :options="priorityOptions"
          label="Priority"
          placeholder="All priorities"
          @change="updateFilters"
        />
      </div>
  
      <!-- Due Date Filter -->
      <div class="mb-4">
        <BaseSelect
          v-model="localFilters.due_date"
          :options="dueDateOptions"
          label="Due Date"
          placeholder="All dates"
          @change="updateFilters"
        />
      </div>
  
      <!-- Categories Filter -->
      <div class="mb-4">
        <label class="block mb-1 text-sm font-medium text-gray-700">
          Categories
        </label>
        <div class="space-y-2 max-h-48 overflow-y-auto">
          <label
            v-for="category in categories"
            :key="category.id"
            class="flex items-center gap-2 p-2 hover:bg-gray-50 rounded cursor-pointer"
          >
            <input
              type="checkbox"
              :value="category.id"
              v-model="localFilters.category_ids"
              class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
              @change="updateFilters"
            />
            <span class="text-sm text-gray-700">{{ category.name }}</span>
          </label>
        </div>
      </div>
  
      <!-- Completion Status -->
      <div class="mb-4">
        <BaseSelect
          v-model="localFilters.is_completed"
          :options="statusOptions"
          label="Status"
          placeholder="All tasks"
          @change="updateFilters"
        />
      </div>
  
      <!-- Clear Filters -->
      <BaseButton
        variant="secondary"
        class="w-full"
        @click="clearFilters"
      >
        Clear All Filters
      </BaseButton>
    </div>
  </template>
  
  <script setup lang="ts">
  import { ref, watch } from 'vue'
  import BaseSelect from '../common/BaseSelect.vue'
  import BaseButton from '../common/BaseButton.vue'
  
  interface Category {
    id: number
    name: string
  }
  
  interface Filters {
    priority: string | null
    due_date: string | null
    category_ids: number[]
    is_completed: boolean | null
  }
  
  interface Props {
    categories: Category[]
    modelValue: Filters
  }
  
  const props = defineProps<Props>()
  
  const emit = defineEmits<{
    (e: 'update:modelValue', filters: Filters): void
  }>()
  
  const localFilters = ref<Filters>({
    priority: null,
    due_date: null,
    category_ids: [],
    is_completed: null,
  })
  
  const priorityOptions = [
    { label: 'High Priority', value: 'high' },
    { label: 'Medium Priority', value: 'medium' },
    { label: 'Low Priority', value: 'low' },
  ]
  
  const dueDateOptions = [
    { label: 'Today', value: 'today' },
    { label: 'This Week', value: 'week' },
    { label: 'This Month', value: 'month' },
    { label: 'Overdue', value: 'overdue' },
  ]
  
  const statusOptions = [
    { label: 'Completed', value: true },
    { label: 'Active', value: false },
  ]
  
  watch(
    () => props.modelValue,
    (newValue) => {
      localFilters.value = { ...newValue }
    },
    { immediate: true }
  )
  
  const updateFilters = () => {
    emit('update:modelValue', { ...localFilters.value })
  }
  
  const clearFilters = () => {
    localFilters.value = {
      priority: null,
      due_date: null,
      category_ids: [],
      is_completed: null,
    }
    updateFilters()
  }
  </script>