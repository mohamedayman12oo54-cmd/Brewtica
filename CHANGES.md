# GitHub Preparation — Changes Documentation

This document describes every change made to prepare the Brewtica project for GitHub publication.
No core application logic was altered. All changes fall into one of three categories:
**new files added**, **existing files cleaned**, or **a bug fixed**.

---

## New Files Created

### `.env`
Stores all environment-specific configuration (database credentials, app URL) outside of the
codebase. This file is **gitignored** and must be created locally by each developer.

### `.env.example`
A committed template that shows exactly which variables need to be set, with safe default values.
Developers copy this to `.env` and fill in their own values. This is the standard pattern for
open-source PHP projects.

### `.gitignore`
Prevents sensitive or environment-specific content from being committed:
- `.env` — contains real credentials
- `public/uploads/products/*` and `public/uploads/sub_categories/*` — user-generated files that
  should not be tracked in version control
- `vendor/` — Composer dependencies (not applicable now but standard to include)
- OS files: `.DS_Store`, `Thumbs.db`
- IDE directories: `.idea/`, `.vscode/`
- Log files: `*.log`

### `public/uploads/products/.gitkeep`
### `public/uploads/sub_categories/.gitkeep`
Git does not track empty directories. The application needs the `uploads/` folder structure to
exist so it can write uploaded files without errors. Empty `.gitkeep` files preserve these
directories in the repository while all actual uploaded content remains gitignored.

### `README.md`
A professional entry-point document for anyone visiting the repository. Covers:
- Project overview and feature list
- Tech stack table
- Prerequisites
- Step-by-step quick-start guide (under 5 minutes)
- Full annotated project structure
- Routes reference table (public, authenticated, admin)
- Environment variable reference
- Database schema overview
- Security notes

### `CHANGES.md` (this file)
Documents every change made during GitHub preparation so the author has a complete record.

---

## Modified Files

---

### `config/config.php`

**Before:** Hardcoded database credentials (`host`, `database`, `username`, `password`) and
application settings (`base_url`, `debug`) directly in the file.

**After:** The file now parses the `.env` file at startup and exposes an `env()` helper function.
All config values are read from `.env` with sensible fallbacks so the application still works
even if a `.env` key is missing.

Key details:
- `.env` parsing is **idempotent** — it checks `array_key_exists` before setting each key, so
  calling `config()` multiple times (which re-requires this file) is safe.
- `env()` is wrapped in `function_exists()` to prevent "Cannot redeclare" errors on repeated
  file inclusion.
- `APP_DEBUG` defaults to `false` — appropriate for a public repository.

---

### `app/init.php`

**Removed:** `require_once __DIR__ . "/../config/database.php";`

`config/database.php` was being loaded but its return value was never captured or used anywhere.
The `Database` model reads configuration through the `config()` helper, which calls
`config/config.php` directly. Loading the redundant file was dead code.

**Also:** Minor formatting clean-up (consistent indentation, removed trailing blank line).

---

### `public/index.php`

**Removed:** A 12-line commented-out alternative routing implementation (lines 32–43 in the
original). This was an earlier version of the router that used `$routes[$request]` (no HTTP
method separation). The active router below it already handles routing correctly with method
support. Dead code adds confusion with no benefit.

**Also:** Minor formatting (consistent spacing).

---

### `app/helpers.php`

**Removed:**
1. Two commented-out lines inside `base_url()` — an older URL-building variant that was
   superseded by the active implementation.
2. A three-line commented-out `ob_start()` / `ob_get_clean()` block inside `render()` — the
   identical logic immediately below it was the active version.

**Removed function:** `checkUserLoggedIn()` — this function called `redirect("login.php")` which
points to a non-existent route. It was never called anywhere in the codebase.

**Simplified:** `isUserLoggedIn()` — replaced a verbose `if/else` that returned `true` or `false`
with a single `return` expression (equivalent behaviour, cleaner code).

**Formatting:** Consistent spacing around operators and function signatures throughout.

---

### `app/controllers/HomeController.php`

**Removed:** Two commented-out `render(null, [], 'layout.php')` lines (one inside `index()`,
one inside `showMenu_B()`). These were earlier render calls replaced by the active ones directly
above them.

---

### `app/controllers/UserController.php`

**Removed:**
1. In `showJoinForm()`: a commented-out `$data` array (`['title' => "Register"]`) that was never
   used.
2. In `sign_in()`: a 23-line commented-out redirect-based login handler — the active JSON-based
   handler below it replaced it entirely.
3. In `UpdateUserInfo()`: a commented-out `echo "Registration data succeed"` line.

**Fixed:** Error message in `UpdateUserInfo()` changed from `"Registration data failed"` (wrong
context — this function updates a profile, not a registration) to `"Failed to update profile"`.

---

### `app/controllers/ProfileController.php`

**Removed:** The entire empty constructor:
```php
public function __construct() {
    // AuthMiddleware::requiredLogin();
}
```
The only line inside it was commented out, making the constructor a no-op. Removing it has no
effect on behaviour.

**Translated:** Arabic user-facing API message:
- Before: `'الرجاء تسجيل الدخول لإضافة المنتجات للمفضلة.'`
- After: `'Please log in to add items to your favorites.'`

Same change in `bag_handler()` (message was already in English but slightly reworded for
consistency).

**Simplified:** `delete_favorite()` — the verbose `if/else` echo pattern replaced with a
ternary on a single line (equivalent logic).

---

### `app/controllers/AdminController.php`

**Removed five large commented-out blocks:**

