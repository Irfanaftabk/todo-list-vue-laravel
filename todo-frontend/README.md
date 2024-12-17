# Todo Application Frontend

A modern, responsive task management application built with Vue.js, PrimeVue, and Tailwind CSS.

## Features

- Task Management
  - Create, edit, and delete tasks
  - Set task priorities (High, Medium, Low)
  - Set due dates
  - Mark tasks as complete
  - Assign categories to tasks

- Category Management
  - Create, edit, and delete categories
  - Assign multiple categories to tasks
  - View tasks by category

- Filtering and Organization
  - Filter tasks by priority, due date, and categories
  - Separate views for active and completed tasks
  - Task statistics dashboard
  - Sort tasks by various attributes

## Tech Stack

- Vue.js 3 (Composition API)
- PrimeVue for UI components
- Tailwind CSS for styling
- Axios for API communication
- Vue Router for navigation
- TypeScript for type safety

## Prerequisites

- Node.js (v16 or higher)
- npm or yarn
- Backend API running (see backend setup instructions)

## Installation

1. Clone the repository:
   ```bash
   git clone <repository-url>
   cd todo-frontend
   ```

2. Install dependencies:
   ```bash
   npm install
   # or
   yarn install
   ```

3. Create a `.env` file in the root directory:
   ```env
   VITE_API_BASE_URL=http://localhost:8000/api
   ```

4. Start the development server:
   ```bash
   npm run dev
   # or
   yarn dev
   ```

## Project Structure

```
todo-frontend/
├── src/
│   ├── assets/            # Static assets and global styles
│   ├── components/        # Vue components
│   │   ├── common/        # Reusable base components
│   │   ├── tasks/         # Task-related components
│   │   ├── categories/    # Category-related components
│   │   └── layout/        # Layout components
│   ├── composables/       # Vue composables (hooks)
│   ├── services/          # API service layer
│   ├── views/             # Page components
│   ├── utils/             # Utility functions
│   ├── App.vue           # Root component
│   └── main.ts           # Application entry point
```

## Component Overview

### Base Components
- `BaseButton.vue` - Reusable button component with variants
- `BaseInput.vue` - Input component with validation
- `BaseSelect.vue` - Select/dropdown component
- `BaseModal.vue` - Modal dialog component

### Task Components
- `TaskItem.vue` - Individual task component
- `TaskForm.vue` - Form for creating/editing tasks
- `TaskFilters.vue` - Task filtering interface
- `TaskStats.vue` - Task statistics dashboard

### Category Components
- `CategoryList.vue` - Displays list of categories
- `CategoryItem.vue` - Individual category component
- `CategoryForm.vue` - Form for creating/editing categories

## Development Guidelines

### Code Style
- Follow Vue.js Style Guide
- Use TypeScript for type safety
- Use Composition API with `<script setup>`
- Follow consistent naming conventions
  - Components: PascalCase
  - Files: PascalCase for components, camelCase for others
  - Variables: camelCase
  - Props: camelCase

### Component Structure
- Keep components focused and single-responsibility
- Use props and events for component communication
- Extract reusable logic to composables
- Use TypeScript interfaces for prop types

### State Management
- Use Vue composables for shared state
- Keep API calls in service layer
- Use props for component-specific state
- Emit events for parent communication

### Styling
- Use Tailwind utility classes
- Follow mobile-first approach
- Maintain consistent spacing and colors
- Use PrimeVue components for complex UI elements

## Available Scripts

- `npm run dev` - Start development server
- `npm run build` - Build for production
- `npm run preview` - Preview production build

## Environment Variables

- `VITE_API_BASE_URL` - Backend API URL (required)

## API Integration

The application communicates with the backend API through services in the `services` directory:

- `taskService.js` - Task-related API calls
- `categoryService.js` - Category-related API calls
- `api.js` - Base API configuration

## Error Handling

- Form validation using PrimeVue components
- API error handling in services layer
- User-friendly error messages
- Loading states for async operations
