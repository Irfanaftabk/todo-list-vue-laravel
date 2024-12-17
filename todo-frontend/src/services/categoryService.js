import api from './api'

export const categoryService = {
  /**
   * Get all categories
   */
  getCategories() {
    return api.get('/categories')
  },

  /**
   * Get a specific category by ID
   */
  getCategory(categoryId) {
    return api.get(`/categories/${categoryId}`)
  },

  /**
   * Create a new category
   */
  createCategory(categoryData) {
    return api.post('/categories', categoryData)
  },

  /**
   * Update an existing category
   */
  updateCategory(categoryId, categoryData) {
    return api.put(`/categories/${categoryId}`, categoryData)
  },

  /**
   * Delete a category
   */
  deleteCategory(categoryId) {
    return api.delete(`/categories/${categoryId}`)
  }
}