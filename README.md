# Lead Management CRM for CCTV & IT Service Businesses

A **professional, production-ready CRM** built with **Laravel** to manage **leads, complaints/service requests, estimates, projects, and technician assignments** — designed especially for **CCTV camera shops and IT service providers**.

This system helps businesses capture incoming leads, convert them into projects, manage after-sales service/complaints, generate estimates, and efficiently allocate work to technicians from a single dashboard.

---

##  Key Features

###  Lead Management

* Capture leads from walk-ins, calls, or online inquiries
* Track lead status (New, Follow-up, Converted, Closed)
* Assign leads to sales staff
* Maintain complete lead history

###  Complaint / Service Management

* Register customer complaints or service requests
* Track complaint status (Open, In Progress, Resolved)
* Assign service jobs to technicians
* Maintain service history per customer

###  Estimate & Quotation Management

* Create and manage estimates for CCTV installation or services
* Convert estimates into approved projects
* Maintain pricing transparency

###  Project Management

* Convert confirmed leads or estimates into projects
* Track project progress and milestones
* Manage installation or service tasks

###  Technician Work Allocation

* Assign tasks/projects to technicians
* Track technician workload and job status
* Improve on-field productivity

###  User & Role Management

* Secure authentication system
* Role-based access (Admin, Sales, Technician)
* Controlled access to sensitive modules

---

##  Tech Stack

* **Backend:** Laravel (PHP)
* **Frontend:** Blade + Bootstrap 5
* **Database:** MySQL
* **Authentication:** Laravel Auth
* **Hosting Ready:** Shared hosting (Hostinger, cPanel)

---

##  Project Structure

```
laravel-app/
├── app/                # Core application logic
├── bootstrap/          # Framework bootstrap files
├── config/             # Configuration files
├── database/           # Migrations & seeders
├── public/             # Public assets
├── resources/          # Blade views & assets
├── routes/             # Web routes
├── storage/            # Logs, cache, uploads
├── vendor/             # Composer dependencies
└── artisan             # Artisan CLI
```

---

##  Installation & Setup

### 1️ Clone the repository

```bash
git clone https://github.com/your-username/lead-management-crm.git
cd lead-management-crm
```

### 2️ Install dependencies

```bash
composer install
```

### 3️ Environment setup

```bash
cp .env.example .env
php artisan key:generate
```

### 4️ Database configuration

Update `.env` file with your database credentials:

```env
DB_DATABASE=your_database
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

### 5️ Run migrations

```bash
php artisan migrate
```

### 6️ Storage permissions

```bash
chmod -R 775 storage bootstrap/cache
```

### 7️ Serve the application

```bash
php artisan serve
```

---

##  Deployment Notes (Shared Hosting)

* Point domain root to the `public` directory or use an `index.php` bridge
* Set correct permissions for `storage` and `bootstrap/cache`
* Use `SESSION_DRIVER=file` or ensure `sessions` table exists

---

##  Security Best Practices

* Disable debug mode in production:

```env
APP_DEBUG=false
```

* Protect `.env` file
* Use strong database credentials

---

##  Use Cases

* CCTV Camera Shops
* Security System Installers
* IT Service Providers
* Maintenance & Support Teams

---

##  Future Enhancements

* Lead import/export
* SMS / WhatsApp notifications
* Invoice & payment tracking
* Technician mobile view
* Reports & analytics dashboard

---

##  Contribution

Contributions are welcome! Please fork the repository and submit a pull request.

---

##  License

This project is licensed under the **MIT License**.

---

## 👨‍💻 Developed By

**MOHAMMAD USMAN**
Professional CRM & Business Solutions

---

> Built to simplify lead capture, service management, and project execution for CCTV and IT service businesses.
