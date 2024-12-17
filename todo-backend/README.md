# Todo Application Backend

A Laravel-based RESTful API backend for the Todo Application, featuring task management with rich metadata and filtering capabilities.

## Technology Stack

- Laravel 10.x
- MySQL 8.0+
- PHP 8.1+

## Features

### Task Management
- Create, Read, Update, Delete tasks
- Set task priorities (High, Medium, Low)
- Set due dates
- Track completion status
- Assign multiple categories to tasks

### Category Management
- Create, Read, Update, Delete categories
- Associate categories with multiple tasks
- Track tasks per category

### Advanced Filtering
- Filter tasks by priority
- Filter tasks by completion status
- Filter tasks by due date (today, week, month, overdue)
- Filter tasks by categories
- Combine multiple filters

## Prerequisites

- PHP 8.1 or higher
- Composer
- MySQL 8.0 or higher
- Git

## Setup Instructions

1. **Clone the Repository**
   ```bash
   git clone [repository-url]
   cd todo-backend
   ```

2. **Install Dependencies**
   ```bash
   composer install
   ```

3. **Environment Configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
   Update `.env` with your database credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=todo_app
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Database Setup**
   ```bash
   # Create database
   mysql -u your_username -p
   CREATE DATABASE todo_app;
   
   # Run migrations
   php artisan migrate
   
   # Seed database with sample data
   php artisan db:seed
   ```

5. **Start Development Server**
   ```bash
   php artisan serve
   ```

## API Documentation

### Task Endpoints

#### List Tasks
- **GET** `/api/tasks`
- Query Parameters:
  - `priority`: Filter by priority (high, medium, low)
  - `is_completed`: Filter by completion status (true, false)
  - `due_date`: Filter by due date (today, week, month, overdue)
  - `category_ids[]`: Filter by category IDs

#### Create Task
- **POST** `/api/tasks`
- Request Body:
  ```json
  {
    "description": "Task description",
    "due_date": "2024-12-20 10:00:00",
    "priority": "high",
    "category_ids": [1, 2],
    "is_completed": false
  }
  ```

#### Get Task
- **GET** `/api/tasks/{id}`

#### Update Task
- **PUT** `/api/tasks/{id}`
- Request Body: Same as Create Task (all fields optional)

#### Toggle Task Completion
- **PATCH** `/api/tasks/{id}/toggle-complete`

#### Delete Task
- **DELETE** `/api/tasks/{id}`

### Category Endpoints

#### List Categories
- **GET** `/api/categories`

#### Create Category
- **POST** `/api/categories`
- Request Body:
  ```json
  {
    "name": "Category Name"
  }
  ```

#### Get Category
- **GET** `/api/categories/{id}`

#### Update Category
- **PUT** `/api/categories/{id}`
- Request Body: Same as Create Category

#### Delete Category
- **DELETE** `/api/categories/{id}`

## Response Format

All API responses follow this structure:
```json
{
  "data": {
    // Resource data
  },
  "meta": {
    // Metadata (pagination, etc.) if applicable
  }
}
```

## Error Handling

The API returns appropriate HTTP status codes:
- 200: Success
- 201: Created
- 204: No Content
- 400: Bad Request
- 404: Not Found
- 422: Validation Error
- 500: Server Error

Validation errors include detailed messages:
```json
{
  "message": "The given data was invalid.",
  "errors": {
    "field": ["Error message"]
  }
}
```


## License

This project is licensed under the MIT License - see the LICENSE file for details.