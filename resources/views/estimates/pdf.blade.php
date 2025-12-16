<!doctype html>
<html>
<head>
<meta charset="utf-8">

<style>
body {
    font-family: dejavusans;
    font-size: 12px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

td, th {
    border: 1px solid #000;
    padding: 5px;
}

/* HEADINGS */
.title {
    background: #f6c600;
    font-size: 28px;
    font-weight: bold;
    text-align: center;
}

.contact {
    background: #f6c600;
    text-align: center;
    font-weight: bold;
    font-size: 13px;
}

.center {
    text-align: center;
}

.bold {
    font-weight: bold;
}

/* ITEM TABLE */
.items th {
    background: #f6c600;
    font-weight: bold;
    text-align: center;
}

.amount-green {
    background: #c6e9a3;
    font-weight: bold;
    font-size: 16px;
    text-align: center;
}

.total-red {
    background: #f44336;
    color: #fff;
    font-weight: bold;
    font-size: 18px;
    text-align: center;
}

/* NOTES */
.note-black {
    background: #000;
    color: #fff;
    text-align: center;
    font-weight: bold;
}

.note-green {
    background: #9ccc65;
    text-align: center;
    font-weight: bold;
}

.note-gray {
    background: #555;
    color: #fff;
    text-align: center;
    font-weight: bold;
}
</style>
</head>

<body>

<!-- LOGOS -->
<table style="border:none; margin-bottom:5px;">
<tr>
<td style="border:none; text-align:center; width:25%;">
<img src="{{ public_path('assets/images/DIAMOND-IT.png') }}" height="70" width="150">
</td>
<td style="border:none; text-align:center; width:25%;">
<img src="{{ public_path('assets/images/cpplus.png') }}" height="40">
</td>
<td style="border:none; text-align:center; width:25%;">
<img src="{{ public_path('assets/images/dahua.png') }}" height="40">
</td>
<td style="border:none; text-align:center; width:25%;">
<img src="{{ public_path('assets/images/fyber.png') }}" height="40">
</td>
</tr>
</table>

<!-- COMPANY TITLE -->
<table class="mt-4">
<tr>
<td class="title">DIAMOND IT SOLUTIONS</td>
</tr>
</table>

<table>
<tr>
<td class="center bold">
HEAD OFF: OPP LIMRA HOSPITAL THAKURGANJ LKO<br>
BRANCH OFF: LGF 14,15 BEGARIYA ROAD DUBAGGA LKO
</td>
</tr>
<tr>
<td class="contact">
Contact: 7881115813, 7318001531 | Email: solutionsdiamond3@gmail.com
</td>
</tr>
<tr>
<td class="center" style="font-size: 11px;">
GST NO: 09CBFPN6236F1ZJ
</td>
</tr>
</table>

<table>
<tr>
<td class="center bold">CCTV CAMERA WHOLESALER</td>
</tr>
<tr>
<td class="center bold">INVOICE / BILL OF SUPPLY / ESTIMATE</td>
</tr>
</table>

<!-- CLIENT -->
<table>
<tr>
<td width="60%">
<b>Client Name, Number & Address</b><br>
{{ $estimate->client_name }}<br>
{{ $estimate->client_phone }}<br>
{!! nl2br(e($estimate->client_address)) !!}
</td>

<td width="40%">
<b>QT. NO:</b> {{ $estimate->invoice_no }}<br>
<b>DATE:</b> {{ optional($estimate->date)->format('d/m/Y') }}
</td>
</tr>
</table>

<!-- ITEMS -->
<table class="items">
<thead>
<tr>
<th width="40">S.NO</th>
<th>ITEM DESCRIPTION</th>
<th width="60">QTY</th>
<th width="80">RATE</th>
<th width="90">AMOUNT</th>
</tr>
</thead>
<tbody>
@foreach($estimate->items as $item)
<tr>
<td class="center">{{ $item->line }}</td>
<td class="center">{{ $item->description }}</td>
<td class="center">{{ $item->qty }}</td>
<td class="center">{{ number_format($item->rate,0) }}</td>
<td class="center">{{ number_format($item->amount,0) }}</td>
</tr>
@endforeach

@for($i=$estimate->items->count(); $i<15; $i++)
<tr>
<td class="center">{{ $i+1 }}</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td class="center">0</td>
</tr>
@endfor
</tbody>
</table>

<!-- TOTAL -->
<table>
<tr>
<td colspan="3" class="bold center" style="background:#f6c600;">TOTAL</td>
<td class="center bold" style="background:#f6c600;">{{ $estimate->total_qty }}</td>
<td class="amount-green">{{ number_format($estimate->total,0) }}</td>
</tr>
</table>

<table>
<tr>
<td class="bold center" style="background:#f6c600;">TOTAL AMOUNT</td>
<td class="total-red">{{ number_format($estimate->total,0) }}</td>
</tr>
</table>

<!-- NOTES -->
<div class="note-black">IF EXTRA WORK / MATERIAL WILL APPLY EXTRA CHGS.</div>
<div class="note-green">Any Civil and Electrical work will be in customer's scope</div>
<div class="note-gray">THIS PRICE VALID TILL ONLY 7 TO 10 DAYS</div>

</body>
</html>
