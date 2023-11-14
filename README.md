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
    -   Comment
    -   Confession's category
-   Authentication
    -   Registration
    -   Login
-   Multi User
    -   Admin
        -   History login, confession, response, and comment statistics (full overview)
        -   Manageable users
        -   Manageable confession's categories
        -   Manageable website informations
        -   Deactivate their own account
    -   Officer
        -   History login, confession, response, and comment statistics (half overview)
        -   Handling student's confessions
    -   Student
        -   History login, confession, response, and comment statistics (shallow overview)
        -   Submit confessions
    -   All
        -   Comment to a confession on Landing Page
        -   Account
        -   Export and import
-   Account
    -   Profile
    -   Setting
    -   Change Password
-   Searchable Landing Page
    -   Confessions
    -   Confession's categories

<h2 id="testing-account">👤 Default Account for Testing</h2>

#### Admin

-   Username: alfianchii
-   Password: admin123

#### Officer

-   Username: moepoi
-   Password: officer123

#### Student

-   Username: nata.ardhana
-   Password: student123

<h2 id="demo">🏠 Demo Page</h2>

<p>The demo page is currently unavailable. Therefore, it is advisable for you to try it locally by following the installation steps below.</p>

<h2 id="pre-requisite">💾 Pre-requisite</h2>

<p>Here are the prerequisites required for installing and running the application.</p>

-   PHP ^8.0 & Web Server (Apache, Lighttpd, or NGINX)
-   Database (MySQL or PostgreSQL)
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
DB_DATABASE=confess
DB_USERNAME=yourUsername
DB_PASSWORD=yourPassword
```

3. Migration and symlink

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

<p>You can support me on the Trakteer platform! Your support will be very meaningful. Like, just giving a star to this project is already greatly appreciated~!</p>

<a href="https://trakteer.id/alfianchii/tip" target="_blank"><img id="wse-buttons-preview" src="https://cdn.trakteer.id/images/embed/trbtn-red-5.png" height="40" style="border:0px;height:40px;" alt="Trakteer Me"></a>

<h2 id="kontribusi">🤝 Contributing</h2>

<p>
Contributions, issues, and feature requests are highly appreciated as this application is far from perfect. Please do not hesitate to make a pull request and make changes to this project!</p>

<h2 id="lisensi">📝 License</h2>

Confess is open-sourced software licensed under the [MIT License](./LICENSE).

<h2 id="pembuat">🧍 Author</h2>

<p>Confess is created by <a href="https://instagram.com/alfianchii">Alfian</a> and <a href="https://instagram.com/nata_ardhana">Surya</a>.</p>
