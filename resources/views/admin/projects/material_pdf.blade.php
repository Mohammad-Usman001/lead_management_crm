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
    font-size: 26px;
    font-weight: bold;
    text-align: center;
}

.subtitle {
    font-size: 18px;
    font-weight: bold;
    text-align: center;
    margin: 10px 0;
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

/* MATERIAL TABLE */
.items th {
    background: #f6c600;
    font-weight: bold;
    text-align: center;
}

.footer {
    margin-top: 15px;
    font-size: 10px;
    text-align: right;
}
</style>
</head>

<body>

<!-- LOGOS -->
<table style="border:none; margin-bottom:5px;">
<tr>
<td style="border:none; text-align:center; width:50%;">
<img src="{{ public_path('assets/images/DIAMOND-IT.png') }}" height="100" width="260">
</td>
<td style="border:none; text-align:center; width:25%;">
<img src="{{ public_path('assets/images/cpplus.png') }}" height="40">
</td>
</td>
<td style="border:none; text-align:center; width:25%;">
<img src="{{ public_path('assets/images/fyber.png') }}" height="40">
</td>
</tr>
</table>

<!-- COMPANY TITLE -->
<table>
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
<td class="center" style="font-size:11px;">
GST NO: 09CBFPN6236F1ZJ
</td>
</tr>
</table>

<!-- PROJECT NAME -->
<table>
<tr>
<td class="subtitle">
PROJECT MATERIAL HISTORY
</td>
</tr>
<tr>
<td class="center bold" style="font-size:22px;">
{{ strtoupper($project->project_name) }}
</td>
</tr>
</table>

<!-- PROJECT INFO -->
<table>
<tr>
<td width="60%">
<b>Generated Date:</b> {{ now()->format('d/m/Y') }}
</td>
<td width="40%">
<b>Total Entries:</b> {{ $project->materialLogs->count() }}
</td>
</tr>
</table>

<!-- MATERIAL TABLE -->
<table class="items">
<thead>
<tr>
<th width="40">S.NO</th>
<th width="90">DATE</th>
<th>ITEM NAME</th>
<th width="120">TECHNICIAN</th>
<th width="60">QTY</th>
<th width="150">REMARKS</th>
</tr>
</thead>
<tbody>

@forelse($project->materialLogs as $index => $log)
<tr>
<td class="center">{{ $index + 1 }}</td>
<td class="center">
    {{ \Carbon\Carbon::parse($log->entry_date)->format('d/m/Y') }}
</td>
<td class="center">{{ $log->item_name }}</td>
<td class="center">{{ optional($log->technician)->name ?? '' }}</td>
<td class="center">{{ $log->quantity }}</td>
<td>{{ $log->remarks }}</td>
</tr>
@empty
<tr>
<td colspan="6" class="center bold">No material history found</td>
</tr>
@endforelse

</tbody>
</table>

<!-- FOOTER -->
<div class="footer">
Generated on {{ now()->format('d/m/Y') }}
</div>

</body>
</html>
