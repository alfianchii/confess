<h1 align="center">Welcome to Confess! 👋</h1>

![Landing Page](https://github.com/alfianchii/confess/blob/main/public/images/confess-welcome.png?raw=true)

[![All Contributors](https://img.shields.io/github/contributors/alfianchii/confess)](https://github.com/alfianchii/confess/graphs/contributors)
![GitHub last commit](https://img.shields.io/github/last-commit/alfianchii/confess)

---

<h2 id="tentang">🤔 What is Confess?</h2>

Confess is a school complaint reporting application that enables students to submit their issues, grievances, suggestions, criticisms, and even confessions online.

<h2 id="fitur">🤨 What features are available in Confess?</h2>

-   [Mazer Bootstrap Template](https://github.com/zuramai/mazer)
    -   Dark and light mode
    -   Dashboard UI
-   Landing Page
    -   Homepage
    -   About
    -   Confession
    -   Confession's Category
-   Authentication
    -   Registration
    -   Login
-   Multi User
    -   Admin
        -   Confession Statistics
        -   Response Statistics
        -   Confession and Response Statistics
        -   Create and manage responses
        -   Respond to confessions
        -   Manage categories
        -   Manage users
        -   Account
    -   Officer
        -   Response Statistics
        -   Respond to confessions
        -   Account
    -   Student
        -   Create and manage complaints
        -   Account
-   Account
    -   Profile
    -   Setting
    -   Change Password
-   CRUD (Create, Read, Update, and Delete)
    -   Confession
    -   Response
    -   Category
    -   User
-   Confession search on the Homepage

<h2 id="testing-account">👤 Default Account for Testing</h2>

#### Admin

-   Username: alfianchii
-   Password: password

#### Officer

-   Username: moepoi
-   Password: password

#### Student

-   Username: nata.ardhana
-   Password: password

<h2 id="demo">🏠 Demo Page</h2>

<p>The demo page is currently unavailable. Therefore, it is advisable for you to try it locally by following the installation steps below.</p>

<h2 id="syarat">💾 Pre-requisite</h2>

<p>Here are the prerequisites required for installing and running the application.</p>

-   PHP ^8.0 & Web Server (Apache, Lighttpd, or NGinx)
-   Web Browser (Firefox, Safari, Opera, or Brave)

<h2 id="download">💻 Installation</h2>

1. Clone repository

```bash
git clone https://github.com/alfianchii/confess.git
cd confess
composer install
npm install
copy .env.example .env
```

2. Database configuration through the `.env` file

```
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

3. Migrations and symlinks

```bash
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

4. Launch the website

```bash
npm run dev
# Run in different terminal
php artisan serve
```

<h2 id="dukungan">💌 Support Me</h2>

<p>You can support me on the Trakteer platform! Your support will be very meaningful. just giving a star to this project is already greatly appreciated~!</p>

<a href="https://trakteer.id/alfianchii/tip" target="_blank"><img id="wse-buttons-preview" src="https://cdn.trakteer.id/images/embed/trbtn-red-5.png" height="40" style="border:0px;height:40px;" alt="Trakteer Me"></a>

<h2 id="kontribusi">🤝 Contributing</h2>

<p>
Contributions, issues, and feature requests are highly appreciated as this application is far from perfect. Please do not hesitate to make a pull request and make changes to this project!</p>

<h2 id="lisensi">📝 License</h2>

<p>Confess is open-sourced software licensed under the MIT license.</p>

<h2 id="pembuat">🧍 Author</h2>

<p>Confess is created by <a href="https://instagram.com/alfianchii">Alfian</a> and <a href="https://instagram.com/nata_ardhana">Surya</a>.</p>
