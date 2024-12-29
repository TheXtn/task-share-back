# TaskShare Backend

TaskShare is a collaborative task management application built with Laravel. This repository contains the backend API 
## Technologies Used

- PHP 8.0+
- Laravel 9.x
- MySQL 5.7+ or MariaDB 10.2+
- Composer
- Laravel Sanctum for API authentication

## Getting Started

### Prerequisites

- PHP 8.0 or higher
- Composer
- MySQL or MariaDB database

### Installation

1. Clone the repository:
   ```
   git clone https://github.com/Thextn/taskshare-backend.git
   cd taskshare-backend
   ```

2. Install dependencies:
   ```
   composer install
   ```

3. Create a copy of the `.env.example` file and rename it to `.env`:
   ```
   cp .env.example .env
   ```

4. Generate an application key:
   ```
   php artisan key:generate
   ```

5. Configure your database settings in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=taskshare
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. Run database migrations:
   ```
   php artisan migrate
   ```

7. (Optional) Seed the database with sample data:
   ```
   php artisan db:seed
   ```

### Running the Development Server

```
php artisan serve
```

The API will be available at `http://localhost:8000`.

## Project Structure

- `app/Http/Controllers`: Contains the API controllers
- `app/Models`: Eloquent models representing database tables
- `app/Http/Resources`: API resources for transforming models into JSON responses
- `database/migrations`: Database migration files
- `routes/api.php`: API route definitions
- `config/`: Configuration files

## API Endpoints

### Authentication

- `POST /api/register`: Register a new user
- `POST /api/login`: Log in a user
- `GET /api/user`: Get the authenticated user's information
- `PUT /api/user`: Update the authenticated user's information

### Task Lists

- `GET /api/task-lists`: Get all task lists for the authenticated user
- `POST /api/task-lists`: Create a new task list
- `GET /api/task-lists/{id}`: Get a specific task list
- `PUT /api/task-lists/{id}`: Update a task list
- `DELETE /api/task-lists/{id}`: Delete a task list
- `POST /api/task-lists/{id}/share`: Share a task list with another user
- `GET /api/shared-lists`: Get all task lists shared with the authenticated user

### Tasks

- `GET /api/task-lists/{listId}/tasks`: Get all tasks for a specific task list
- `POST /api/task-lists/{listId}/tasks`: Create a new task in a task list
- `GET /api/tasks/{id}`: Get a specific task
- `PUT /api/tasks/{id}`: Update a task
- `DELETE /api/tasks/{id}`: Delete a task

## Models

### User

- `id`: integer
- `name`: string
- `email`: string
- `username`: string
- `password`: string
- `created_at`: timestamp
- `updated_at`: timestamp

### TaskList

- `id`: integer
- `name`: string
- `user_id`: integer (foreign key to users table)
- `created_at`: timestamp
- `updated_at`: timestamp

### Task

- `id`: integer
- `title`: string
- `description`: text (nullable)
- `completed`: boolean
- `task_list_id`: integer (foreign key to task_lists table)
- `created_at`: timestamp
- `updated_at`: timestamp

## Relationships

- A User has many TaskLists
- A User has many shared TaskLists (through a pivot table)
- A TaskList belongs to a User
- A TaskList has many Tasks
- A Task belongs to a TaskList

## Authentication

This API uses Laravel Sanctum for token-based authentication. To authenticate requests, include the `Authorization` header with a Bearer token:

```
Authorization: Bearer <your-token>
```

## Error Handling

The API returns appropriate HTTP status codes and error messages in JSON format:

```json
{
    "message": "The error message",
    "errors": {
        "field": [
            "Validation error message"
        ]
    }
}
```

## Deployment

