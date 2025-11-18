# blog-app-symfony

## About

Role-based authentication backend administration system built with Symfony and EasyAdmin. Administrators can create, edit, and manage posts.

---
## Features

- **Administrator panel**:
  - Create, edit, and delete posts
  - View post details
  - Metrics: view total posts, comments, and other relevant data at a glance
- **Authentication and authorization**:
  - Login / logout
  - Role-based access control
- **Content management**:
  - Image uploads for posts
  - Validation for post fields

---

## Technologies

- PHP 8.2
- Symfony 7
- Twig
- EasyAdmin Bundle
- Doctrine ORM
- MySQL
- Composer
- Symfony CLI
- Tailwind CSS
- VichUploaderBundle

---

## Screenshots

### Admin Dashboard (Logged In)
![Admin Dashboard Logged](public/screenshots/admin_dashboard_logged.png)

### Post Detail / List
![Post Detail](public/screenshots/screenshot_post_2.png)

---

# Installation & Setup

Follow these steps to set up and run the project:

```bash
# Clone the repository
git clone https://github.com/sarahwtz/blog-app-symfony.git
cd blog-app-symfony

# Install PHP and Composer
php -v
composer -V

# Install project dependencies
composer install

# Install EasyAdmin Bundle
composer require easycorp/easyadmin-bundle

# Setup environment file
cp .env.example .env

# Edit .env file with your database credentials
export APP_SECRET=<your_generated_secret>
export DATABASE_URL="mysql://username:password@127.0.0.1:3306/blog_app_symfony?serverVersion=8.0&charset=utf8mb4"

# Run database migrations
php bin/console doctrine:migrations:migrate

# Serve the application locally
symfony server:start
```

---


## Database Structure
---------------------

### user

| Column    | Type         | Description                     |
|-----------|--------------|---------------------------------|
| id        | int          | Unique identifier for each user |
| email     | varchar(180) | User email                      |
| roles     | json         | Array of user roles             |
| password  | varchar(255) | Hashed password                 |

**Indexes / Constraints:**  
- Primary key on `id`  
- Unique index on `email`  

---

### post

| Column          | Type          | Description                                  |
|-----------------|---------------|----------------------------------------------|
| id              | int           | Unique post identifier                        |
| title           | varchar(255)  | Post title                                   |
| content         | text          | Post content                                 |
| createdAt       | datetime      | Creation timestamp                           |
| updatedAt       | datetime      | Last update timestamp (nullable)             |
| image           | varchar(255)  | Image filename/path (nullable)               |
| imageUpdatedAt  | datetime      | Timestamp of last image update (nullable)   |

**Indexes / Constraints:**  
- Primary key on `id`  

**Relationships:**  
- Post → Comment (1:N)  

---

### comment

| Column    | Type         | Description                     |
|-----------|--------------|---------------------------------|
| id        | int          | Unique comment identifier       |
| post_id   | int          | Reference to the related post  |
| author    | varchar(255) | Comment author                  |
| content   | text         | Comment content                 |
| createdAt | datetime     | Timestamp of comment creation   |

**Indexes / Constraints:**  
- Primary key on `id`  
- Foreign key: `post_id` → `post(id)`  

**Relationships:**  
- Comment → Post (N:1)  

---
