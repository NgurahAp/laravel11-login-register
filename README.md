# Laravel login register menggunakan breeze

- Link yt : https://youtu.be/G3UeClZPR4k

## Langkah-langkah

1. Menginstall Breeze
  - Menjalankan prompt `composer require laravel/breeze --dev`
  - Setelah itu menginstall dengan prompt  `php artisan breeze:install`
  - Memilih 'Blade with alpine' stack untuk di install
  - Memilih 'PHPUnit' untuk framework testing
  - Terakhit menjalankan perintah `npm install` dan juga `npm run build`

2. Menambah field usertype di file migration
  - Menambahkan code `$table->string('usertype')->default('user');` di migration user
  - Menjalankan prompt `php artisan migrate`

3. Login dan register sudah berfungsi. Anda bisa mengganti secara manual untuk admin dengan mengganti user typenya ke `admin`

4. Membuat HomeController
  - Jalankan prompt untuk membuat controller
  - Menambahkan  `Route::get('admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');` di routes
  - Tambahkan code berikut di AuthenticatedSessionController yang akan digunakan untuk mengarah ke view admin/dashboard.blade.php
    ```
     public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        if ($request->user()->usertype == 'admin') {
            return redirect('admin/dashboard');
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }
    ```
  - Membuat folder admin di view, dan membuat file dashboard untuk admin dengan tampilan `<h1 class="text-3xl font-bold underline">Admin</h1>`

5. Membuat agar user admin mengarah ke view admin yg sudah dibuat
  - Membuka file Home Controller
  - Menambahkan code dibawah di function store untuk mengarahkan tampilan ke admin
    ```
    if ($request->user()->usertype == 'admin') {
        return redirect('admin/dashboard');
    }
    ```
  - Code sudah berfungsi dan login akan mengarahkan ke tampilan yang sesuai.
  - Masalahnya user bisa mengakses halaman admin dengan hanya mengganti routesnya

6. Menambahkan middleware agar link tidak dapat diakses sembarangan
  - Menjalankan prompt `php artisan make:middleware Admin`
  - Membuka file `app\Http\Middleware\Admin.php`
  - Menambah code berikut di function handle agar bisa mengembalikan user ke halaman dashboard user
    ```
    if(Auth::user()->usertype != 'admin'){
            return redirect('dashboard')->with('error', 'You are not allowed to access this page');
        }
    ```

7. Membuat middleware agar bisa diakses
  - Membuka file `bootstrap\app.php`
  - Menambah code di method withMiddleWare
    ```
    $middleware->alias([
            'admin' => \App\Http\Middleware\Admin::class,
        ]);
    ```
  - Mengubah route admin menjadi seperti dibawah
    ```
    Route::get('admin/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.dashboard');
    ```


  



