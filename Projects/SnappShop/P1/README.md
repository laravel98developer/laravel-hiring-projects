# Snapp! Shop Interview Task

**Description:** This is a mini project that implements a tiny banking system for money transactions between bank accounts.

## API Endpoints

### 1. Create Transaction

- **Method:** POST
- **Endpoint:** `/api/transactions`
- **Request Body:**
  - `card_number`: The card number of the source bank account.
  - `destination_card_number`: The card number of the destination bank account.
  - `amount`: The amount of money to be transferred.

### 2. Retrieve Last Transactions

- **Method:** GET
- **Endpoint:** `/api/lastTransactions`
- **No Body Parameters Needed**

## Getting Started

Follow these steps to set up and run the project on your local machine.

### Prerequisites

- PHP
- Composer
- Laravel

### Installation

1. Clone the repository:

        git clone https://github.com/yourusername/snapp-shop-interview-task.git

Change into the project directory:

    cd snapp-shop-interview-task

Install project dependencies:

    composer install

Generate an application key:

    php artisan key:generate

Run the database migrations and seed the database with initial data:

    php artisan migrate --seed

Usage

You can start using the project by making HTTP requests to the provided API endpoints as described above.
Commands

To run the project and associated services, use the following commands:

    Start the Laravel development server:

    php artisan serve

Start the Laravel queue worker for handling background jobs:

    php artisan queue:work

License

This project is licensed under the MIT License. See the LICENSE file for details.
