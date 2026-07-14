<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Label Pengiriman - #{{ $order->id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #000; margin: 0; padding: 10px; }
        .label-container { width: 100%; max-width: 600px; margin: 0 auto; border: 2px dashed #000; padding: 20px; box-sizing: border-box; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; margin: 0; }
        .courier-info { font-size: 18px; font-weight: bold; margin-top: 10px; }
        .address-block { display: table; width: 100%; margin-bottom: 20px; }
        .address-col { display: table-cell; width: 50%; padding-right: 20px; }
        .address-col h3 { font-size: 16px; border-bottom: 1px solid #000; padding-bottom: 5px; margin-bottom: 10px; text-transform: uppercase; }
        .items-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .items-table th, .items-table td { padding: 8px; border: 1px solid #000; text-align: left; }
        .items-table th { background-color: #eee; }
        .text-center { text-align: center; }
        .barcode-placeholder { height: 60px; border: 1px solid #000; margin-top: 20px; text-align: center; line-height: 60px; font-family: monospace; font-size: 20px; letter-spacing: 5px; }
        .cut-here { text-align: center; margin-top: 30px; font-style: italic; color: #555; }
    </style>
</head>
<body>
    <div class="label-container">
        <div class="header">
            <h1 class="logo">TokoKita</h1>
            <div class="courier-info">LABEL PENGIRIMAN</div>
            <div>No. Pesanan: #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
        </div>

        <div class="address-block">
            <div class="address-col">
                <h3>Penerima</h3>
                <strong>{{ $order->user->name }}</strong><br>
                {{ $order->alamat_pengiriman }}<br>
                <!-- Add phone number if exists, assuming not in user model for now, or you can add if available -->
            </div>
            <div class="address-col">
                <h3>Pengirim</h3>
                <strong>{{ $order->toko->nama_toko }}</strong><br>
                {{ $order->toko->deskripsi ?? 'Toko UMKM' }}<br>
            </div>
        </div>

        <h3>Daftar Barang</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th width="10%" class="text-center">Qty</th>
                    <th width="90%">Nama Produk</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td class="text-center"><strong>{{ $item->qty }}</strong></td>
                    <td>{{ $item->produk->nama_produk }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="barcode-placeholder">
            ||| ||| | || |||| | |||
        </div>
    </div>
    
    <div class="cut-here">
        ----------------------------- Potong di sini -----------------------------
    </div>
</body>
</html>
