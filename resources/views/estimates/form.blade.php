@extends('admin.layouts.app')

@section('title', $estimate->exists ? 'Edit Estimate' : 'Create Estimate')

{{-- @push('styles') --}}
{{-- <style>
        /* General polish */
        label {
            font-weight: 500;
            margin-bottom: 4px;
        }

        .card {
            border-radius: 10px;
            border: 1px solid #e5e7eb;
        }

        .card-header {
            background: #f8fafc;
            font-weight: 600;
        }

        /* Item table */
        .item-table th,
        .item-table td {
            vertical-align: middle;
        }

        .qty {
            width: 70px;
        }

        /* Mobile responsive table */
        @media (max-width: 768px) {
            .item-table thead {
                display: none;
            }

            .item-table,
            .item-table tbody,
            .item-table tr,
            .item-table td {
                display: block;
                width: 100%;
            }

            .item-table tr {
                background: #fff;
                border: 1px solid #e5e7eb;
                border-radius: 10px;
                padding: 12px;
                margin-bottom: 12px;
            }

            .item-table td {
                border: none;
                padding: 6px 0;
            }

            .item-table td::before {
                content: attr(data-label);
                font-weight: 600;
                display: block;
                font-size: 12px;
                color: #6b7280;
                margin-bottom: 2px;
            }

            .item-table .no-print {
                text-align: right;
                margin-top: 8px;
            }
        }
    </style> --}}
<style>
    /* ---------- Desktop ---------- */
    .item-table input {
        font-size: 14px;
    }

    .qty {
        width: 70px;
    }

    /* ---------- Mobile Billing Layout ---------- */
    @media (max-width: 420px) {

        .item-table thead {
            display: none;
        }

        .item-table,
        .item-table tbody,
        .item-table tr {
            display: block;
            width: 100%;
        }

        .item-table tr {
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px;
            margin-bottom: 6px;
            background: #fff;
        }

        .item-table td {
            display: flex;
            flex-direction: column;
            border: none;
            padding: 6px 0;
            width: 100%;
        }

        .item-table td::before {
            content: attr(data-label);
            font-size: 12px;
            font-weight: 600;
            color: #6b7280;
            margin-bottom: 2px;
        }

        /* Description full width */
        .item-table td[data-label="Description"] input {
            width: 100%;
        }

        /* Qty + Rate side by side */
        .item-table td[data-label="Qty"],
        .item-table td[data-label="Rate"] {
            width: 48%;
            display: inline-flex;
        }

        .item-table td[data-label="Qty"] {
            float: left;
        }

        .item-table td[data-label="Rate"] {
            float: right;
        }

        /* Clear floats */
        .item-table td[data-label="Rate"]::after {
            content: "";
            display: block;
            clear: both;
        }

        /* Amount emphasized */
        .item-table td[data-label="Amount"] input {
            font-weight: 700;
            font-size: 16px;
            background: #f9fafb;
            border: 1px dashed #d1d5db;
        }

        /* Remove button full width */
        .item-table td[data-label="Action"] {
            margin-top: 4px;
        }

        .item-table td[data-label="Action"] button {
            width: 100%;
        }

        /* Line number subtle */
        .line-no {
            font-weight: 600;
            color: #6b7280;
        }
    }
</style>

{{-- @endpush --}}


