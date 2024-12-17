import { ref, watch } from 'vue'

export function useFilters() {
  const filters = ref({
    priority: null,
    due_date: null,
    category_ids: [],
    is_completed: null
  })

  // Priority options
  const priorityOptions = [
    { label: 'High Priority', value: 'high' },
    { label: 'Medium Priority', value: 'medium' },
    { label: 'Low Priority', value: 'low' }
  ]

  // Due date options
  const dueDateOptions = [
    { label: 'Today', value: 'today' },
    { label: 'This Week', value: 'week' },
    { label: 'This Month', value: 'month' },
    { label: 'Overdue', value: 'overdue' }
  ]

  // Status options
  const statusOptions = [
    { label: 'Completed', value: true },
    { label: 'Active', value: false }
  ]

  // Reset filters to default values
  const resetFilters = () => {
    filters.value = {
      priority: null,
      due_date: null,
      category_ids: [],
      is_completed: null
    }
  }

  // Update a single filter
  const updateFilter = (key, value) => {
    filters.value[key] = value
  }

  // Get current filters as query params
  const getQueryParams = () => {
    const params = {}
    Object.entries(filters.value).forEach(([key, value]) => {
      if (value !== null && value !== undefined && value !== '' && 
         (Array.isArray(value) ? value.length > 0 : true)) {
        params[key] = value
      }
    })
    return params
  }

  return {
    filters,
    priorityOptions,
    dueDateOptions,
    statusOptions,
    resetFilters,
    updateFilter,
    getQueryParams
  }
}