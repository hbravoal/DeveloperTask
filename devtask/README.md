<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Getting Started

Follow these steps to get started with the project:

### Prerequisites

Before you begin, ensure you have the following installed:

- **Docker** (with Docker Compose)
- **PHP** (if you're running the project locally without Docker)
- **Composer** (for managing Laravel dependencies)

### Step 1: Install Docker

#### **For Windows and MacOS**:

1. **Download Docker Desktop**:
    - Go to the Docker website: [Docker Desktop Download](https://www.docker.com/products/docker-desktop)
    - Download and install Docker Desktop for Windows or MacOS.
    - After installation, launch Docker Desktop.

2. **Verify the installation**:
   Run the following command in your terminal to ensure Docker is properly installed:

   ```bash
   docker --version
   docker-compose --version
   docker-compose up -d

3. **Execute docker composer**:

   ```bash
   docker-compose up -d
   
4. **Execute Migrations**:

   ```bash
   php artisan migrate

5. **Running test**:

   ```bash
   php artisan test


