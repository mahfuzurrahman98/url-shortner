# URL Shortener

## Description

The URL Shortener Service is a full-stack web application developed using Laravel and Vue.js. The application allows users to shorten URLs and provides functionality to redirect users from the shortened URL to the original URL. It includes URL validation and safety checks using the Google Safe Browsing API to ensure that the URLs are safe to access.

## Prerequisites

Before running the URL Shortener Service locally, make sure you have the following prerequisites installed:

-   PHP
-   Composer
-   Node.js
-   npm
-   MySQL

## Features

-   User-friendly interface for adding URLs to generate short unique URLs
-   Valid URL format with 6-symbol alphanumeric hashes
-   Recognizes duplicate URLs and returns previously created short URLs
-   URL safety checks using Google Safe Browsing API
-   Redirects users from short URLs to original URLs

## Technologies Used

-   **Frontend:**

    -   Vue.js
    -   HTML/CSS
    -   Tailwind CSS

-   **Backend:**

    -   Laravel
    -   PHP
    -   MySQL

-   **API Integration:**

    -   Google Safe Browsing API

-   **Development Tools:**

    -   Composer
    -   npm (Node Package Manager)
    -   Git

## API Documentation

**POST:** /api/shortens

`{ originalUrl: "https://github.com" }`

**GET:** /api/shortes/:hash

## Setup Guide

### Prerequisites

Ensure you have the following installed:

-   Git
-   Composer
-   Node.js and npm (or yarn)
-   MySQL database server

### Steps

1. **Clone the Repository:**

    ```bash
    git clone git@github.com:mahfuzurrahman98/url-shortner.git
    cd url-shortener
    ```

2. **Setting Up the Server:**

    - Navigate to the server directory:
        ```bash
        cd server
        ```
    - Install server dependencies:
        ```bash
        composer install
        ```
    - Create a `.env` file from the `.env.example` template:
        ```bash
        cp .env.example .env
        ```
    - Generate an application key:
        ```bash
        php artisan key:generate
        ```
    - Update the `.env` file with your database credentials and Google Safe Browsing API key:

        ```
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=url_shortener
        DB_USERNAME=root
        DB_PASSWORD=yourpassword

        GOOGLE_SAFE_BROWSING_API_KEY=your_google_safe_browsing_api_key
        ```

    - Import the provided MySQL database dump:
        ```bash
        mysql -u root -p url_shortener < path_to_your_mysql_dump.sql
        ```
    - Run database migrations:
        ```bash
        php artisan migrate
        ```
    - Start the Laravel development server:
        ```bash
        php artisan serve
        ```

3. **Setting Up the Client:**

    - Navigate to the client directory:
        ```bash
        cd ../client
        ```
    - Install client-side dependencies:
        ```bash
        npm install
        ```
    - Update the API base URL in the client configuration file (if needed).
    - Start the Vue.js development server:
        ```bash
        npm run dev
        ```

4. **Access the Application:**

    Open your web browser and navigate to [http://127.0.0.1:5173](http://127.0.0.1:5173) to access the URL Shortener Service application.

    - Example of working URLs hashes:
        - KDZx1b
        - qQ3wOu
        - LxubtF
        - LGA4s2
        - 80youa
        - wkKkkJ
        - 9q7BAq
        - HewKEA
        - slIlpw
    - Example of some URLs that will be marked as unsafe by Google safe browsing API, if user tries to crate short URL for them:
        ```bash
        http://testsafebrowsing.appspot.com/s/malware.html
        http://testsafebrowsing.appspot.com/s/phishing.html
        ```
