<template>
    <Button
      :class="[
        'font-semibold',
        variantClasses[variant],
        sizeClasses[size],
        { 'opacity-50 cursor-not-allowed': disabled }
      ]"
      :disabled="disabled || loading"
      :loading="loading"
      v-bind="$attrs"
    >
      <slot />
    </Button>
  </template>
  
  <script setup lang="ts">
  import Button from 'primevue/button'
  
  interface Props {
    variant?: 'primary' | 'secondary' | 'danger' | 'text'
    size?: 'sm' | 'md' | 'lg'
    disabled?: boolean
    loading?: boolean
  }
  
  const props = withDefaults(defineProps<Props>(), {
    variant: 'primary',
    size: 'md',
    disabled: false,
    loading: false
  })
  
  const variantClasses = {
    primary: 'bg-blue-600 hover:bg-blue-700 text-white',
    secondary: 'bg-gray-500 hover:bg-gray-600 text-white',
    danger: 'bg-red-600 hover:bg-red-700 text-white',
    text: 'bg-transparent hover:bg-gray-100 text-gray-700'
  }
  
  const sizeClasses = {
    sm: 'px-3 py-1.5 text-sm',
    md: 'px-4 py-2 text-base',
    lg: 'px-6 py-3 text-lg'
  }
  </script>