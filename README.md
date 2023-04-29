<h1 align="center">Selamat datang di Confess! 👋</h1>

![Landing Page](https://github.com/alfianchii/confess/blob/main/public/images/Confess-Welcome.png?raw=true)

[![All Contributors](https://img.shields.io/github/contributors/alfianchii/confess)](https://github.com/alfianchii/confess/graphs/contributors)
![GitHub last commit](https://img.shields.io/github/last-commit/alfianchii/confess)

---

<h2 id="tentang">🤔 Apa itu Confess?</h2>

Confess adalah aplikasi pelaporan pengaduan sekolah yang memungkinkan siswa/siswi untuk melaporkan masalah, keluhan, saran, dan kritik mereka secara online.

<h2 id="fitur">🤨 Fitur apa saja yang tersedia di Confess?</h2>

-   [Mazer Bootstrap Template](https://github.com/zuramai/mazer)
    -   <i>Dark</i> dan <i>Light</i> mode
    -   <i>Dashboard UI</i>
-   Landing Page
    -   <i>Homepage</i>
    -   Tentang
    -   Keluhan
    -   Kategori
-   Authentication
    -   <i>Registration</i>
    -   <i>Login</i>
-   Multi User
    -   <i>Admin</i>
        -   Statistik Keluhan
        -   Statistik Tanggapan
        -   Statistik Keluhan dan Tanggapan
        -   Membuat dan mengelola <i>responses</i>
        -   Menanggapi <i>complaints</i>
        -   Mengelola <i>categories</i>
        -   Mengelola <i>users</i>
        -   <i>Account</i>
    -   <i>Officer</i>
        -   Statistik Tanggapan
        -   Menanggapi <i>complaints</i>
        -   <i>Account</i>
    -   <i>Student</i>
        -   Membuat dan mengelola <i>complaints</i>
        -   <i>Account</i>
-   Account
    -   <i>Profile</i>
    -   <i>Setting</i>
    -   <i>Change Password</i>
-   CRUD (Create, Read, Update, and Delete)
    -   <i>Complaint</i>
    -   <i>Response</i>
    -   <i>Category</i>
    -   <i>User</i>
-   Pencarian <i>Complaint</i> di <i>Homepage</i>

<h2 id="testing-account">👤 Default Account for Testing</h2>

#### Admin

-   Username: alfianchii
-   Password: password

#### Officer

-   Username: fauzy
-   Password: password

#### Student

-   Username: nata.ardhana
-   Password: password

<h2 id="demo">🏠 Demo Page</h2>

<p>Halaman demo saat ini tidak tersedia. Oleh karenanya, lebih baik kamu mencoba di <i>local</i> dengan mengikuti tahapan instalasi di bawah ini.</p>

<h2 id="syarat">💾 Pre-requisite</h2>

<p>Berikut adalah <i>pre-requisite</i> yang diperlukan ketika melakukan instalasi dan <i>running</i> aplikasi.</p>

-   PHP ^8.0 & Web Server (XAMPP, LAMPP, MAMPP, atau Laragon)
-   Web Browser (Chrome, Firefox, Safari, Opera, atau Brave)

<h2 id="download">💻 Install</h2>

1. Clone repository

```bash
git clone https://github.com/alfianchii/confess.git
cd confess
composer install
npm install
copy .env.example .env
```

2. Konfigurasi database melalui `.env`

```
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

3. Migrasi dan symlinks

```bash
php artisan key:generate
php artisan migrate --seed
php artisan storage:link
```

4. Jalankan website

```bash
npm run dev
# Run in different terminal
php artisan serve
```

<h2 id="dukungan">💌 Support Me</h2>

<p>
Kamu bisa mendukung aku di platform Trakteer! Dukungan kamu akan sangat berarti. Namun, dengan kamu memberikan <i>star</i> pada <i>project</i> ini juga sudah sangat cukup kok~!
</p>

<a href="https://trakteer.id/alfianchii/tip" target="_blank"><img id="wse-buttons-preview" src="https://cdn.trakteer.id/images/embed/trbtn-red-5.png" height="40" style="border:0px;height:40px;" alt="Trakteer Saya"></a>

<h2 id="kontribusi">🤝 Contributing</h2>

<p>
<i>Contributions, issues and feature requests</i> sangat diapresiasi karena aplikasi ini jauh dari kata sempurna. Jangan ragu untuk melakukan <i>pull request</i> dan membuat perubahan pada <i>project</i> ini, yaaa!
</p>

<h2 id="lisensi">📝 License</h2>

<p>Confess is open-sourced software licensed under the MIT license.</p>

<h2 id="pembuat">🧍 Author</h2>

<p>Confess dibuat oleh <a href="https://instagram.com/alfianchii">Alfian</a> dan <a href="https://instagram.com/nata_ardhana">Surya</a>.</p>
