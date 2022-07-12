<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Member</title>
</head>
<body>
    <section style="border: 1px solid #fff">
        <table width="100%">
            @foreach ($datamember as $key => $data)
                <tr>
                    @foreach ($data as $item)
                        <td class="text-center" with="50%">
                            <img src="{{ asset('/public/images/member.png') }}" alt="Card">
                            <div class="logo">
                                <p>{{ config('app.name') }}</p>
                                <img src="{{ asset('/public/images/logo.png') }}" alt="Logo">
                            </div>
                            <div class="nama">{{ $item->nama }}</div>
                            <div class="telepon">{{ $item->telepon }}</div>
                            <div class="barcode text-left">
                                <img src="data:image/png;base64, {{ DNS2D::getBarcodePNG("$item->kode_member",'QRCODE') }}" alt="qrcode" height="45" width="45">
                            </div>
                        </td>
                    @endforeach
                </tr>
                
            @endforeach
        </table>

    </section>
</body>
</html> 