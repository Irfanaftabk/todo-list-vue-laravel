<template>
    <form @submit.prevent="handleSubmit" class="space-y-6">
      <!-- Category Name -->
      <BaseInput
        v-model="formData.name"
        label="Category Name"
        placeholder="Enter category name"
        :error="errors.name"
        :class="['p-2']"
        required
      />
  
      <!-- Form Actions -->
      <div class="flex justify-end gap-2 pt-4">
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
          {{ category ? 'Update Category' : 'Create Category' }}
        </BaseButton>
      </div>
    </form>
  </template>
  
  <script setup lang="ts">
  import { ref, onMounted } from 'vue'
  import BaseInput from '../common/BaseInput.vue'
  import BaseButton from '../common/BaseButton.vue'
  
  interface Category {
    id?: number
    name: string
  }
  
  interface Props {
    category?: Category
    loading?: boolean
  }
  
  const props = withDefaults(defineProps<Props>(), {
    category: undefined,
    loading: false
  })
  
  const emit = defineEmits<{
    (e: 'submit', category: Partial<Category>): void
    (e: 'cancel'): void
  }>()
  
  const formData = ref({
    name: '',
  })
  
  const errors = ref({
    name: '',
  })
  
  onMounted(() => {
    if (props.category) {
      formData.value = {
        name: props.category.name,
      }
    }
  })
  
  const validateForm = () => {
    errors.value = {
      name: '',
    }
  
    if (!formData.value.name.trim()) {
      errors.value.name = 'Category name is required'
    }
  
    if (formData.value.name.length > 50) {
      errors.value.name = 'Category name cannot exceed 50 characters'
    }
  
    return !Object.values(errors.value).some(error => error)
  }
  
  const handleSubmit = () => {
    if (validateForm()) {
      emit('submit', formData.value)
    }
  }
  </script>