# Sistem Manajemen Database Bantuan (MBG)

Project ini dibuat untuk memenuhi tugas praktikum pengembangan aplikasi berbasis web.
Project ini terdiri dari 6 modul data dengan hubungan antar tabel sesuai ERD.

## 📌 Daftar Modul
| Modul | Folder | Penanggung Jawab |
|-------|--------|------------------|
| User | /user | Anggota 1 |
| Penerima | /penerima | Anggota 2 |
| Mitra | /mitra | Anggota 2 |
| Paket Bantuan | /paketbantuan | Anggota 3 |
| Distribusi | /distribusi | Anggota 3 |
| Laporan Data | /laporandata | Anggota 4 |
| Dashboard | /dashboard | Anggota 4 |

> Semua anggota _hanya mengerjakan_ folder modul masing-masing.

---

## 💾 1. Cara Menjalankan Project (XAMPP)

1. Pastikan XAMPP terinstal
2. Start **Apache** dan **MySQL**
3. Clone project ini ke htdocs: C:\xampp\htdocs\project-mbg-database (jangan lupa keluarin dari MBG-databse-project biar kebaca ama apache di XAMPP)
4. Akses project di browser: http://localhost/project-mbg-database/


---

## 🗄 2. Import Database (Wajib dilakukan semua anggota)

1. Buka phpMyAdmin
2. Buat database: db_mbg
3. Klik **Import**
4. Upload file **db_mbg.sql** atau jalankan perintah SQL dari repository.

Jika berhasil akan muncul tabel: USER, PENERIMA, MITRA, PAKETBANTUAN, DISTRIBUSI, LAPORANDATA


---

## 🌐 3. Struktur Folder Utama

1. index.php → halaman menu utama
2. config/koneksi.php → koneksi database
3. public/ → css & js (Bootstrap)
4. user/ → modul User
5. penerima/ → modul Penerima
6. mitra/ → modul Mitra
7. paketbantuan/ → modul Paket Bantuan
8. distribusi/ → modul Distribusi
9. laporandata/ → modul Laporan Data
10. dashboard/ → modul Dashboard

---

## 🧠 4. Aturan GitHub (WAJIB)

### 🔥 Dilarang keras:
❌ Commit ke branch `main`  
❌ Push tanpa melakukan `git pull`  
❌ Mengutak-atik folder modul milik orang lain  

### ✔ Wajib:
1. **Pull dulu sebelum bekerja**
2. **Kerja di branch masing-masing**
3. **Push ke branch masing-masing**
4. **Pull Request kalau mau merge ke `main`**

---

## 🔀 5. Daftar Branch Per Anggota

| Branch | Untuk |
|--------|--------|
| dev-user | Anggota 1 |
| dev-penerima | Anggota 2 |
| dev-mitra | Anggota 2 |
| dev-paketbantuan | Anggota 3 |
| dev-distribusi | Anggota 3 |
| dev-laporandata | Anggota 4 |
| dev-dashboard | Anggota 4 |

---

## 🧩 6. Alur Kerja Git (Langkah Demi Langkah)

### 📌 Saat mau mulai coding

git pull
git checkout <nama-branchmu>

### 📌 Setelah selesai coding

git add .
git commit -m "progress hari ini"
git push


### 📌 Setelah modul selesai dan siap digabung ke main
- Buat **Pull Request di GitHub**
- Minta anggota lain untuk review
- Setelah disetujui → merge ke `main`

---

## 🔧 7. Tips agar tidak konflik saat merge
- Jangan edit file milik modul orang lain
- Jangan rename folder
- Jangan ubah file `index.php` tanpa koordinasi tim
- Kalau menambah link baru → koordinasikan dulu

---

## 🎯 Goal akhir project
- Semua modul CRUD berjalan
- Data antar tabel saling terhubung melalui foreign key
- Dashboard menampilkan ringkasan data distribusi & paket bantuan
- Tampilan Bootstrap rapi dan konsisten di seluruh halaman

---

## 👨‍💻 Kontributor
- Anggota 1: zagho_kun
- Anggota 2: fiko
- Anggota 3: zerafica
- Anggota 4: farhan

---

Project ini akan terus dikembangkan hingga semua modul CRUD selesai dan siap untuk presentasi.
