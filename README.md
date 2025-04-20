# Fresh Laravel for laravel-repository testing

laravel-for-package-testing is a Docker-based environment setup for Laravel 12 with the Laravel Starter Kit (React). It runs with PostgreSQL (PGSQL), Traefik, Redis, Mail services, and other necessary configurations to streamline Laravel-repository testing with Dock Repo for docker. 

---

## Features
- **Laravel 12**: Fresh Laravel setup with the Starter Kit (React).
- **PostgreSQL**: Efficient and scalable relational database.
- **Traefik**: Reverse proxy for routing and SSL support.
- **Redis**: Caching and session management.
- **Mail Services**: Email handling within the application.

---

## Requirements
Ensure you have the following installed on your system:
- Docker
- Docker Compose
- Node.js (for React development)
- Docker Desktop

---

## Installation

1. **Clone the Dock Repository**:
   ```bash
   git clone https://github.com/bhojkamal/dock.git
   cd dock

2. **Clone the this laravel for testing package
  ```bash
  git clone https://github.com/bhojkamal/laravel-for-package-testing.git
  cd laravel-for-package-testing
  npm install
  npm run build
  
  run composer install and migration, and all laravel related inside docker

