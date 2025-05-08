<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Bukti Transaksi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #ffffff;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 500px;
            margin: auto;
            padding: 30px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
        }
        h2 {
            text-align: center;
            color: #4CAF50;
            margin-bottom: 30px;
        }
        .info {
            margin-bottom: 20px;
        }
        .info p {
            margin: 8px 0;
            font-size: 14px;
        }
        .info strong {
            color: #555;
        }
        .highlight {
            background-color: #f0fdf4;
            padding: 10px;
            border-left: 4px solid #4CAF50;
            border-radius: 5px;
            font-size: 14px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            color: #999;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Bukti Transaksi Berhasil</h2>
        <div class="info">
            <p><strong>Nama Pembeli:</strong> {{ $transaksi->user->name }}</p>
            <p><strong>Harga:</strong> Rp {{ number_format($transaksi->harga, 0, ',', '.') }}</p>
            <p><strong>Status:</strong> {{ $transaksi->status }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->created_at)->format('d-m-Y H:i') }}</p>
        </div>

        <div class="highlight">
            Terima kasih telah melakukan transaksi. Simpan bukti ini untuk keperluan pencatatan Anda.
        </div>

        <div class="footer">
            &copy; {{ date('Y') }} ShopeeClone. Semua hak dilindungi.
        </div>
    </div>
</body>
</html>
