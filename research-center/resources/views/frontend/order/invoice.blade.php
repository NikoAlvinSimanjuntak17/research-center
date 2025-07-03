<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->id }}</title>
    <style>
        body {
            font-family: sans-serif;
            margin: 0;
            padding-bottom: 100px; /* Space for fixed footer */
        }
        .title {
            text-align: center;
            margin-top: 20px;
        }
  .header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .header .column {
        width: 48%;
    }

    .header .column p {
        margin: 4px 0;
        line-height: 1.4;
    }

    .right-column {
        text-align: right;
    }

        table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            height: 80px;
            text-align: center;
            padding-top: 20px;

        }
        footer p{
            font-size: 13px;
        }
    </style>
</head>
<body>

    <div class="title">
    <h2>Thanks For Using Our Apps</h2>
    <p><strong>Invoice #{{ $order->id }}</strong></p>
    </div>

<table style="width: 100%; margin-bottom: 20px; border: none;">
    <tr>
        <td style="width: 50%; vertical-align: top; border: none;">
            <p><strong>{{ $order->nama }}</strong> </p>
            <p>{{ $order->shipping_phonenumber }}</p>
            <p>{{ $order->created_at->format('d M Y') }}</p>
        </td>
        <td style="width: 50%; text-align: right; vertical-align: top; border: none;">
            <br>
            <p> {{ $order->address }}</p>
            <p> {{ $order->shipping_city }}</p>

        </td>
    </tr>
</table>



    <table>
        <thead>
            <tr>
                <th>Type</th>
                <th>Item Name</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($itemNames as $index => $itemName)
                <tr>
                    <td>
                        @php
                            $type = json_decode($order->item_type)[$index];
                        @endphp
                        {{ $type === 'research_data' ? 'Dataset' : ($type === 'event' ? 'Ticket' : 'Item') }}
                    </td>
                    <td>{{ $itemName }}</td>
                    <td>Rp {{ number_format(json_decode($order->totalprice)[$index]) }}</td>
                </tr>
            @endforeach

            @if ($order->coupon)
                <tr>
                    <td colspan="2"><strong>Diskon ({{ $order->coupon->code }})</strong></td>
                    <td>-Rp {{ number_format($order->coupon->type === 'percent' ? array_sum(json_decode($order->totalprice)) * $order->coupon->value / 100 : $order->coupon->value) }}</td>
                </tr>
            @endif

            <tr>
                <td colspan="2"><strong>Total</strong></td>
                <td>
                    Rp {{ number_format(max(array_sum(json_decode($order->totalprice)) - ($order->coupon ? ($order->coupon->type === 'percent' ? array_sum(json_decode($order->totalprice)) * $order->coupon->value / 100 : $order->coupon->value) : 0), 0)) }}
                </td>
            </tr>
        </tbody>
    </table>

    <footer>
       <h3>Taman Sains Teknologi Herbal dan Hortikultura</h3>
       <p>Pollung, Kabupaten Humbang Hasundutan, Sumatera Utara</p>
    </footer>

</body>
</html>