1. **`category()` — lines 34–84:** An old form-submission-based category creation flow
   (checked `$_POST['submit_main']`, `$_POST['submit_sub']`, etc.). The active code below it
   is the JSON API version that replaced it.

2. **`menu()` — lines 335–366:** An old form-submission-based menu item creation flow.
   Replaced by the active JSON API implementation.

3. **`staff()` — lines 534–553:** An old form-submission-based staff creation flow.
   Replaced by the active JSON API implementation.

4. **`delete_user()` — lines 639–643:** A commented-out admin ID check (`$adminId`) that was
   never wired up. The `$adminId` variable was also commented out.

5. **Inline Arabic comments** throughout (`// جلب عنصر`, `// البيانات المرسلة`, etc.) —
   these described what the adjacent code was doing (obvious from reading the code) and were
   not meaningful documentation.

**Fixed:** In `menu()`, the error response code was changed from `401` (Unauthorized) to `500`
(Internal Server Error) — a failed DB insert is a server error, not an auth failure.

**Fixed:** In `staff()`, the error response code changed from `401` to `422` (Unprocessable
Entity) — more semantically correct for a failed registration.

---

### `app/middlewares/AuthMiddleware.php`

**Removed:** Two full commented-out class definitions — the same `AuthMiddleware` class was
defined three times in the file (once active, twice commented out). The two commented versions
were experiments for API-detection logic (skipping the middleware for XHR requests). Only the
active, working class was kept.

---

### `app/models/User.php`

**Removed Arabic comments** (translated where the meaning was non-obvious, removed where the
code speaks for itself):
- `// نضيفهم مع بيانات المستخدم` → removed (obvious: assigning `phone` to the user array)
- `// نبدأ معاملة واحدة (Transaction) ...` → translated to English comment explaining the
  transaction's purpose
- `// حفظ كل التغييرات` → removed (calling `commit()` is self-explanatory)
- `// لو حصل خطأ نرجع الوضع زي ما كان` → removed (calling `rollBack()` is self-explanatory)

**Removed:** `// return true;` — a commented-out earlier return in `register()` replaced by
the active `return $this->conn->lastInsertId()`.

**Fixed bug in `deleteUser()`:**
The original code did `$record = $this->fetchById($id)` then `if($record)`. Because
`fetchById()` always returns a non-empty array (either `['success' => true, ...]` or
`['success' => false, ...]`), `if($record)` was **always true** — even when the user was not
found. This means the code would attempt a `DELETE` regardless of whether the user existed
(though it would safely affect 0 rows). Also, it then accessed `$record->image` (object
syntax) on an array, which would generate a PHP warning. The dead image-deletion block (the
`users` table has no `image` column) was removed. The fix: check `$record['success']` before
proceeding.

**Refactored `updateById()`:** Extracted the `explode(" ", $fullname)` logic into named
variables (`$f_name`, `$l_name`) to eliminate the repeated inline expressions.

---

### `app/models/Add_To_Menu.php`

This file had the most accumulated dead code. Three large commented-out function duplicates
were removed:

**1. `getSubCategoriesWithItems()` (lines 142–168, ~27 lines):**
An early implementation that fetched the nested menu structure. It was superseded by
`getFullMenuStructure()` which uses the 3-level category hierarchy introduced later.

**2. First `updateItemById()` (lines 288–361, ~74 lines):**
The original buggy version contained a typo — `$data['$ingredients']` (with a literal `$`
in the string key) which would always return an empty string. The active version below it
fixes this as `$data['ingredients']`.

**3. Two versions of `updateCatById()` (lines 628–745, ~118 lines):**
Two commented-out earlier versions of the function, each slightly different. Only the active
third version was kept.

**Removed in `removeFromBag()`:** Two commented-out transaction calls
(`// $this->conn->beginTransaction();` and `// $this->conn->commit();`). A single DELETE
statement does not need a transaction.

**Fixed typos in API response messages:**
| Before | After |
|--------|-------|
| `'The deleteing from favorites done!'` | `'Removed from favorites'` |
| `'The inserting to favorites done!'` | `'Added to favorites'` |
| `'Updateing favorites error: '` | `'Favorites error: '` |

**Added section divider comments** to group the class's methods by responsibility
(Category CRUD / Menu Queries / Menu Item CRUD / Favorites / Cart). These replace the
previous mix of Arabic and English inline descriptions.

**Fixed `deleteCatById()`:** Used `$record['data']['image']` (correct array access) instead of
`$record->image` (object syntax on an array, which would cause a warning).

---

## Summary Table

| File | Type of Change |
|------|----------------|
| `.env` | New file |
| `.env.example` | New file |
| `.gitignore` | New file |
| `public/uploads/products/.gitkeep` | New file |
| `public/uploads/sub_categories/.gitkeep` | New file |
| `README.md` | New file |
| `CHANGES.md` | New file |
| `config/config.php` | Refactored — loads from `.env` |
| `app/init.php` | Cleaned — removed dead `require` |
| `public/index.php` | Cleaned — removed commented-out block |
| `app/helpers.php` | Cleaned — removed dead code and functions |
| `app/controllers/HomeController.php` | Cleaned — removed commented lines |
| `app/controllers/UserController.php` | Cleaned + minor wording fixes |
| `app/controllers/ProfileController.php` | Cleaned + translated Arabic message |
| `app/controllers/AdminController.php` | Cleaned — removed 5 large commented blocks |
| `app/middlewares/AuthMiddleware.php` | Cleaned — removed 2 duplicate class definitions |
| `app/models/User.php` | Cleaned + bug fix in `deleteUser()` |
| `app/models/Add_To_Menu.php` | Cleaned — removed ~220 lines of dead code + typo fixes |
