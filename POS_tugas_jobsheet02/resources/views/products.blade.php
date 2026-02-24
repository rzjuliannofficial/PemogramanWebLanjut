<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Produk - {{ ucfirst(str_replace('-', ' ', $category)) }}</title>
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
        .category-info {
            background-color: #e8f4f8;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
        a {
            color: #0066cc;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>📦 Halaman Produk</h1>
        <div class="category-info">
            <h2>Kategori: {{ ucfirst(str_replace('-', ' ', $category)) }}</h2>
            <p>Menampilkan produk dari kategori: <strong>{{ $category }}</strong></p>
        </div>
        <p>Berikut adalah daftar produk dalam kategori ini.</p>
        <p><a href="/">&larr; Kembali ke Home</a></p>
    </div>
</body>
</html>
