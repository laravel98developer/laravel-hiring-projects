# Task Management Platform

A simple PHP-based task management application that allows users to create, update, and list tasks.

## Features

- Create new tasks
- Update existing tasks
- List all tasks
- Basic validation for task data

## Requirements

- PHP 7.4 or higher
- Composer
- MySQL
- Docker (optional, for containerized setup)

## Installation

### Using Docker

1. **Clone the repository**:
    ```sh
    git clone https://github.com/amir-mhp/snapp-grocery-task.git
    cd task-platform
    ```

2. **Build and run the Docker container**:
    ```sh
    docker compose up -d --build
    ```


## Migration

**Run the database migrations**:
    ```

    docker-compose exec web php /var/www/html/src/Database/migration.php

## Configuration

Ensure your `.env` file contains the correct database connection settings:

```env
DB_HOST=localhost
DB_PORT=3306
DB_NAME=tasks
DB_USERNAME=username
DB_PASSWORD=password