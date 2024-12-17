<template>
    <div class="flex flex-col">
      <label v-if="label" :for="id" class="mb-1 text-sm font-medium text-gray-700">
        {{ label }}
        <span v-if="required" class="text-red-500">*</span>
      </label>
      <InputText
        :id="id"
        :value="modelValue"
        :class="[
          'rounded-lg px-2',
          'border border-gray-300',
          'transition-colors duration-200',
          'focus:border-blue-500 focus:ring-2 focus:ring-blue-500',
          { 'border-red-500 focus:border-red-500 focus:ring-red-500': !!error }
        ]"
        :disabled="disabled"
        :placeholder="placeholder"
        v-bind="$attrs"
        @input="handleInput"
      />
      <small v-if="error" class="mt-1 text-red-500">{{ error }}</small>
      <small v-else-if="hint" class="mt-1 text-gray-500">{{ hint }}</small>
    </div>
  </template>
  
  <script setup lang="ts">
  import InputText from 'primevue/inputtext'
  
  interface Props {
    modelValue: string
    label?: string
    placeholder?: string
    hint?: string
    error?: string
    required?: boolean
    disabled?: boolean
    id?: string
  }
  
  const props = withDefaults(defineProps<Props>(), {
    modelValue: '',
    label: undefined,
    placeholder: '',
    hint: undefined,
    error: undefined,
    required: false,
    disabled: false,
    id: undefined
  })
  
  const emit = defineEmits<{
    (e: 'update:modelValue', value: string): void
  }>()
  
  const handleInput = (event: Event) => {
    const target = event.target as HTMLInputElement
    emit('update:modelValue', target.value)
  }
  </script>