{{-- @extends('admin.layouts.app')

@section('title', 'Estimate #' . $estimate->invoice_no)

@push('styles')
<style>
  /* A4 portrait at 96dpi ~ 794 x 1123 px */
  .estimate-root {
    width: 794px;
    min-height: 1123px;
    margin: 0 auto;
    background: white; /* ensure white background in export */
    padding: 18px;
    box-sizing: border-box;
  }

  /* Keep responsive behavior in UI but ensure print area uses fixed size */
  @media (max-width: 820px) {
    .estimate-root { width: 100%; min-height: auto; }
  }

  /* other styles unchanged... */
</style>
@endpush


@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">

                <div class="container mb-4">

                    <div class="no-print mb-3">
                        <a href="{{ route('estimates.index') }}" class="btn btn-secondary">Back</a>
                        <a href="{{ route('estimates.edit', $estimate) }}" class="btn btn-warning">Edit</a>
                        <a href="{{ route('estimates.pdf', $estimate) }}" class="btn btn-primary">Download PDF</a>

                        <!-- new -->
                        <button id="downloadImageBtn" class="btn btn-success">Download Image</button>
                    </div>

                    <!-- IMPORTANT: wrap printable area with id="estimateRoot" -->
                    <div id="estimateRoot" class="estimate-root">
                        <!-- Header area with logos (add crossorigin for images) -->
                        <div class="d-flex align-items-center mb-2">
                            <div style="flex:1">
                                <!-- Add crossorigin attribute to help html2canvas load images served with proper CORS -->
                                <img src="{{ asset('assets/images/DIAMOND-IT.png') }}" crossorigin="anonymous" alt="logo" style="max-height:70px;">
                            </div>
                            <div style="flex:2">
                                <div class="big-title">DIAMOND IT SOLUTIONS</div>
                                <div class="company-contact">HEAD OFF: OPP LIMRA HOSPITAL THAKURGANJ LKO &nbsp; | &nbsp;
                                    Contact: 7881115813, 7318001531 | Email: solutionsdiamond3@gmail.com</div>
                            </div>
                            <div style="flex:1; text-align:right;">
                                <img src="{{ asset('images/logo-right.png') }}" crossorigin="anonymous" alt="logo" style="max-height:70px;">
                            </div>
                        </div>

                        <!-- the rest of the estimate content (unchanged) -->
                        <div class="mt-3">
                            <table class="w-100">
                                <tr>
                                    <td style="width:60%;">
                                        <strong>Client:</strong><br>
                                        {{ $estimate->client_name }}<br>
                                        {!! nl2br(e($estimate->client_address)) !!}
                                    </td>
                                    <td style="width:40%; text-align:right;">
                                        <strong>Invoice / Estimate #</strong><br>
                                        {{ $estimate->invoice_no }}<br>
                                        <strong>Date:</strong> {{ optional($estimate->date)->format('d/m/Y') }}
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="mt-3">
                            <table class="w-100 estimate-table" style="border-collapse:collapse;">
                                <thead>
                                    <tr style="background:#f6c600; font-weight:700; text-align:center;">
                                        <th style="width:40px">S.NO.</th>
                                        <th>ITEM DESCRIPTION</th>
                                        <th style="width:90px">QTY</th>
                                        <th style="width:120px">RATE</th>
                                        <th style="width:140px">AMOUNT</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($estimate->items as $item)
                                        <tr>
                                            <td style="text-align:center">{{ $item->line }}</td>
                                            <td>{{ $item->description }}</td>
                                            <td style="text-align:center">{{ $item->qty }}</td>
                                            <td style="text-align:right">{{ number_format($item->rate, 2) }}</td>
                                            <td style="text-align:right">{{ number_format($item->amount, 2) }}</td>
                                        </tr>
                                    @endforeach

                                    @for ($i = $estimate->items->count(); $i < 12; $i++)
                                        <tr>
                                            <td style="text-align:center">{{ $i + 1 }}</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                            <td>&nbsp;</td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md-6">
                                <div class="notes">IF EXTRA WORK / MATERIAL WILL APPLY EXTRA CHGS.<br> Any Civil and Electrical
                                    work will be in customer's scope</div>
                            </div>
                            <div class="col-md-6">
                                <table class="w-100">
                                    <tr>
                                        <td class="text-end" style="font-weight:700">TOTAL</td>
                                        <td style="width:160px" class="amount-cell text-end">
                                            {{ number_format($estimate->sub_total, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td class="text-end" style="font-weight:700">TOTAL AMOUNT</td>
                                        <td style="width:160px" class="final-total text-end">
                                            {{ number_format($estimate->total, 2) }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div class="mt-2 text-center text-muted">
                            THIS PRICE VALID TILL ONLY 7 to 10 DAYS
                        </div>
                    </div> <!-- end #estimateRoot -->

                </div> <!-- container -->
            </div>
        </div>
    </div>

    <!-- html2canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const btn = document.getElementById('downloadImageBtn');

        btn.addEventListener('click', async function () {
            const node = document.getElementById('estimateRoot');
            if (!node) {
                console.error('estimateRoot element not found');
                alert('Printable area not found on page.');
                return;
            }

            try {
                // temporarily show scale overlay to improve resolution (optional)
                const scale = 2; // increase for higher DPI (2 or 3)
                const opts = {
                    scale: scale,
                    useCORS: true,
                    allowTaint: false,
                    logging: false,
                    windowWidth: node.scrollWidth,
                    windowHeight: node.scrollHeight
                };

                // ensure images with crossorigin are already loaded
                const imgs = node.querySelectorAll('img[crossorigin]');
                await Promise.all(Array.from(imgs).map(img => {
                    if (img.complete) return Promise.resolve();
                    return new Promise(resolve => img.addEventListener('load', resolve));
                }));

                const canvas = await html2canvas(node, opts);
                canvas.toBlob(function (blob) {
                    if (!blob) {
                        console.error('Failed to create blob from canvas');
                        alert('Failed to create image. See console for details.');
                        return;
                    }
                    const link = document.createElement('a');
                    link.download = 'estimate-{{ $estimate->invoice_no ?? $estimate->id }}.png';
                    link.href = URL.createObjectURL(blob);
                    document.body.appendChild(link);
                    link.click();
                    link.remove();
                    URL.revokeObjectURL(link.href);
                }, 'image/png', 1);
            } catch (err) {
                console.error('html2canvas error', err);
                alert('Failed to create image. Check console for details.');
            }
        });
    });
    </script>

@endsection --}}
@extends('admin.layouts.app')

@section('title', 'Estimate #' . $estimate->invoice_no)
@section('content')
    <style>
        body {
            font-family: dejavusans;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        td,
        th {
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

        /* A4 portrait at 96dpi ~ 794 x 1123 px */
        .estimate-root {
            width: 794px;
            min-height: 1123px;
            margin: 0 auto;
            background: white;
            /* ensure white background in export */
            padding: 18px;
            box-sizing: border-box;
        }

        /* Keep responsive behavior in UI but ensure print area uses fixed size */
        @media (max-width: 820px) {
            .estimate-root {
                width: 100%;
                min-height: auto;
            }
        }
    </style>

    <body>
        <div class="main-content">
            <div class="page-content">
                <div class="container-fluid">

                    <div class="container mb-4">
                        <div class="no-print mb-3">
                            <a href="{{ route('estimates.index') }}" class="btn btn-secondary">Back</a>
                            <a href="{{ route('estimates.edit', $estimate) }}" class="btn btn-warning">Edit</a>
                            <a href="{{ route('estimates.pdf', $estimate) }}" class="btn btn-primary">Download PDF</a>

                            <!-- new -->
                            <button id="downloadImageBtn" class="btn btn-success">Download Image</button>
                        </div>
                        <!-- LOGOS --><!-- IMPORTANT: wrap printable area with id="estimateRoot" -->
                        <div id="estimateRoot" class="estimate-root">
                            <table style="border:none; margin-bottom:5px;">
                                <tr>
                                    <td style="border:none; text-align:center; width:25%;">
                                        <img src="{{ asset('assets/images/DIAMOND-IT.png') }}" height="70"
                                            width="150">
                                    </td>
                                    <td style="border:none; text-align:center; width:15%;">
                                        <img src="{{ asset('assets/images/cpplus.png') }}" height="40">
                                    </td>
                                    {{-- <td style="border:none; text-align:center; width:10%;">
                                        <img src="{{ asset('assets/images/dahua.png') }}" height="40">
                                    </td>
                                    <td style="border:none; text-align:center; width:5%;">
                                        <img src="{{ asset('assets/images/fyber.png') }}" height="40"> 
                                    </td>--}}
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
                                    @foreach ($estimate->items as $item)
                                        <tr>
                                            <td class="center">{{ $item->line }}</td>
                                            <td class="center">{{ $item->description }}</td>
                                            <td class="center">{{ $item->qty }}</td>
                                            <td class="center">{{ number_format($item->rate, 0) }}</td>
                                            <td class="center">{{ number_format($item->amount, 0) }}</td>
                                        </tr>
                                    @endforeach

                                    @for ($i = $estimate->items->count(); $i < 15; $i++)
                                        <tr>
                                            <td class="center">{{ $i + 1 }}</td>
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
                                    <td class="amount-green">{{ number_format($estimate->total, 0) }}</td>
                                </tr>
                            </table>

                            <table>
                                <tr>
                                    <td class="bold center" style="background:#f6c600;">TOTAL AMOUNT</td>
                                    <td class="total-red">{{ number_format($estimate->total, 0) }}</td>
                                </tr>
                            </table>

                            <!-- NOTES -->
                            <div class="note-black">IF EXTRA WORK / MATERIAL WILL APPLY EXTRA CHGS.</div>
                            <div class="note-green">Any Civil and Electrical work will be in customer's scope</div>
                            <div class="note-gray">THIS PRICE VALID TILL ONLY 7 TO 10 DAYS</div>
                        </div> <!-- end #estimateRoot -->
                    </div> <!-- container -->
                </div>
            </div>
        </div>


    </body>
@endsection
<!-- html2canvas -->
@stack('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btn = document.getElementById('downloadImageBtn');

            btn.addEventListener('click', async function() {
                const node = document.getElementById('estimateRoot');
                if (!node) {
                    console.error('estimateRoot element not found');
                    alert('Printable area not found on page.');
                    return;
                }

                try {
                    // temporarily show scale overlay to improve resolution (optional)
                    const scale = 2; // increase for higher DPI (2 or 3)
                    const opts = {
                        scale: scale,
                        useCORS: true,
                        allowTaint: false,
                        logging: false,
                        windowWidth: node.scrollWidth,
                        windowHeight: node.scrollHeight
                    };

                    // ensure images with crossorigin are already loaded
                    const imgs = node.querySelectorAll('img[crossorigin]');
                    await Promise.all(Array.from(imgs).map(img => {
                        if (img.complete) return Promise.resolve();
                        return new Promise(resolve => img.addEventListener('load',
                            resolve));
                    }));

                    const canvas = await html2canvas(node, opts);
                    canvas.toBlob(function(blob) {
                        if (!blob) {
                            console.error('Failed to create blob from canvas');
                            alert('Failed to create image. See console for details.');
                            return;
                        }
                        const link = document.createElement('a');
                        link.download =
                            'estimate-{{ $estimate->invoice_no ?? $estimate->id }}.png';
                        link.href = URL.createObjectURL(blob);
                        document.body.appendChild(link);
                        link.click();
                        link.remove();
                        URL.revokeObjectURL(link.href);
                    }, 'image/png', 1);
                } catch (err) {
                    console.error('html2canvas error', err);
                    alert('Failed to create image. Check console for details.');
                }
            });
        });
    </script>
@endstack
