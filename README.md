# Brewtica — Coffee Shop Web Application

A full-featured coffee shop management platform built with PHP using a custom MVC architecture. Brewtica lets customers explore a rich three-level menu, manage favourites, and add items to their cart — while admins control every aspect of the menu and staff from a dedicated dashboard.

---

## Features

### Customer
- Browse a hierarchical menu (Main Category → Sub-category → Item)
- View product details: description, ingredients, sizes, and prices
- Add items to cart with size selection (S / M / L) and quantity control
- Manage a personal favourites / wishlist
- Update profile information (date of birth, gender, phone)

### Admin
- Role-protected dashboard (only accessible by `admin` role)
- Full CRUD for main categories, sub-categories, and sub-sub-categories
- Full CRUD for menu items with image uploads
- Staff management — create, view, update, and delete users of any role

---

## Tech Stack

| Layer        | Technology                          |
|--------------|-------------------------------------|
| Backend      | PHP 8.2                             |
| Database     | MariaDB / MySQL                     |
| DB Access    | PDO with prepared statements        |
| Frontend     | HTML5, Bootstrap 5, Vanilla JS      |
| Icons        | Bootstrap Icons                     |
| Architecture | Custom MVC (no framework)           |
| Web Server   | Apache + mod_rewrite (XAMPP)        |

---

## Prerequisites

- **PHP 8.0+** (tested on PHP 8.2)
- **MySQL or MariaDB** — included in XAMPP
- **Apache** with `mod_rewrite` enabled — included in XAMPP
- **XAMPP** (recommended for local development on Windows/macOS/Linux)

---

## Quick Start (under 5 minutes)

### 1. Clone the repository

```bash
git clone https://github.com/your-username/brewtica.git
cd brewtica
```

---

### 2. Create the database

Open **phpMyAdmin** at `http://localhost/phpmyadmin` and:

1. Click **New** and create a database named `brewtica__db`
2. Select the database, go to the **Import** tab
3. Choose the file `brewtica__db.sql` from the project root and click **Go**

Or via the command line:

```bash
mysql -u root -p brewtica__db < brewtica__db.sql
```

---

### 3. Configure the environment

Copy the example file and edit it:

```bash
cp .env.example .env
```

Open `.env` and set the values for your local setup:

```env
# Your local URL — must end with a slash
APP_URL=http://brewtica.local/

# Database (XAMPP defaults shown)
DB_HOST=localhost
DB_NAME=brewtica__db
DB_USER=root
DB_PASS=
```

---

### 4. Point Apache at the `public/` directory

**Recommended — Virtual Host** (clean URLs, no subfolder in the address bar):

Add the following block to your Apache `httpd-vhosts.conf`
(e.g. `C:\xampp\apache\conf\extra\httpd-vhosts.conf`):

```apache
<VirtualHost *:80>
    ServerName brewtica.local
    DocumentRoot "C:/xampp/htdocs/brewtica/public"
    <Directory "C:/xampp/htdocs/brewtica/public">
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

Then add the following line to your system `hosts` file
(`C:\Windows\System32\drivers\etc\hosts` on Windows):

```
127.0.0.1   brewtica.local
```

Restart Apache, then set `APP_URL=http://brewtica.local/` in `.env`.

---

**Alternative — No virtual host** (subfolder access):

If you place the project directly inside `htdocs/brewtica`, set:

```env
APP_URL=http://localhost/brewtica/public/
```

and access the app at `http://localhost/brewtica/public/`.

---

### 5. Open the app

Navigate to your configured URL (e.g. `http://brewtica.local/`).

The database import includes seed data with a full menu and test accounts.
To create an admin account, register normally then update the `role` column
in the `users` table to `admin` via phpMyAdmin.

---

## Project Structure

```
brewtica/
├── app/
│   ├── controllers/
│   │   ├── AdminController.php      # Admin dashboard, menu, category, staff
│   │   ├── HomeController.php       # Public pages (home, menu, drinks)
│   │   ├── ProfileController.php    # Cart, favourites, account
│   │   └── UserController.php       # Register, login, logout, profile update
│   ├── middlewares/
│   │   ├── AuthMiddleware.php       # Redirects unauthenticated users
│   │   └── RoleMiddleware.php       # Restricts routes by role
│   ├── models/
│   │   ├── Add_To_Menu.php          # Menu, categories, cart, favourites logic
│   │   ├── Database.php             # PDO singleton connection
│   │   └── User.php                 # User registration, login, profile
│   ├── views/
│   │   ├── admin/                   # Admin page templates
│   │   ├── home/                    # Customer-facing page templates
│   │   ├── layouts/                 # Page layouts (admin, auth, profile)
│   │   ├── partials/                # Reusable UI fragments (navbar, modals…)
│   │   └── user/                    # Registration page template
│   ├── init.php                     # Bootstrap: session, config, autoloader
│   └── helpers.php                  # Global utility functions
├── config/
│   └── config.php                   # Reads .env and returns config array
├── public/                          # ← Web root (set as Apache DocumentRoot)
│   ├── index.php                    # Front controller / entry point
│   ├── .htaccess                    # URL rewriting (all requests → index.php)
│   ├── css/                         # Stylesheets
│   ├── scripts/                     # JavaScript files
│   ├── images/                      # Static product and category images
│   └── uploads/                     # User-uploaded images (gitignored)
│       ├── products/
│       └── sub_categories/
├── routes/
│   └── web.php                      # All GET and POST route definitions
├── .env                             # Local environment config (gitignored)
├── .env.example                     # Template — copy to .env and fill in
├── .gitignore
├── brewtica__db.sql                 # Full database schema + seed data
└── README.md
```

