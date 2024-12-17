<template>
    <form @submit.prevent="handleSubmit" class="space-y-6">
      <!-- Description -->
      <BaseInput
        v-model="formData.description"
        label="Task Description"
        placeholder="Enter task description"
        :error="errors.description"
        required
        class="py-3"
      />
  
      <!-- Due Date -->
      <div class="flex gap-4">
        <BaseInput
          v-model="formData.due_date"
          type="datetime-local"
          label="Due Date"
          :error="errors.due_date"
          class="flex-1"
        />
  
        <!-- Priority -->
        <BaseSelect
          v-model="formData.priority"
          :options="priorityOptions"
          label="Priority"
          :error="errors.priority"
          class="w-48"
          required
        />
      </div>
  
      <!-- Categories -->
      <div>
        <label class="block mb-1 text-sm font-medium text-gray-700">
          Categories
        </label>
        <div class="flex flex-wrap gap-2 p-2 border rounded-lg">
          <div
            v-for="category in categories"
            :key="category.id"
            :class="[
              'inline-flex items-center px-3 py-1 rounded-full text-sm cursor-pointer transition-colors',
              formData.category_ids.includes(category.id)
                ? 'bg-blue-100 text-blue-800'
                : 'bg-gray-100 text-gray-700 hover:bg-gray-200'
            ]"
            @click="toggleCategory(category.id)"
          >
            {{ category.name }}
          </div>
        </div>
        <small v-if="errors.category_ids" class="mt-1 text-red-500">
          {{ errors.category_ids }}
        </small>
      </div>
  
      <!-- Form Actions -->
      <div class="flex justify-end gap-3 pt-4">
        <BaseButton
          type="button"
          variant="secondary"
          @click="$emit('cancel')"
        >
          Cancel
        </BaseButton>
        <BaseButton
          type="submit"
          variant="primary"
          :loading="loading"
        >
          {{ task ? 'Update Task' : 'Create Task' }}
        </BaseButton>
      </div>
    </form>
  </template>
  
  <script setup lang="ts">
  import { ref, onMounted } from 'vue'
  import BaseInput from '../common/BaseInput.vue'
  import BaseSelect from '../common/BaseSelect.vue'
  import BaseButton from '../common/BaseButton.vue'
  
  interface Task {
    id?: number
    description: string
    due_date?: string
    priority: 'high' | 'medium' | 'low'
    is_completed: boolean
    category_ids: number[]
  }
  
  interface Category {
    id: number
    name: string
  }
  
  interface Props {
    task?: Task
    categories: Category[]
    loading?: boolean
  }
  
  const props = withDefaults(defineProps<Props>(), {
    task: undefined,
    loading: false
  })
  
  const emit = defineEmits<{
    (e: 'submit', task: Partial<Task>): void
    (e: 'cancel'): void
  }>()
  
  const priorityOptions = [
    { label: 'High Priority', value: 'high' },
    { label: 'Medium Priority', value: 'medium' },
    { label: 'Low Priority', value: 'low' },
  ]
  
  const formData = ref({
    description: '',
    due_date: '',
    priority: 'medium' as 'high' | 'medium' | 'low',
    category_ids: [] as number[],
  })
  
  const errors = ref({
    description: '',
    due_date: '',
    priority: '',
    category_ids: '',
  })
  
  onMounted(() => {
    if (props.task) {
      formData.value = {
        description: props.task.description,
        due_date: props.task.due_date || '',
        priority: props.task.priority,
        category_ids: props.task.category_ids,
      }
    }
  })
  
  const toggleCategory = (categoryId: number) => {
    const index = formData.value.category_ids.indexOf(categoryId)
    if (index === -1) {
      formData.value.category_ids.push(categoryId)
    } else {
      formData.value.category_ids.splice(index, 1)
    }
  }
  
  const validateForm = () => {
    errors.value = {
      description: '',
      due_date: '',
      priority: '',
      category_ids: '',
    }
  
    if (!formData.value.description.trim()) {
      errors.value.description = 'Description is required'
    }
  
    if (formData.value.due_date && new Date(formData.value.due_date) < new Date()) {
      errors.value.due_date = 'Due date must be in the future'
    }
  
    return !Object.values(errors.value).some(error => error)
  }
  
  const handleSubmit = () => {
    if (validateForm()) {
      emit('submit', formData.value)
    }
  }
  </script>