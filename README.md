# News Aggregator API

This project is a **News Aggregator API** that collects news articles from various sources and provides a personalized news feed based on user preferences. It is built with Laravel and uses Docker, Sanctum, and Swagger/OpenAPI for API documentation.

## Table of Contents
- [Features](#features)
- [Installation](#installation)
- [API Documentation](#api-documentation)
- [Usage](#usage)
- [Testing](#testing)
- [Technologies](#technologies)

## Features

- **User Management**: Register, log in, and log out.
- **Article Management**: List articles from multiple sources, search articles, and view article details.
- **User Preferences**: Users can set preferences for news sources, categories, and authors.
- **Personalized News Feed**: Users receive a feed based on their preferences.
- **Swagger/OpenAPI Documentation**: Detailed documentation for API endpoints.

## Installation

To set up and run the project, follow these steps:

1. **Clone the Repository**
   ```bash
   git clone https://github.com/mbd-code/news-aggregator.git
   cd news-aggregator
   ```

2. **Set Up Environment Variables**
   Create a `.env` file:
   ```bash
   cp .env.example .env
   ```
   - Add your API keys: `NEWSAPI_KEY`, `GUARDIANAPI_KEY`, `NYTIMESAPI_KEY`

3. **Start Docker**
   Use Docker and Docker Compose to start the development environment:
   ```bash
   docker-compose up -d
   ```

4. **Run Migrations and Seeders**
   ```bash
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan migrate --seed
   ```

5. **Fetch News Articles**
   ```bash
   docker-compose exec app php artisan fetch:news
   ```

## API Documentation

The API documentation is available at `http://localhost:8000/api/documentation`. You can use the Swagger UI to explore all endpoints and their details.

## Usage

### User Management

1. **User Registration**
   - **Endpoint**: `POST /api/register`
   - **Parameters**: `name`, `email`, `password`, `password_confirmation`

2. **User Login**
   - **Endpoint**: `POST /api/login`
   - **Parameters**: `email`, `password`

3. **User Logout**
   - **Endpoint**: `POST /api/logout`
   - **Authorization**: Required (Bearer Token)

### Article Management

1. **Get All Articles**
   - **Endpoint**: `GET /api/articles`
   - **Authorization**: Required
   - **Parameters**: `page` (optional), `per_page` (optional)

2. **Search Articles by Keyword**
   - **Endpoint**: `GET /api/articles/search`
   - **Parameters**: `keyword`,`category`,`source`,`date` (optional)

3. **Create an Article**
   - **Endpoint**: `POST /api/articles`
   - **Authorization**: Required
   - **Parameters**: `title`, `content`, `source`

### User Preferences

1. **Set or Update Preferences**
   - **Endpoint**: `POST /api/preferences`
   - **Parameters**: `source`, `category`, `author`

2. **Get Preferences**
   - **Endpoint**: `GET /api/preferences`
   - **Authorization**: Required

## Testing

To run all tests, use the following command:

```bash
php artisan test
```

### Summary of Tests
The project includes both `Feature` and `Unit` tests:
- **Feature Tests**: Tests main functions like user login, article management, and user preferences.
- **Unit Tests**: Tests specific functions independently.

During tests, the required sample data is automatically generated using Factory and Seeder.

## Technologies

This project was built with the following technologies:

- **Laravel** - Web application framework
- **Docker** - Containerized development and deployment environment
- **Laravel Sanctum** - API authentication
- **Swagger/OpenAPI** - API documentation
- **MySQL** - Database management system
- **Redis** - Used for caching

---