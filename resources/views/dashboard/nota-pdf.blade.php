<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Nota Pembayaran</title>

    <style>
        * {
            font-family: "Poppins", sans-serif;
        }

        p {
            display: block;
            margin: 3px;
            font-size: 10pt;
        }

        h2 {
            display: block;
            font-size: 18pt;
        }

        table td {
            font-size: 9pt;
        }

        table {
            width: 100%
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        @media print {
            @page {
                margin: 0;
                size: 75mm <?php echo !empty($_COOKIE['innerHeight']) ? $_COOKIE['innerHeight'] . 'mm;' : ''; ?>;
            }

            html,
            body {
                width: 70mm;
            }

            .btn-print {
                display: none;
            }
        }
    </style>
</head>

<body onload="window.print()">
    <div class="container" style="width: 70mm; margin: 0 auto; text-align: center;">
        <div class="header" style="margin-bottom: 5px;">
            <h2>Sentral Konveksi Jember</h2>
            <small>JL. Brigjen Katamso No.67 Kel. Wirolegi, Kec. Sumbersari, Kab. Jember</small>
        </div>
        <p class="text-center">-------------------------------------------------------</p>

        <div style="display: flex; justify-content: space-between;">
            <p>{{ $pesanan->user->name }}</p>
            <p>{{ date('j F Y') }}</p>
        </div>
        <div class="clear-both" style="clear: both;"></div>
        <p class="text-center">-------------------------------------------------------</p>

        <table width="100%" style="border: 0; margin: 0 auto;">
            <tr>
                <td colspan="3" class="text-left">Pesanan</td>
            </tr>
            <tr>
                <td>{{ $pesanan->produk->nama }}</td>
                <td>x {{ $pesanan->qty }}</td>
                <td class="text-right">Rp. {{ number_format($pesanan->produk->harga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-right">-----------------</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td class="text-right">Rp. {{ number_format($pesanan->produk->harga * $pesanan->qty, 0, ',', '.') }}
                </td>
            </tr>
            <tr>
                <td colspan="3" class="text-left">Status Pembayaran</td>
            </tr>
            <tr>
                <td colspan="2">
                    @if ($pesanan->status_pembayaran == 'dp')
                        Dp 50%
                    @else
                        Lunas
                    @endif
                </td>
                <td class="text-right">
                    Total: Rp.
                    @if ($pesanan->status_pembayaran == 'dp')
                        {{ number_format($pesanan->grand_total / 2, 0, ',', '.') }}
                    @else
                        {{ number_format($pesanan->grand_total, 0, ',', '.') }}
                    @endif
                </td>
            </tr>
        </table>
        <p class="text-center">-------------------------------------------------------</p>

        <br>
        <p class="text-center">-- TERIMA KASIH --</p>
        <p class="text-center">Kami sangat menghargai kepercayaan Anda kepada kami. Semoga pesanan Anda memenuhi
            ekspektasi, dan kami harap dapat melayani Anda kembali di masa depan.</p>
    </div>
    <script>
        let body = document.body;
        let html = document.documentElement;
        let height = Math.max(
            body.scrollHeight, body.offsetHeight,
            html.clientHeight, html.scrollHeight, html.offsetHeight
        );

        document.cookie = "innerHeight=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "innerHeight=" + ((height + 50) * 0.264583);
    </script>
</body>

</html>
