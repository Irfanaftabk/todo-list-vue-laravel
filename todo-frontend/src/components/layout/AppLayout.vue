<template>
    <div class="min-h-screen bg-gray-50">
      <!-- Header/Navigation Bar -->
      <header class="bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between h-16">
            <!-- App Title -->
            <div class="flex items-center flex-shrink-0">
              <h1 class="text-xl font-bold text-gray-900">
                Task Manager
              </h1>
            </div>
  
            <!-- Navigation Links -->
            <nav class="flex items-center space-x-4">
              <BaseButton
                :variant="currentRoute === '/' ? 'primary' : 'text'"
                @click="navigateTo('/')"
              >
                Tasks
              </BaseButton>
  
              <BaseButton
                :variant="currentRoute === '/categories' ? 'primary' : 'text'"
                @click="navigateTo('/categories')"
              >
                Categories
              </BaseButton>
            </nav>
          </div>
        </div>
      </header>
  
      <!-- Main Content Area -->
      <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <slot></slot>
      </main>
    </div>
  </template>
  
  <script setup lang="ts">
  import { computed } from 'vue'
  import { useRouter, useRoute } from 'vue-router'
  import BaseButton from '../common/BaseButton.vue'
  
  const router = useRouter()
  const route = useRoute()
  
  const currentRoute = computed(() => route.path)
  
  const navigateTo = (path: string) => {
    router.push(path)
  }
  </script>