# Bill Payments API

## Overview

This project is a RESTful API for managing bill payments, built using Laravel. It allows users to create, retrieve, update, and delete transactions and users.

## Features

- CRUD operations for transactions and users
- Paginated responses for listing resources
- Detailed error handling
- Unit tests for API endpoints

## Technologies Used

- **Laravel**: PHP framework for web applications
- **PHP**: Programming language
- **MySQL**: Database management system
- **Postman**: For testing API endpoints

## Getting Started

### Prerequisites

Before you begin, ensure you have the following installed:

- PHP (>= 8.0)
- Composer
- MySQL or another supported database

### Installation

1. **Clone the repository**:
   ```bash
   git clone https://github.com/phonixcode/bill-payments-api.git
   cd bill-payments-api
   ```

2. **Install dependencies**:
   ```bash
   composer install
   ```

3. **Set up your environment file**:
   ```bash
   cp .env.example .env
   ```

4. **Generate the application key**:
   ```bash
   php artisan key:generate
   ```

5. **Configure your database**: 
   Open the `.env` file and set your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run database migrations**:
   ```bash
   php artisan migrate
   ```

7. **(Optional) Seed the database**: 
   You can seed your database with initial data using:
   ```bash
   php artisan db:seed
   ```

### Project Structure

- **Controllers**: Contains the API logic for handling requests and responses.
- **Models**: Represents the database entities.
- **Resources**: Transforms models into JSON responses.
- **Requests**: Handles validation of incoming requests.
- **Traits**: Contains reusable methods (e.g., `ApiResponseTrait` for consistent API responses).
- **Exceptions**: Custom exception handling.
- **Routes**: API routes are defined in the `routes/api.php` file, providing endpoints for transactions and users.

### API Endpoints

#### Transactions

- **GET /api/transactions**: Retrieve a list of transactions.
- **POST /api/transactions**: Create a new transaction.
- **GET /api/transactions/{id}**: Retrieve a specific transaction by ID.
- **PUT /api/transactions/{id}**: Update a specific transaction by ID.
- **DELETE /api/transactions/{id}**: Delete a specific transaction by ID.

#### Users

- **GET /api/users**: Retrieve a list of users.
- **POST /api/users**: Create a new user.
- **GET /api/users/{id}**: Retrieve a specific user by ID.
- **PUT /api/users/{id}**: Update a specific user by ID.
- **DELETE /api/users/{id}**: Delete a specific user by ID.


check the complete documentation here [Documentation](https://documenter.getpostman.com/view/36429449/2sAXxQdrg8).

## Techniques and Approaches Used

1. **Route Model Binding**: Utilizes Laravel’s route model binding to automatically resolve the model instances from the route parameters, providing cleaner code and reducing boilerplate.

2. **API Response Trait**: A reusable trait (`ApiResponseTrait`) that provides a consistent format for API responses. This trait encapsulates the logic for success and error responses, making the codebase more DRY (Don't Repeat Yourself).

3. **Error Handling**: Custom exception handling to return meaningful error messages and status codes to the API consumers. The `Handler` class captures `ModelNotFoundException` to return a 404 response when a resource is not found.

4. **Unit Testing**: Laravel's built-in testing tools are utilized to ensure the functionality of the API endpoints. This helps maintain code quality and prevents regressions.

5. **Validation Requests**: Form request validation to ensure that incoming data is validated before reaching the controller logic.

## Running Unit Tests

To run the unit tests for the project, follow these steps:

1. Ensure your database is migrated and seeded (if needed).
2. Run the following command:
   ```bash
   php artisan test
   ```

3. This command will execute all tests and provide output indicating which tests passed and which failed. You can also run specific test files by providing the path, e.g.:
   ```bash
   php artisan test tests/Unit/TransactionControllerTest.php
   ```

### Test Results

The tests have been executed successfully, and here are the results:

```
   PASS  Tests\Unit\TransactionControllerTest
  ✓ it creates a transaction successfully                                                                                                        0.19s  
  ✓ it fails to create a transaction due to validation errors                                                                                    0.01s  
  ✓ it fetches a transaction successfully                                                                                                        0.01s  
  ✓ it updates a transaction successfully                                                                                                        0.01s  
  ✓ it deletes a transaction successfully                                                                                                        0.01s  
  ✓ it returns not found for non existing transaction                                                                                            0.01s  

   PASS  Tests\Unit\UserControllerTest
  ✓ it creates a user successfully                                                                                                               0.02s  
  ✓ it fails to create a user due to validation errors                                                                                           0.01s  
  ✓ it fetches a user successfully                                                                                                               0.01s  
  ✓ it updates a user successfully                                                                                                               0.01s  
  ✓ it deletes a user successfully                                                                                                               0.03s  
  ✓ it returns not found for non existing user                                                                                                   0.01s  

  Tests:    12 passed (53 assertions)
  Duration: 0.33s
```

### Test Structure

- **Unit Tests**: Tests for individual components and methods.
- **Feature Tests**: Tests for testing larger features that involve multiple components.

## Contributing

If you would like to contribute to this project, please fork the repository and submit a pull request with your changes.
