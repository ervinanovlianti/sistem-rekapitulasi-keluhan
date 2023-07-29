## SETUP PROJECT SISTEM REKAPITULASI DAN MONITORING KELUHAN PENGGUNA JASA

Step 1: Buka folder yang untuk menyimpan project ini
Step 2: Buka git bash lalu ketikkan perintah clone project ```git clone https://github.com/ervinanovlianti/sistem-rekapitulasi-keluhan.git ``` 
Step 3: Setelah proses clone berhasil, buka project di Visual Studio Code
Step 4: Setting up project 
=> Install Node Module dengan cara buka terminal lalu ketik perintah berikut dan tunggu hingga selesai
```npm install```
=> Install file Vendor 
```composer install```

Step 5: Setup .env file dengan cara duplikat file .env.example dan rename file menjadi .env
Step 6: Setup database, pada file .env, input nama database project
```DB_DATABASE =web_rekapitulasi```

Step 7: Jalankan perintah berikut di terminal
```npm run dev```
```php artisan key:generate```
```php artisan migrate```
Step 8: Jalankan project
```php artisan serve```

Maka akan muncul 
```Starting Laravel development server: http://127.0.0.1:8000```
<br>

Klik dengan menekan tombol alt+klik
```http://127.0.0.1:8000```
<br>

Catatan:

```NaiveBayesController``` memuat logic input data keluhan serta logic perhitungan dengan metode naive bayes
```KeluhanController``` memuat logic untuk menampilkan data keluhan, data pelanggan