@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container mb-4">
                    <div class="mb-3">
                        <a href="{{ route('estimates.index') }}" class="btn btn-secondary">Back to list</a>
                    </div>

                    @php
                        $action = $estimate->exists ? route('estimates.update', $estimate) : route('estimates.store');
                    @endphp

                    <form action="{{ $action }}" method="POST">
                        @csrf
                        @if ($estimate->exists)
                            @method('PUT')
                        @endif

                        <div class="card mb-4">
                            <div class="card-header">Estimate Details</div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-3 col-6">
                                        <label>Invoice No</label>
                                        <input type="text" name="invoice_no" class="form-control"
                                            value="{{ old('invoice_no', $estimate->invoice_no) }}">
                                    </div>

                                    <div class="col-md-3 col-6">
                                        <label>Date</label>
                                        <input type="date" name="date" class="form-control"
                                            value="{{ old('date', $estimate->date ? $estimate->date->format('Y-m-d') : now()->format('Y-m-d')) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Client Name</label>
                                        <input type="text" name="client_name" class="form-control"
                                            value="{{ old('client_name', $estimate->client_name) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Phone</label>
                                        <input type="text" name="client_phone" class="form-control"
                                            value="{{ old('client_phone', $estimate->client_phone) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label>Email</label>
                                        <input type="email" name="email" class="form-control"
                                            value="{{ old('email', $estimate->email) }}">
                                    </div>

                                    <div class="col-12">
                                        <label>Address</label>
                                        <textarea name="client_address" class="form-control" rows="2">{{ old('client_address', $estimate->client_address) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card mb-4">
                            <div class="card-header">Items</div>
                            <div class="card-body">
                                {{-- <h5>Items</h5> --}}
                                <table class="table item-table" id="itemsTable">
                                    <thead>
                                        <tr>
                                            <th style="width:40px">#</th>
                                            <th>Description</th>
                                            <th style="width:80px">Qty</th>
                                            <th style="width:120px">Rate</th>
                                            <th style="width:120px">Amount</th>
                                            <th style="width:80px" class="no-print">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $oldDesc = old(
                                                'item_description',
                                                $items->isNotEmpty() ? $items->pluck('description')->toArray() : [],
                                            );
                                            $oldQty = old(
                                                'item_qty',
                                                $items->isNotEmpty() ? $items->pluck('qty')->toArray() : [],
                                            );
                                            $oldRate = old(
                                                'item_rate',
                                                $items->isNotEmpty() ? $items->pluck('rate')->toArray() : [],
                                            );
                                        @endphp

                                        @if (count($oldDesc) > 0)
                                            @foreach ($oldDesc as $i => $desc)
                                                <tr>
                                                    <td data-label="#" class="line-no">{{ $loop->iteration }}</td>
                                                    <td data-label="Description"><input type="text"
                                                            name="item_description[]" class="form-control"
                                                            value="{{ $desc }}"></td>
                                                    <td data-label="Qty"><input type="number" name="item_qty[]"
                                                            class="form-control qty" value="{{ $oldQty[$i] ?? 0 }}"></td>
                                                    <td data-label="Rate"><input type="number" step="0.01"
                                                            name="item_rate[]" class="form-control rate"
                                                            value="{{ $oldRate[$i] ?? 0 }}"></td>
                                                    <td data-label="Amount"><input type="text" name="item_amount[]"
                                                            class="form-control amount" readonly
                                                            value="{{ ($oldQty[$i] ?? 0) * ($oldRate[$i] ?? 0) }}">
                                                    </td>
                                                    <td data-label="Action" class="no-print"><button type="button"
                                                            class="btn btn-sm btn-danger remove-row">Remove</button></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            @for ($i = 0; $i < 5; $i++)
                                                <tr>
                                                    <td data-label="#" class="line-no">{{ $i + 1 }}</td>
                                                    <td data-label="Description"><input type="text"
                                                            name="item_description[]" class="form-control"></td>
                                                    <td data-label="Qty"><input type="number" name="item_qty[]"
                                                            class="form-control qty" value=" "></td>
                                                    <td data-label="Rate"><input type="number" step="0.01"
                                                            name="item_rate[]" class="form-control rate" value=" ">
                                                    </td>
                                                    <td data-label="Amount"><input type="text" name="item_amount[]"
                                                            class="form-control amount" readonly value="0.00"></td>
                                                    <td data-label="Action" class="no-print"><button type="button"
                                                            class="btn btn-sm btn-danger remove-row">Remove</button></td>
                                                </tr>
                                            @endfor
                                        @endif
                                    </tbody>
                                </table>

                                <div class="mb-3">
                                    <button type="button" id="addRow" class="btn btn-sm btn-success no-print">Add
                                        item</button>
                                </div>
                            </div>
                        </div>


                        {{-- <div class="row">
                            <div class="col-md-6">
                                <label>Notes</label>
                                <textarea name="notes" class="form-control">{{ old('notes', $estimate->notes) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label>Subtotal</label>
                                <input type="text" id="subTotal" class="form-control" readonly
                                    value="{{ number_format($estimate->sub_total ?? 0, 2) }}">
                                <label class="mt-2">Total</label>
                                <input type="text" id="total" name="total" class="form-control" readonly
                                    value="{{ number_format($estimate->total ?? 0, 2) }}">
                            </div>
                        </div> --}}
                        <div class="card mb-4">
                            <div class="card-header">Summary</div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label>Notes</label>
                                        <textarea name="notes" class="form-control" rows="4">{{ old('notes', $estimate->notes) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <label>Subtotal</label>
                                        <input type="text" id="subTotal" class="form-control mb-2" readonly>

                                        <label>Total</label>
                                        <input type="text" id="total" name="total" class="form-control fw-bold"
                                            readonly>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="mt-3">
                            <button class="btn btn-primary">Save Estimate</button>
                            <a href="{{ route('estimates.index') }}" class="btn btn-secondary">Cancel</a>
                        </div> --}}
                        <div class="d-flex flex-wrap gap-2">
                            <button class="btn btn-primary px-4">Save Estimate</button>
                            <a href="{{ route('estimates.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    @endsection

    {{-- @push('scripts') --}}
    @stack('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                function recomputeRow(row) {
                    const qty = Number(row.querySelector('.qty').value) || 0;
                    const rate = Number(row.querySelector('.rate').value) || 0;
                    row.querySelector('.amount').value = (qty * rate).toFixed(2);
                }

                function recomputeAll() {
                    let subtotal = 0;
                    document.querySelectorAll('#itemsTable tbody tr').forEach(function(row) {
                        recomputeRow(row);
                        subtotal += Number(row.querySelector('.amount').value) || 0;
                    });
                    document.getElementById('subTotal').value = subtotal.toFixed(2);
                    document.getElementById('total').value = subtotal.toFixed(2);
                }

                document.getElementById('itemsTable').addEventListener('input', function(e) {
                    if (e.target.classList.contains('qty') || e.target.classList.contains('rate')) {
                        recomputeAll();
                    }
                });

                document.getElementById('addRow').addEventListener('click', function() {
                    const tbody = document.querySelector('#itemsTable tbody');
                    const index = tbody.querySelectorAll('tr').length + 1;
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
      <td class="line-no">${index}</td>
      <td><input type="text" name="item_description[]" class="form-control"></td>
      <td><input type="number" name="item_qty[]" class="form-control qty" value="0"></td>
      <td><input type="number" step="0.01" name="item_rate[]" class="form-control rate" value="0"></td>
      <td><input type="text" name="item_amount[]" class="form-control amount" readonly value="0.00"></td>
      <td class="no-print"><button type="button" class="btn btn-sm btn-danger remove-row">Remove</button></td>
    `;
                    tbody.appendChild(tr);
                });

                document.getElementById('itemsTable').addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-row')) {
                        const tr = e.target.closest('tr');
                        tr.remove();
                        // renumber
                        document.querySelectorAll('#itemsTable tbody tr .line-no').forEach((el, idx) => el
                            .textContent = idx + 1);
                        recomputeAll();
                    }
                });

                recomputeAll();
            });
        </script>
        {{-- @endpush --}}
    @endstack
</div>
</div>
</div>
