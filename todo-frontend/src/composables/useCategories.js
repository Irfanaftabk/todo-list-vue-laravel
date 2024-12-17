import { ref } from 'vue'
import { categoryService } from '../services/categoryService'

export function useCategories() {
  const categories = ref([])
  const isLoading = ref(false)
  const error = ref(null)

  // Fetch all categories
  const fetchCategories = async () => {
    isLoading.value = true
    error.value = null
    try {
      const response = await categoryService.getCategories()
      categories.value = response.data.data;
      console.log(`categories***`, response.data)
    } catch (err) {
      error.value = err.message || 'Failed to fetch categories'
    } finally {
      isLoading.value = false
    }
  }

  // Create a new category
  const createCategory = async (categoryData) => {
    isLoading.value = true
    error.value = null
    try {
      const response = await categoryService.createCategory(categoryData)
      categories.value.push(response.data)
      return response.data
    } catch (err) {
      error.value = err.message || 'Failed to create category'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  // Update an existing category
  const updateCategory = async (categoryId, categoryData) => {
    isLoading.value = true
    error.value = null
    try {
      const response = await categoryService.updateCategory(categoryId, categoryData)
      const index = categories.value.findIndex(c => c.id === categoryId)
      if (index !== -1) {
        categories.value[index] = response.data
      }
      return response.data
    } catch (err) {
      error.value = err.message || 'Failed to update category'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  // Delete a category
  const deleteCategory = async (categoryId) => {
    isLoading.value = true
    error.value = null
    try {
      await categoryService.deleteCategory(categoryId)
      categories.value = categories.value.filter(c => c.id !== categoryId)
    } catch (err) {
      error.value = err.message || 'Failed to delete category'
      throw err
    } finally {
      isLoading.value = false
    }
  }

  return {
    categories,
    isLoading,
    error,
    fetchCategories,
    createCategory,
    updateCategory,
    deleteCategory
  }
}