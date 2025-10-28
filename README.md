# 🏢 Multi-Tenant Admin Panel (Laravel + JavaScript)

A powerful and modular **Multi-Tenant Admin Panel** built with **Laravel** and **JavaScript (AJAX)**.  
This system enables centralized management of multiple tenants and provides each tenant with tools to manage their own users, content, and business sections — all in real time, without page reloads.

---

## 🚀 Features Overview

### 🧩 Multi-Tenancy
- Separate data and access control for each tenant.
- Central **Super Admin** panel to create, update, or suspend tenants.
- Each tenant has an isolated dashboard and data environment.
- Configurable tenant identification (via subdomain, tenant code, or ID).

---

### 👥 User Management
- Manage tenant users: create, edit, delete, activate, or deactivate.
- AJAX-powered CRUD operations for smooth, no-reload interactions.
- Role-based access control for administrators, managers, and editors.
- Secure authentication system powered by **Laravel Auth**.

---

### 🗂️ Categories Management
- Organize content and items through category management.
- Fully dynamic CRUD with AJAX requests.
- Server-side validation and error handling.

---

### 💬 Messages Center
- Manage user and client messages efficiently.
- Filter between reviewed and unreviewed messages.
- Mark messages as read/unread in real time.
- Exporting messages to excel sheet

---

### 🏛️ Company Information Management
Manage all company-related public content easily:

| Section | Description |
|----------|-------------|
| **About Us** | Add and edit company overview and story |
| **Mission** | Define the company’s mission and goals |
| **Vision** | Present the long-term vision and values |
| **Partners** | Manage business partners or collaborations |
| **Clients** | Showcase client logos or testimonials |
| **Services** | Create and manage offered services |
| **Products** | Manage product listings, categories, and details |

All sections are **editable through the admin panel** using **AJAX-powered forms**.

---

### 📊 Dashboard
- Overview of tenant statistics (users, products, messages, etc.).
- Real-time updates through AJAX calls.

---

## 🛠️ Tech Stack

| Technology | Purpose |
|-------------|----------|
| **Laravel 10+** | Backend framework |
| **JavaScript (AJAX)** | Frontend interactivity |
| **Bootstrap 5** | Responsive UI components |
| **MySQL** | Database |
| **Blade Templates** | View rendering |
| **jQuery / Fetch API** | AJAX request handling |
