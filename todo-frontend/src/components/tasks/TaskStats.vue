<template>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <!-- Total Tasks -->
      <div class="bg-white p-4 rounded-lg border border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Total Tasks</p>
            <p class="mt-1 text-3xl font-semibold text-gray-900">
              {{ stats.total }}
            </p>
          </div>
          <div class="p-3 bg-blue-100 rounded-full">
            <svg
              class="w-6 h-6 text-blue-600"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"
              />
            </svg>
          </div>
        </div>
      </div>
  
      <!-- Completed Tasks -->
      <div class="bg-white p-4 rounded-lg border border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">Completed</p>
            <div class="mt-1 flex items-baseline">
              <p class="text-3xl font-semibold text-gray-900">
                {{ stats.completed }}
              </p>
              <p class="ml-2 text-sm text-gray-500">
                ({{ completionRate }}%)
              </p>
            </div>
          </div>
          <div class="p-3 bg-green-100 rounded-full">
            <svg
              class="w-6 h-6 text-green-600"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 13l4 4L19 7"
              />
            </svg>
          </div>
        </div>
      </div>
  
      <!-- High Priority Tasks -->
      <div class="bg-white p-4 rounded-lg border border-gray-200">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-sm text-gray-500">High Priority</p>
            <div class="mt-1 flex items-baseline">
              <p class="text-3xl font-semibold text-gray-900">
                {{ stats.high_priority }}
              </p>
              <p class="ml-2 text-sm text-red-500" v-if="stats.overdue > 0">
                ({{ stats.overdue }} overdue)
              </p>
            </div>
          </div>
          <div class="p-3 bg-red-100 rounded-full">
            <svg
              class="w-6 h-6 text-red-600"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
              />
            </svg>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script setup lang="ts">
  import { computed } from 'vue'
  
  interface TaskStats {
    total: number
    completed: number
    pending: number
    high_priority: number
    overdue: number
  }
  
  interface Props {
    stats: TaskStats
  }
  
  const props = defineProps<Props>()
  
  const completionRate = computed(() => {
    if (props.stats.total === 0) return 0
    return Math.round((props.stats.completed / props.stats.total) * 100)
  })
  </script>
  