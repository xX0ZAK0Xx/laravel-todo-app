
# Todo App

A feature-rich Todo application built with Laravel 12. This project demonstrates a clean architecture using repositories, services, events, listeners, observers, and API resources. It supports user authentication, todo management, statistics, and email notifications.

## Features

- User registration and authentication (Sanctum)
- Todo CRUD operations with priorities, due dates, and completion tracking
- User streak and statistics tracking
- Email notifications on todo completion
- RESTful API structure (public, user, admin routes)
- Database seeding with sample users and todos

## Requirements

- PHP ^8.2
- Composer
- Node.js & npm (for frontend assets)
- SQLite (default), MySQL, or PostgreSQL
- [Optional] Mail server for email notifications

## Installation

1. **Clone the repository:**
	```bash
	git clone <your-repo-url>
	cd todo-app
	```

2. **Install PHP dependencies:**
	```bash
	composer install
	```

3. **Install Node dependencies:**
	```bash
	npm install
	```

4. **Copy and configure environment file:**
	```bash
	cp .env.example .env
	```
	- Set your database connection in `.env` (default is SQLite).
	- Configure mail settings if you want email notifications.

5. **Generate application key:**
	```bash
	php artisan key:generate
	```

6. **Run migrations:**
	```bash
	php artisan migrate
	```

7. **(Optional) Build frontend assets:**
	```bash
	npm run build
	```

## Seeding the Database

To populate the database with sample users and todos:

```bash
php artisan db:seed
```

- Seeds an admin user (`mdzayed@gmail.com` / `password`) and 10 regular users.
- Each user gets sample todos (including completed ones).

## Running the Application

Start the local development server:

```bash
php artisan serve
```

The app will be available at [http://localhost:8000](http://localhost:8000).

## Running Tests

To run the test suite:

```bash
php artisan test
```
or
```bash
vendor/bin/phpunit
```

## Project Structure

- `app/Models/` - Eloquent models (`User`, `Todo`)
- `app/Repositories/` - Data access logic
- `app/Services/` - Business logic
- `app/Events/Listeners/Observers/` - Event-driven features
- `routes/` - API and web routes
- `database/seeders/` - Database seeders

## API

- Public, user, and admin endpoints are defined in `routes/api-*.php`.
- Uses Laravel Sanctum for API authentication.

## License

This project is open-sourced under the [MIT license](https://opensource.org/licenses/MIT).
