# Customer Management CRM - Code Challenge

This is a simple CRUD application for managing customer records, built with **Laravel** (Backend) and **Angular 7+** (Frontend). The system is fully containerized using **Docker**. This project features a fully functional Backend API built with Laravel, successfully integrated with a MySQL database.

## Features
- Create, Update, Delete, List, and View Customers.
- Search customers by Name and Email.
- Containerized architecture (4 services).

## Tech Stack
Backend: Laravel 11 (PHP 8.2)
Database: MySQL 8.0
Web Server/Proxy: Nginx
Containerization: Docker Desktop & Docker Compose

## Prerequisites
Before running the application, ensure you have the following installed:
- Docker and Docker Compose
- Postman (for API testing)
- Git
- Visual Studio Code (or any code editor)

## Getting Started

## 1. Clone the Repository

    ```git clone <repository-url>
       cd <project-root>```

## 2. Infrastructure Setup (Docker)
From the project root directory, build and start all required containers (Nginx, API, and Database):
Run the command in your terminal

    ```docker-compose up -d --build```

The application uses a custom Nginx configuration to proxy requests to the Laravel API.
API Base URL: http://localhost:8000


## 3. Database Migration & Configuration
Once the containers are running, execute the database migrations:

    ```docker-compose exec api php artisan migrate```

Set the required permissions for Laravel storage and cache directories:

    ```docker-compose exec api chmod -R 777 storage bootstrap/cache```


## API Endpoints
You can test the API functionality using Postman or cURL via *http://localhost:8000/api/customers*
Method      Endpoint              Description                      Expected Status
GET        /api/customers      Fetch a list of all customers            200 OK
POST      /api/customers     Create and save a new customer record    201 Created


*Postman Testing Guide:*
- Headers: Set Accept to application/json.
- Body: Select raw -> JSON.

- \Payload Example:

  *JSON
    {
      "first_name": "Juan",
      "last_name": "Dela Cruz",
      "email": "juan@example.com",
      "contact_number": "09123456789"
    }*

## Validation & Data Handling
- Unique Email Constraint: Customer email addresses must be unique. Duplicate entries return a 422 Unprocessable Content response.
- Required Fields: Name and email fields are mandatory.
- Audit Timestamps: Records automatically include created_at and updated_at fields.

## Troubleshooting

## Database Connection Errors:
- Ensure all Docker containers are running.
- Database Connection Issues: If the API fails to fetch data or returns a connection error, it may be due to a change in the Docker container's internal IP address.
- Generating a New IP: You can check the current internal IP of the database container by running: 

      ```docker inspect -f '{{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' <db_container_name>```
    
- If the database container IP changes, update the DB_HOST value in the .env file and restart the containers to ensure the changes take effect.
- Refreshing Environment Configuration:

      ```docker-compose exec api php artisan config:clear```

Environment Files:
- The .env file is excluded from version control for security reasons.
- A .env.example file is provided for reference.

Port Conflicts:
- If port 8000 is already in use, update the port mapping in docker-compose.yml.

Schema Consistency:
- Ensure request payload fields match the database schema (e.g., contact_number as defined in the schema)


