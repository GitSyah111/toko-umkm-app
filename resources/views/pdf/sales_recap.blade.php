<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rekapitulasi Penjualan - {{ $toko->nama_toko }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #2563eb; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 28px; font-weight: bold; color: #2563eb; margin: 0; }
        .title { font-size: 20px; font-weight: bold; margin: 10px 0; text-transform: uppercase; color: #111; }
        .toko-info { font-size: 16px; margin-bottom: 20px; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f8fafc; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row th, .total-row td { background-color: #eff6ff; font-weight: bold; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="logo">TokoKita</h1>
        <div class="title">Laporan Rekapitulasi Penjualan</div>
    </div>

    <div class="toko-info">
        <strong>Toko:</strong> {{ $toko->nama_toko }}<br>
        <strong>Dicetak Pada:</strong> {{ now()->format('d M Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="10%" class="text-center">No</th>
                <th width="30%">Tanggal</th>
                <th width="30%" class="text-center">Total Pesanan</th>
                <th width="30%" class="text-right">Total Pendapatan (Omset)</th>
            </tr>
        </thead>
        <tbody>
            @php $grandTotalPesanan = 0; $grandTotalPendapatan = 0; @endphp
            @foreach($data as $index => $row)
            @php 
                $grandTotalPesanan += $row->total_orders; 
                $grandTotalPendapatan += $row->total_revenue; 
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                <td class="text-center">{{ $row->total_orders }}</td>
                <td class="text-right">Rp {{ number_format($row->total_revenue, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2" class="text-right">TOTAL KESELURUHAN</td>
                <td class="text-center">{{ $grandTotalPesanan }}</td>
                <td class="text-right">Rp {{ number_format($grandTotalPendapatan, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh sistem TokoKita.
    </div>
</body>
</html>
