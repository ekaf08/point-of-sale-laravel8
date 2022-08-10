<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Laporan Pendapatan</title>
    <link rel="stylesheet" href="{{ asset('AdminLTE-2/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

</head>
<body>
    <h3 class="text-center">Laporan Pendapatan</h3>
    <h4 class="text-center">
        Tanggal {{ tanggal_indonesia($awal) }}
        s/d
        Tanggal {{ tanggal_indonesia($akhir) }}
    </h4>

    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center" width="5%">NO</th>
                <th class="text-center" width="26%">TANGGAL</th>
                <th class="text-center">PENJUALAN</th>
                <th class="text-center">PEMBELIAN</th>
                <th class="text-center">PENGELUARAN</th>
                <th class="text-center">PENDAPATAN</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
             <tr>
                @foreach ($row as $col)
                   <td class="text-right">{{ $col }}</td>
                @endforeach
             </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>