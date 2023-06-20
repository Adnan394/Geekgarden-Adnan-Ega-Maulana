# Instalasi 
- Clone repositori ini dan pasang di lokal
- lakukan composer update dan buat file .env
- setting database mySQL dan ketik php artisan key:generate
- lakukan php artisan migrate:fresh --seed
- lakukan php artisan serve
# Penjelasan penggunaan
Authorization : Bearer [token]

Headers : ContentType : application/json

### Alur
- login sebagai admin terlebih dahulu Email : adnanega82@gmail.com, Password : adnan394
- mulai dengan melakukan CRUD produk dengan token yang dikirim saat login
- test CRUD ke keranjang dan transaksi (melakukan error handling hak akses)
- register akun user dan login
- lakukan CRUD keranjang
- lakukan CRUD transaksi
- coba lakukan CRUD produk (melakukan error handling hak akses)
- logout
# End Point API
Domain Lokal : 7.0.0.1:8000/api

Role Admin : 
- melakukan CRUD Produk, READ Keranjang, READ Transaksi
  
Role User : 
- melakukan READ produk, CRUD keranjang, CRUD transaksi

### Setup
> **[POST] /signup** : melakukan pendaftaran akun (default user)
> 
> **[POST] /login** : melakukan login akun
> 
> **[POST] /logout** : keluar akun
### Produk
> **[GET] /keranjang** : menampilkan list produk
> 
> **[GET] /produk/{id}** : menampilkan produk spesifik
> 
> **[POST] /produk** : menambahkan produk
> 
> **[PUT] /produk/{id}** : mengedit produk
> 
> **[DELETE] /produk/{id}** : menghapus produk
### Keranjang
> **[GET] /keranjang** : menampilkan list keranjang
> 
> **[GET] /keranjang/{id}** : menampilkan keranjang spesifik
> 
> **[POST] /keranjang** : menambahkan keranjang
> 
> **[PUT] /keranjang/{id}** : mengedit keranjang
> 
> **[DELETE] /keranjang/{id}** : menghapus keranjang
### Transaksi
> **[GET] /transaksi** : menampilkan list transaksi
> 
> **[GET] /transaksi/{id}** : menampilkan transaksi spesifik
> 
> **[POST] /transaksi** : menambahkan transaksi
> 
> **[PUT] /transaksi/{id}** : mengedit transaksi
> 
> **[DELETE] /transaksi/{id}** : menghapus transaksi
