<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Laporan Laba Bersih - {{ $toko->nama_toko }}</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; font-size: 14px; color: #333; margin: 0; padding: 20px; }
        .header { text-align: center; border-bottom: 2px solid #16a34a; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 28px; font-weight: bold; color: #16a34a; margin: 0; }
        .title { font-size: 20px; font-weight: bold; margin: 10px 0; text-transform: uppercase; color: #111; }
        .toko-info { font-size: 16px; margin-bottom: 20px; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background-color: #f8fafc; font-weight: bold; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .total-row th, .total-row td { background-color: #dcfce7; font-weight: bold; }
        .text-green { color: #16a34a; }
        .text-red { color: #dc2626; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 40px; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="logo">TokoKita</h1>
        <div class="title">Laporan Laba Bersih (Margin)</div>
    </div>

    <div class="toko-info">
        <strong>Toko:</strong> {{ $toko->nama_toko }}<br>
        <strong>Dicetak Pada:</strong> {{ now()->format('d M Y H:i') }}
    </div>

    <table>
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="20%">Tanggal</th>
                <th width="25%" class="text-right">Total Pendapatan</th>
                <th width="25%" class="text-right">Total Modal (HPP)</th>
                <th width="25%" class="text-right">Laba Bersih</th>
            </tr>
        </thead>
        <tbody>
            @php 
                $grandTotalPendapatan = 0; 
                $grandTotalHPP = 0; 
                $grandTotalLaba = 0; 
            @endphp
            @foreach($data as $index => $row)
            @php 
                $grandTotalPendapatan += $row->total_revenue; 
                $grandTotalHPP += $row->total_hpp; 
                $laba = $row->total_revenue - $row->total_hpp;
                $grandTotalLaba += $laba;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ \Carbon\Carbon::parse($row->tanggal)->format('d M Y') }}</td>
                <td class="text-right">Rp {{ number_format($row->total_revenue, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($row->total_hpp, 0, ',', '.') }}</td>
                <td class="text-right {{ $laba >= 0 ? 'text-green' : 'text-red' }}">
                    Rp {{ number_format($laba, 0, ',', '.') }}
                </td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="2" class="text-right">TOTAL KESELURUHAN</td>
                <td class="text-right">Rp {{ number_format($grandTotalPendapatan, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($grandTotalHPP, 0, ',', '.') }}</td>
                <td class="text-right {{ $grandTotalLaba >= 0 ? 'text-green' : 'text-red' }}">
                    Rp {{ number_format($grandTotalLaba, 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dokumen ini dihasilkan secara otomatis oleh sistem TokoKita.
    </div>
</body>
</html>
