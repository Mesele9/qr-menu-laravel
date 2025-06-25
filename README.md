# Digital QR Menu System

A modern, flexible, and user-friendly digital menu system for restaurants, cafes, and hotels. Built with the Laravel framework, this application allows businesses to easily create and manage a dynamic menu accessible to guests via a simple QR code scan.


## Table of Contents

- [Project Vision](#project-vision)
- [Key Features](#key-features)
  - [Guest Experience](#guest-experience)
  - [Admin Panel](#admin-panel)
- [Technology Stack](#technology-stack)
- [Installation Guide](#installation-guide)
  - [Prerequisites](#prerequisites)
  - [Step-by-Step Setup](#step-by-step-setup)
- [Usage](#usage)
  - [Admin Access](#admin-access)
  - [Guest Access](#guest-access)
- [Future Enhancements](#future-enhancements)
- [Contributing](#contributing)
- [License](#license)

## Project Vision

To empower restaurants and hotels with a powerful yet easy-to-use tool for menu management, branding, and guest interaction. This system enhances the guest experience by providing a rich, interactive, and multi-language menu, while giving staff full control over content and presentation.

## Key Features

### Guest Experience (Frontend)

-   **QR Code Access:** Simple and fast access to the menu by scanning a QR code.
-   **Dynamic Branding:** The entire menu theme (colors, logo, fonts) is customized by the restaurant.
-   **Interactive Menu:** Browse categories and items in a clean, mobile-first single-page application.
-   **Specials Carousel:** An engaging, rotating carousel highlights Chef's Specials and promotions.
-   **Search & Filtering:** Instantly search for items by name or use one-click buttons to filter by dietary needs (e.g., Vegan, Gluten-Free).
-   **Item Details Modal:** Click any item to view a larger image, full description, tags, and all user reviews without leaving the menu.
-   **Rating & Review System:** Guests can leave a 1-5 star rating and an optional comment for any menu item.
-   **Multi-Language Support:** A fully functional language switcher translates all menu content (English, Amharic, Somali, Oromic).

### Admin Panel (Backend)

-   **Secure Authentication:** Protected login for authorized staff.
-   **Dynamic Dashboard:** At-a-glance statistics for menu items, categories, and pending reviews.
-   **Full CRUD Management:** Intuitive interfaces to Create, Read, Update, and Delete:
    -   **Menu Items:** Includes translatable names/descriptions, pricing, images, and status toggles.
    -   **Categories:** With drag-and-drop reordering for the menu display.
    -   **Tags & Allergens:** Create general tags (e.g., "Popular") or dietary/allergen tags with Font Awesome icons.
-   **Review Moderation:** Approve, hide, or delete guest-submitted reviews.
-   **Branding & Customization:** A powerful settings page to:
    -   Upload a company logo.
    -   Set company information (name, address, social links).
    -   Define a complete color scheme with live color pickers.
    -   Set a default language for first-time visitors.
-   **Built-in QR Code Generator:** Generate and download a high-resolution QR code for print materials directly from the admin panel.

## Technology Stack

-   **Backend:** PHP 8.2+ / Laravel 11
-   **Database:** MySQL / MariaDB
-   **Frontend:** Blade Templates, Bootstrap 5, Vanilla JavaScript
-   **Key Packages:**
    -   `spatie/laravel-translatable` for elegant multi-language model attributes.
    -   `spatie/laravel-honeypot` for spam protection on review forms.
    -   `simplesoftwareio/simple-qrcode` for QR code generation.

## Installation Guide

### Prerequisites

-   PHP 8.2 or higher
-   Composer
-   Node.js & NPM
-   A MySQL/MariaDB database

### Step-by-Step Setup

1.  **Clone the Repository**
    ```bash
    git clone https://github.com/Mesele9/qr-menu-laravel.git
    cd digital-menu
    ```

2.  **Install Dependencies**
    ```bash
    composer install
    npm install
    npm run build
    ```

3.  **Environment Configuration**
    -   Copy the example environment file: `cp .env.example .env`
    -   Generate an application key: `php artisan key:generate`
    -   Open the `.env` file and configure your database credentials (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`).
    -   Set your application URL: `APP_URL=http://localhost:8000`

4.  **Database Migration**
    -   Run the migrations to create the database tables:
        ```bash
        php artisan migrate
        ```

5.  **Create Storage Link**
    -   This makes uploaded images publicly accessible:
        ```bash
        php artisan storage:link
        ```

6.  **Serve the Application**
    -   Start the local development server:
        ```bash
        php artisan serve
        ```
    -   The application will be available at `http://localhost:8000`.

## Usage

### Admin Access

-   Navigate to `/register` to create your first admin account.
-   After registering, log in at `/login`.
-   You will be redirected to the admin dashboard where you can manage all aspects of the menu.

### Guest Access

-   Navigate to the root URL (`/`) to view the live guest menu.

## License

This project is open-source and licensed under the MIT License. See the [LICENSE](LICENSE.md) file for more details.