---

## Routes Reference

### Public

| Method | Path            | Description                      |
|--------|-----------------|----------------------------------|
| GET    | `/`             | Home page                        |
| GET    | `/menu_B`       | Full menu browser                |
| GET    | `/drinks_B`     | Drinks listing                   |
| GET    | `/user/join_B`  | Registration page                |
| POST   | `/join_B`       | Register a new account (JSON)    |
| POST   | `/sign_in_B`    | Login (JSON)                     |
| POST   | `/logout`       | Logout and redirect              |

### Authenticated (any logged-in user)

| Method | Path                       | Description                     |
|--------|----------------------------|---------------------------------|
| GET    | `/fav_list_B`              | Favourites list                 |
| GET    | `/my_account_B`            | Account settings page           |
| GET    | `/bag_B`                   | Shopping cart                   |
| POST   | `/favourites_handler`      | Toggle favourite (JSON)         |
| POST   | `/delete_favorite`         | Remove from favourites          |
| POST   | `/bag_handler`             | Add item to cart (JSON)         |
| POST   | `/update_size`             | Change cart item size (JSON)    |
| POST   | `/update_quantity`         | Inc / Dec cart quantity (JSON)  |
| POST   | `/remove_from_bag`         | Remove cart item (JSON)         |
| POST   | `/toggle_cart_item_check`  | Check / uncheck cart item       |
| POST   | `/my_account_B`            | Save profile changes            |

### Admin only

| Method | Path                            | Description                        |
|--------|---------------------------------|------------------------------------|
| GET    | `/dashboard_B`                  | Admin dashboard                    |
| GET    | `/admin/categories_B`           | Category management page           |
| GET    | `/admin/menu_B`                 | Menu management page               |
| GET    | `/admin/staff_B`                | Staff management page              |
| POST   | `/categories`                   | Create category (JSON)             |
| POST   | `/category_api?action=fetch`    | Fetch category by ID (JSON)        |
| POST   | `/category_api?action=update`   | Update category (JSON)             |
| POST   | `/delete_category`              | Delete category (JSON)             |
| POST   | `/admin_menu`                   | Create menu item (JSON)            |
| POST   | `/menu_api?action=fetch`        | Fetch menu item by ID (JSON)       |
| POST   | `/menu_api?action=update`       | Update menu item (JSON)            |
| POST   | `/delete_item`                  | Delete menu item (JSON)            |
| POST   | `/staff`                        | Create staff / user (JSON)         |
| POST   | `/staff_api?action=fetch`       | Fetch user by ID (JSON)            |
| POST   | `/staff_api?action=update`      | Update user (JSON)                 |
| POST   | `/delete_user`                  | Delete user                        |

---

## Environment Variables

| Variable     | Default                  | Description                          |
|--------------|--------------------------|--------------------------------------|
| `APP_URL`    | `http://localhost/`      | Base URL — must end with `/`         |
| `APP_DEBUG`  | `false`                  | Set `true` to enable debug output    |
| `DB_HOST`    | `localhost`              | Database host                        |
| `DB_NAME`    | `brewtica__db`           | Database name                        |
| `DB_USER`    | `root`                   | Database username                    |
| `DB_PASS`    | *(empty)*                | Database password                    |
| `DB_PORT`    | `3306`                   | Database port                        |
| `DB_CHARSET` | `utf8mb4`                | Database character set               |

---

## Database Schema (Overview)

| Table                    | Purpose                                          |
|--------------------------|--------------------------------------------------|
| `users`                  | All accounts (customer, admin, employee)         |
| `user_phones`            | Phone numbers (1-to-1 with users)               |
| `main_categories`        | Top-level menu categories (e.g. Drinks, Food)    |
| `sub_categories`         | Second level (e.g. Hot Coffee, Smoothies)        |
| `sub_sub_categories`     | Third level (e.g. Lattes, Cold Brew)             |
| `menu_items`             | Individual products                              |
| `menu_item_size_price`   | Size/price pairs per product (S, M, L)           |
| `cart`                   | Active shopping cart items                       |
| `favorites`              | User wishlist / favourites                       |
| `orders`                 | Order records *(schema ready)*                  |
| `order_details`          | Line items per order *(schema ready)*           |
| `payments`               | Payment records *(schema ready)*               |
| `deliveries`             | Delivery tracking *(schema ready)*             |

> Tables marked *schema ready* have their structure in place but the order/payment/delivery flow has not been implemented in the application yet.

---

## Security Notes

- Passwords hashed with `PASSWORD_BCRYPT` via `password_hash()` / `password_verify()`
- All database queries use PDO prepared statements (no raw SQL concatenation with user input)
- Input sanitized with `htmlspecialchars` + `strip_tags` via `sanitize()`
- Role-based access enforced at the controller level via `AuthMiddleware` and `RoleMiddleware`
- Credentials stored in `.env` (gitignored) — never hardcoded

---

## License

This project is open-source and available under the [MIT License](LICENSE).
