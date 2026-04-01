# 📚 Sina - Children's Storybook Platform

A collaborative student project that brings children's stories to life with progress tracking and an intuitive admin content management system.

**Live Demo:** [sina.hafmul.site](https://sina.hafmul.site)

---

## 🎯 About the Project

Sina is a responsive web platform designed for children's storybooks, featuring personalized user progress tracking and a lightweight admin CMS. This full-stack application translates beautiful Figma designs into production-ready pages, providing an engaging reading experience for children while giving parents and administrators powerful tools to manage content and monitor progress.

### ✨ Key Features

- **📖 Interactive Reading Experience** - Browse and read children's storybooks with an intuitive, child-friendly interface
- **📊 Progress Tracking Dashboard** - Monitor reading progress with personalized dashboards for each user
- **👥 Role-Based Access Control** - Three-tier authentication system (User, Admin, Superadmin)
- **🔐 Secure Authentication** - Built with Laravel Breeze for robust user authentication
- **⚡ Admin CMS** - Full CRUD operations for books, users, and reading records
- **📱 Responsive Design** - Seamlessly adapts to all screen sizes and devices
- **☁️ Cloud Media Management** - Integrated Cloudinary for efficient image storage and delivery
- **🎨 Modern UI/UX** - Translated 10+ Figma screens into pixel-perfect, accessible pages

---

## 🛠️ Tech Stack

### Backend
- **[Laravel 12](https://laravel.com)** - Modern PHP framework with Eloquent ORM
- **[Laravel Breeze](https://laravel.com/docs/breeze)** - Authentication scaffolding
- **PHP 8.2** - Latest PHP features and performance improvements
- **MySQL** - Relational database (hosted on Aiven)

### Frontend
- **[Tailwind CSS 3](https://tailwindcss.com)** - Utility-first CSS framework
- **[Alpine.js](https://alpinejs.dev)** - Lightweight JavaScript framework for interactivity
- **[Vite](https://vitejs.dev)** - Next-generation frontend tooling
- **Blade Templates** - Laravel's templating engine

### Cloud & DevOps
- **[Vercel](https://vercel.com)** - Serverless deployment platform
- **[Cloudinary](https://cloudinary.com)** - Cloud-based media management
- **[Aiven.io](https://aiven.io)** - Managed MySQL database hosting
- **Git & GitHub** - Version control and collaboration

### Development Tools
- **Composer** - PHP dependency management
- **NPM** - JavaScript package management
- **Laravel Pint** - Code style fixer
- **PHPUnit** - Testing framework

---

## 🚀 Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & NPM
- MySQL database

### Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/hafidzmulia-its/sina.git
   cd sina
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install JavaScript dependencies**
   ```bash
   npm install
   ```

4. **Environment configuration**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your `.env` file**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sina
   DB_USERNAME=your_username
   DB_PASSWORD=your_password

   CLOUDINARY_URL=cloudinary://your_api_key:your_api_secret@your_cloud_name
   CLOUDINARY_CLOUD_NAME=your_cloud_name
   CLOUDINARY_API_KEY=your_api_key
   CLOUDINARY_API_SECRET=your_api_secret
   ```

6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   npm run dev
   ```

Visit `http://localhost:8000` to see the application.

---

## 📂 Project Structure

```
sina/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Business logic
│   │   │   ├── BukuController.php
│   │   │   ├── DashboardController.php
│   │   │   ├── ProgressController.php
│   │   │   └── AccountController.php
│   │   └── Middleware/       # Authentication & access control
│   ├── Models/               # Eloquent models
│   │   ├── Buku.php
│   │   ├── User.php
│   │   └── History.php
│   └── Rules/                # Custom validation rules
├── database/
│   ├── migrations/           # Database schema
│   └── seeders/              # Sample data
├── resources/
│   ├── views/                # Blade templates
│   ├── css/                  # Tailwind styles
│   └── js/                   # Alpine.js components
├── routes/
│   ├── web.php              # Application routes
│   └── auth.php             # Authentication routes
└── public/                   # Public assets
```

---

## 🎨 Features in Detail

### User Roles & Permissions

- **👤 User** - Browse books, read stories, track personal progress
- **👨‍💼 Admin** - Manage books, view all user progress, moderate content
- **👑 Superadmin** - Full system access, user management, system configuration

### Reading Progress Tracking

The platform automatically tracks:
- Books started
- Pages read
- Reading completion percentage
- Reading history and timestamps

### Admin Dashboard

Administrators can:
- Add/Edit/Delete books with Cloudinary image uploads
- Manage user accounts and roles
- View comprehensive reading statistics
- Monitor platform usage and engagement

---

## 🌐 Deployment

The application is deployed on **Vercel** with the following configuration:

- **Production URL:** [ibnu-sina.vercel.app](https://ibnu-sina.vercel.app)
- **Database:** Aiven.io MySQL (SSL-enabled)
- **Media Storage:** Cloudinary CDN
- **Build Command:** `composer install && npm run build`

For detailed deployment instructions, see [DEPLOYMENT.md](./DEPLOYMENT.md).

---

## 🧪 Testing

Run the test suite:

```bash
php artisan test
```

Run specific test suites:

```bash
php artisan test --filter=CloudinaryCrudTest
```

---

## 📸 Screenshots

*(Add screenshots of your application here)*

- Dashboard
- Book browsing interface
- Reading progress tracker
- Admin CMS

---

## 🤝 Contributing

This is a student project developed collaboratively. While it's not currently open for external contributions, feel free to fork the repository for your own learning purposes.

---

## 👏 Acknowledgments

- **Design Team** - For creating the beautiful Figma designs that inspired this project
- **Laravel Community** - For excellent documentation and resources
- **Vercel** - For seamless deployment experience
- **Aiven & Cloudinary** - For reliable cloud infrastructure

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 📧 Contact

**Project Repository:** [github.com/hafidzmulia-its/sina](https://github.com/hafidzmulia-its/sina)

Built with ❤️ by the Sina team
