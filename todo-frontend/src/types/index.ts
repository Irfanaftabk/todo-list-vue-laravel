export type Priority = 'high' | 'medium' | 'low'

export interface Task {
  id: number
  description: string
  due_date: string | null
  priority: Priority
  is_completed: boolean
  categories?: Category[]
  created_at: string
  updated_at: string
}

export interface Category {
  id: number
  name: string
  tasks_count?: number
  tasks?: Task[]
  created_at: string
  updated_at: string
}

export interface TaskFilters {
  priority?: Priority
  is_completed?: boolean
  due_date?: string
  category_ids?: number[]
}

export interface CreateTaskDTO {
  description: string
  due_date?: string
  priority: Priority
  category_ids?: number[]
  is_completed?: boolean
}

export interface UpdateTaskDTO extends Partial<CreateTaskDTO> {}

export interface CreateCategoryDTO {
  name: string
}

export interface UpdateCategoryDTO extends CreateCategoryDTO {}