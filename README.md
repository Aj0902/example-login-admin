
# 🔐 Panduan Sistem Login Admin (PHP Native)

**Studi Kasus:**  
Sistem autentikasi admin sederhana untuk pembelajaran **logika dasar PHP Session tanpa framework**.

---

## 🛠️ Persyaratan Sistem

Pastikan environment lokal kamu sudah siap tempur:

| Software | Keterangan | Status |
|--------|------------|--------|
| XAMPP | Recommended (Windows / Linux) | ✅ |
| Laragon | Alternatif ringan (Windows) | 🆗 |
| Browser | Chrome / Firefox / Edge | ✅ |

---

## 🚀 Instalasi Cepat (3 Langkah)

Ikuti langkah berikut agar sistem berjalan mulus di komputermu.

### 1️⃣ Siapkan Folder Project

Masuk ke direktori instalasi XAMPP (biasanya di `C:\`) lalu buat folder project:

```text
C:\xampp\htdocs\kemuning-admin\
````

---

### 2️⃣ Pindahkan File

Pastikan **dua file berikut berada di dalam folder project**:

* 📄 `login.php` → Halaman Login
* 📄 `index.php` → Halaman Dashboard Admin

---

### 3️⃣ Eksekusi Program

1. Nyalakan **Apache** melalui XAMPP Control Panel
2. Buka browser dan akses URL berikut:

```text
http://localhost/kemuning-admin/login.php
```

---

## 🔑 Akses Demo

Gunakan akun berikut untuk masuk ke dashboard admin:

| Role             | Username | Password      |
| ---------------- | -------- | ------------- |
| 👑 Administrator | `admin`  | `kemuning123` |

> ⚠️ **Catatan:**
> Data login bersifat **hardcoded** di dalam file `login.php`.
> Silakan edit file tersebut untuk mengubah username atau password.

---

## ❓ Troubleshooting

Jika mengalami kendala, cek solusi berikut:

<details>
<summary>🚨 File malah ter-download, tidak terbuka?</summary>

Itu artinya PHP belum dijalankan oleh server.

Pastikan membuka file melalui URL:

```text
http://localhost/
```

❌ Jangan klik kanan file → **Open with Browser**

</details>

---

<details>
<summary>🚫 Error 404 "Object not found"?</summary>

Periksa kembali:

* Nama folder di dalam `htdocs`
* URL di browser harus **persis sama** dengan nama folder

Contoh:

```text
htdocs/kemuning-admin
http://localhost/kemuning-admin
```

</details>

---

<details>
<summary>🔄 Terus kembali ke halaman login?</summary>

Pastikan:

* Session PHP aktif
* Username & password benar
* Caps Lock tidak menyala
* Logika `$_SESSION` tidak error

</details>

---

<div align="center">
  <sub>Dibuat dengan ❤️ untuk materi edukasi <b>Kemuning Putih Landscape</b>.</sub>
</div>
```

