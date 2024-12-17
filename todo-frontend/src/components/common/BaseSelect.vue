<template>
    <div class="flex flex-col">
      <label v-if="label" :for="id" class="mb-1 text-sm font-medium text-gray-700">
        {{ label }}
        <span v-if="required" class="text-red-500">*</span>
      </label>
      <Dropdown
        :id="id"
        v-model="selectedValue"
        :options="options"
        :optionLabel="optionLabel"
        :optionValue="optionValue"
        :placeholder="placeholder"
        :disabled="disabled"
        :class="[
          'w-full',
          'rounded-lg',
          'border border-gray-300',
          'transition-colors duration-200',
          { 'border-red-500': !!error }
        ]"
        @change="handleChange"
      />
      <small v-if="error" class="mt-1 text-red-500">{{ error }}</small>
      <small v-else-if="hint" class="mt-1 text-gray-500">{{ hint }}</small>
    </div>
  </template>
  
  <script setup lang="ts">
  import { computed } from 'vue'
  import Dropdown from 'primevue/dropdown'
  
  interface Props {
    modelValue: any
    options: any[]
    optionLabel?: string
    optionValue?: string
    label?: string
    placeholder?: string
    hint?: string
    error?: string
    required?: boolean
    disabled?: boolean
    id?: string
  }
  
  const props = withDefaults(defineProps<Props>(), {
    modelValue: null,
    options: () => [],
    optionLabel: 'label',
    optionValue: 'value',
    label: undefined,
    placeholder: 'Select an option',
    hint: undefined,
    error: undefined,
    required: false,
    disabled: false,
    id: undefined
  })
  
  const emit = defineEmits<{
    (e: 'update:modelValue', value: any): void
    (e: 'change', value: any): void
  }>()
  
  const selectedValue = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
  })
  
  const handleChange = (event: any) => {
    emit('change', event.value)
  }
  </script>