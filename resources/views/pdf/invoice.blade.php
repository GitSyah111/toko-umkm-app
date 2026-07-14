<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - #{{ $order->id }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #333; margin: 0; padding: 20px; }
        .header { display: table; width: 100%; border-bottom: 2px solid #ddd; padding-bottom: 20px; margin-bottom: 20px; }
        .header-left { display: table-cell; vertical-align: top; width: 50%; }
        .header-right { display: table-cell; vertical-align: top; width: 50%; text-align: right; }
        .logo { font-size: 28px; font-weight: bold; color: #2563eb; margin: 0; }
        .app-name { font-size: 14px; color: #666; margin-top: 5px; }
        .title { font-size: 24px; font-weight: bold; margin-bottom: 5px; text-transform: uppercase; color: #111; }
        .invoice-details { margin-bottom: 30px; display: table; width: 100%; }
        .invoice-details-col { display: table-cell; width: 50%; }
        .invoice-details-col h3 { font-size: 16px; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f8fafc; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row th, .total-row td { border-top: 2px solid #333; font-weight: bold; }
        .footer { text-align: center; font-size: 12px; color: #777; border-top: 1px solid #ddd; padding-top: 15px; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="header-left">
            <h1 class="logo">TokoKita</h1>
            <div class="app-name">Platform UMKM Terpercaya</div>
        </div>
        <div class="header-right">
            <h2 class="title">INVOICE</h2>
            <div><strong>No. Pesanan:</strong> #{{ str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</div>
            <div><strong>Tanggal:</strong> {{ $order->tanggal_order->format('d M Y H:i') }}</div>
            <div><strong>Status:</strong> {{ strtoupper($order->status) }}</div>
        </div>
    </div>

    <div class="invoice-details">
        <div class="invoice-details-col" style="padding-right: 20px;">
            <h3>Diterbitkan Oleh (Penjual)</h3>
            <strong>{{ $order->toko->nama_toko }}</strong><br>
            {{ $order->toko->deskripsi ?? 'Toko UMKM' }}<br>
        </div>
        <div class="invoice-details-col">
            <h3>Untuk (Pembeli)</h3>
            <strong>{{ $order->user->name }}</strong><br>
            {{ $order->user->email }}<br>
            <br>
            <strong>Alamat Pengiriman:</strong><br>
            {{ $order->alamat_pengiriman }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="45%">Nama Produk</th>
                <th width="15%" class="text-center">Kuantitas</th>
                <th width="15%" class="text-right">Harga Satuan</th>
                <th width="20%" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->produk->nama_produk }}</td>
                <td class="text-center">{{ $item->qty }}</td>
                <td class="text-right">Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right"><strong>Total Harga Produk</strong></td>
                <td class="text-right">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="4" class="text-right"><strong>Ongkos Kirim</strong></td>
                <td class="text-right">Rp {{ number_format($order->ongkir, 0, ',', '.') }}</td>
            </tr>
            <tr class="total-row">
                <td colspan="4" class="text-right">TOTAL TAGIHAN</td>
                <td class="text-right">Rp {{ number_format($order->total_bayar, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Terima kasih telah berbelanja di TokoKita.<br>
        Invoice ini sah dan dihasilkan secara otomatis oleh sistem.
    </div>
</body>
</html>
