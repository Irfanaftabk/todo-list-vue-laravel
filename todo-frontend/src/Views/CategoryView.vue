<template>
    <div class="container mx-auto px-4 py-8">
      <!-- Categories List -->
      <div v-if="isLoading" class="text-center py-8">
        Loading...
      </div>
      <div v-else-if="error" class="text-center py-8 text-red-600">
        {{ error }}
      </div>
      <div v-else>
        <CategoryList
          :categories="categories"
          @create="openCategoryModal"
          @edit="openCategoryModal"
          @delete="confirmDeleteCategory"
        />
      </div>
  
      <!-- Category Modal -->
      <Dialog
        v-model:visible="showCategoryModal"
        :header="selectedCategory ? 'Edit Category' : 'Create Category'"
        modal
      >
        <CategoryForm
          :category="selectedCategory"
          :loading="isSubmitting"
          @submit="handleCategorySubmit"
          @cancel="closeCategoryModal"
        />
      </Dialog>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue'
  import Dialog from 'primevue/dialog'
  import CategoryList from '../components/categories/CategoryList.vue'
  import CategoryForm from '../components/categories/CategoryForm.vue'
  import { useCategories } from '../composables/useCategories'
  
  // Composables
  const {
    categories,
    isLoading,
    error,
    fetchCategories,
    createCategory,
    updateCategory,
    deleteCategory
  } = useCategories()
  
  // Local state
  const showCategoryModal = ref(false)
  const selectedCategory = ref(null)
  const isSubmitting = ref(false)
  
  // Methods
  const openCategoryModal = (category = null) => {
    selectedCategory.value = category
    showCategoryModal.value = true
  }
  
  const closeCategoryModal = () => {
    selectedCategory.value = null
    showCategoryModal.value = false
  }
  
  const handleCategorySubmit = async (categoryData) => {
    isSubmitting.value = true
    try {
      if (selectedCategory.value) {
        await updateCategory(selectedCategory.value.id, categoryData)
      } else {
        await createCategory(categoryData)
      }
      closeCategoryModal()
    } catch (err) {
      console.error('Failed to save category:', err)
    } finally {
      isSubmitting.value = false
    }
  }
  
  const confirmDeleteCategory = async (category) => {
    if (confirm(`Are you sure you want to delete the category "${category.name}"?`)) {
      try {
        await deleteCategory(category.id)
      } catch (err) {
        console.error('Failed to delete category:', err)
      }
    }
  }
  
  // Initial data fetch
  onMounted(async () => {
    await fetchCategories()
  })
  </script>