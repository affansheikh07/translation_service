# Translation API Project

This project is a Translation API built using Laravel. It supports storing, retrieving, and exporting translations with various filters. The API is optimized for performance using caching and includes token-based authentication with Laravel Sanctum.

## Features

- **Translation CRUD**: Allows the creation, retrieval, updating, and deletion of translations.
- **Export Translations**: Supports exporting translations with filters such as locale and pagination.
- **Authentication**: Uses Laravel Sanctum for JWT-based login and token management.
- **Caching**: Implements caching with Redis (or file-based cache) for frequently accessed data.
- **Error Handling**: Centralized error management with custom messages and consistent API responses using Laravel's handler.php.

## Design Choices

### **Laravel Framework**
The project leverages **Laravel**, a modern PHP framework known for its expressive syntax, robust features, and ease of use. Laravel simplifies tasks like routing, validation, and database migrations, which reduces boilerplate code and improves overall productivity.

### **Sanctum for Authentication**
We use **Laravel Sanctum** for token-based authentication. Sanctum provides a simple and secure way to authenticate API requests, making it an ideal choice for the API. It’s lightweight and works seamlessly with SPAs and mobile applications.

### **Eloquent ORM**
The **Eloquent ORM** is used for database interactions. Eloquent provides an elegant and intuitive way to interact with the database without writing complex SQL queries, reducing the chance for errors and improving the clarity of code.

### **Redis Caching**
To optimize performance, **Redis** (or file-based cache) is used to cache translations and frequently accessed data. Caching reduces the load on the database and ensures faster responses for repeated requests.

### **Pagination**
For handling large datasets, the API implements **pagination**. This reduces memory usage and server load by ensuring that only a limited set of results is returned per request.

### **Error Handling**
The API implements custom **error handling** in controllers. This ensures meaningful error messages and consistent API responses, helping users easily understand and resolve issues.

## Setup Instructions

### Prerequisites

- PHP >= 8.0
- Composer
- Laravel >= 9.0
- MySQL
- Redis
