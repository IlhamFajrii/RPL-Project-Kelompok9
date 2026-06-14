<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Peminjaman</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            text-align: center;
            color: #1e3a8a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #1e3a8a;
            color: white;
        }
        .info {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <h1>LAPORAN PEMINJAMAN ALAT LABORATORIUM</h1>
    <h3 style="text-align: center;">SMKN 2 Palembang</h3>
    
    <div class="info">
        <p><strong>Periode:</strong> {{ ucfirst($periode) }}</p>
        <p><strong>Tanggal:</strong> {{ $tgl_awal }} hingga {{ $tgl_akhir }}</p>
        <p><strong>Tanggal Cetak:</strong> {{ now()->format('d M Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Peminjam</th>
                <th>Email</th>
                <th>Alat</th>
                <th>Tanggal Pinjam</th>
                <th>Rencana Kembali</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($peminjaman as $key => $item)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $item->user->name }}</td>
                <td>{{ $item->user->email }}</td>
                <td>{{ $item->alat->nama_alat }}</td>
                <td>{{ $item->tanggal_pinjam->format('d/m/Y') }}</td>
                <td>{{ $item->tanggal_rencana_kembali->format('d/m/Y') }}</td>
                <td>{{ $item->tanggal_kembali ? $item->tanggal_kembali->format('d/m/Y') : '-' }}</td>
                <td>{{ ucfirst($item->status_approval) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p style="margin-top: 40px; text-align: right;">
        Palembang, {{ now()->format('d M Y') }}<br>
        <br><br>
        ________________<br>
        Laboran
    </p>
</body>
</html>
