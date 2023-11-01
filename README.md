# SISTEM REKAPITULASI DAN MONITORING KELUHAN PENGGUNA JASA PETIKEMAS
Project ini dibangun untuk memenuhi tugas akhir skripsi Ervina Novlianti & Nurul Qalbi Haeruddin, dengan judul "Rekapitulasi dan Monitoring Keluhan Pengguna Jasa Petikemas Pada PT Pelindo, terminal Petikemas New Makassar" dengan menerapkan metode Naive Bayes untuk proses klasifikasi keluhan pengguna jasa petikemas menggunakan Framework Laeavel dan library Python. 
## Tech Stack
- Bahasa Pemrograman: PHP versi 7.4
- Framework Backend: Laravel 8
- Database: MySQL 5.7
- Server: Apache 2.4
- Library Python : NLP, Sastrawi
- Laravel Excel
- DomPDF
## Setup Project
- Step 1: Buka folder yang untuk menyimpan project ini
- Step 2: Buka git bash lalu ketikkan perintah clone project
  ```
  git clone https://github.com/ervinanovlianti/sistem-rekapitulasi-keluhan.git
  ```
- Step 3: Setelah proses clone berhasil, buka project di Code Editor Anda
- Step 4: Setting up project 
    - Install Node Module dengan cara buka terminal lalu ketik perintah berikut dan tunggu hingga selesai
    ```
    npm install
    ```
    - Install file Vendor 
    ```
    composer install
    ```

- Step 5: Setup .env file dengan cara duplikat file .env.example dan rename file menjadi .env
- Step 6: Setup database, pada file .env, input nama database project
- Step 7: Jalankan perintah berikut di terminal
    ```
    npm run dev
    ```
    ```
    php artisan key:generate
    ```
    ```
    php artisan migrate
    ```
- Step 8: Jalankan project
    ```
    php artisan serve
    ```
    Maka akan muncul 
    ```
    Starting Laravel development server: http://127.0.0.1:8000
    ```
    
    Klik dengan menekan tombol alt+klik
    ```
    http://127.0.0.1:8000
    ```
    
    Catatan:
    - ```NaiveBayesController``` memuat logic input data keluhan serta logic perhitungan dengan metode naive bayes
    - ```KeluhanController``` memuat logic untuk menampilkan data keluhan, data pelanggan
