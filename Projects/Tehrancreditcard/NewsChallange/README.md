# NewsChallenge

**Project Description:**  
A Laravel application designed to retrieve and display news from two different sources. The project uses Tailwind CSS (via CDN) for styling and Filament for admin resources. This application includes a `User` model for authentication and a `News` model for handling news articles. The project is built to allow scheduling tasks with Laravel's built-in scheduler.

<p align="center">
  <img src="https://github.com/laravel98developer/laravel-hiring-projects/blob/master/Projects/Tehrancreditcard/tehrancreditcard_project.jpg" alt="NewsChallenge Project Image">
</p>

## Table of Contents

- [Installation](#installation)
- [Configuration](#configuration)
- [Filament Resources](#filament-resources)
- [Running Cron Jobs](#running-cron-jobs)
- [Tailwind CSS Integration](#tailwind-css-integration)
- [YouTube Tutorial](#youtube-tutorial)

## Installation

1. **Clone the Repository:**

    ```bash
    # Clone the repository
    git clone https://github.com/laravel98developer/laravel-hiring-projects.git

    # Navigate into the cloned repository
    cd laravel-hiring-projects

    # Move into the Projects directory
    cd Projects

    # Move into the Tehrancreditcard directory
    cd Tehrancreditcard

    # Finally, navigate to the NewsChallenge directory
    cd NewsChallenge

    ```

2. **Install Dependencies:**

    ```bash
    composer install
    ```

3. **Copy .env file and Generate Application Key:**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. **Set Up Database:**

    Update your `.env` file with your database credentials and then run:

    ```bash
    php artisan migrate
    ```

## Configuration

### Filament Resource Configuration

To generate a Filament resource for the `User` and `News` models, use the following commands:

- **User Resource:**

    ```bash
    php artisan make:filament-resource User --view --generate
    ```

- **News Resource:**

    ```bash
    php artisan make:filament-resource News --view --generate
    ```

These commands will create resources in the `app/Filament/Resources` directory and generate the necessary views.

## Filament Resources

Filament resources provide an easy-to-use interface for managing your models. The generated resources include the ability to create, read, update, and delete records.

## Running Cron Jobs

To run the scheduler locally, use:

```bash
php artisan schedule:work
```

## Tailwind CSS Integration

Tailwind CSS is integrated via CDN, so there's no need for npm commands. Simply include the Tailwind CSS CDN link in your HTML files:

```html
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.2.1/dist/tailwind.min.css" rel="stylesheet">
```

All Tailwind CSS classes can be used directly in your HTML without any additional configuration.

## YouTube Tutorial

For a step-by-step guide on how to set up a Laravel project with Filament and Tailwind CSS, check out this YouTube tutorial:

[🔥 Laravel & Filament: Tehrancreditcard News Challenges 🚀](https://youtu.be/vTrfjhoDuLU)

