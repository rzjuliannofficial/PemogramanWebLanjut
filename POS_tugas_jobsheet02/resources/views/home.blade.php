<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Home</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
        }
        p {
            color: #666;
            line-height: 1.6;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🏠 Halaman Home</h1>
        <p>Selamat datang di halaman utama aplikasi Point of Sales (POS) kami.</p>
        <p>Gunakan menu di bawah untuk navigasi:</p>
        <ul>
            <li><a href="{{ route('product.category', 'food-beverage') }}">Produk Food & Beverage</a></li>
            <li><a href="{{ route('product.category', 'beauty-health') }}">Produk Beauty & Health</a></li>
            <li><a href="{{ route('product.category', 'home-care') }}">Produk Home Care</a></li>
            <li><a href="{{ route('product.category', 'baby-kid') }}">Produk Baby & Kid</a></li>
            <li><a href="{{ route('user.show', ['id' => 000001, 'name' => 'Julian']) }}">Profil User</a></li>
            <li><a href="{{ route('penjualan') }}">Halaman Penjualan</a></li>
        </ul>
    </div>
</body>
</html>
