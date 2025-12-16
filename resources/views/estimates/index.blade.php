@extends('admin.layouts.app')

@section('title', 'Estimates')

@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h2>Estimates</h2>
                        <div>
                            <a href="{{ route('estimates.create') }}" class="btn btn-primary">Create Estimate</a>
                        </div>
                    </div>

                    <table id="myTable" class="table table-striped">
                        <thead>
                            <tr>

                                <th>Invoice</th>
                                <th>Client</th>
                                <th>Date</th>
                                <th>Total</th>
                                <th class="no-print">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($estimates as $est)
                                <tr>

                                    <td>{{ $est->invoice_no }}</td>
                                    <td>{{ $est->client_name }}</td>
                                    <td>{{ optional($est->date)->format('d/m/Y') }}</td>
                                    <td>{{ number_format($est->total, 2) }}</td>
                                    <td class="no-print">
                                        <a href="{{ route('estimates.show', $est) }}" class="btn btn-lg me-1 text-success "><i class="ph-bold ph-eye fs-4 text-success"></i></a>
                                        <a href="{{ route('estimates.edit', $est) }}"
                                            class="btn btn-sm btn-warning me-1">Edit</a>
                                        <a href="{{ route('estimates.pdf', $est) }}"
                                            class="btn btn-sm btn-secondary me-1">PDF</a>
                                        {{-- WhatsApp Button --}}
                                        @if ($est->client_phone)
                                            @php
                                                $phone = preg_replace('/\D/', '', $est->client_phone);
                                                // $message = urlencode(
                                                //     "Hello {$est->client_name}, here is your estimate Invoice Total: {$est->total}",
                                                // );
                                            @endphp
                                            <a href="https://wa.me/{{ $phone }}"
                                                target="_blank" class="btn btn-sm btn-success me-1">
                                                <i class="mdi mdi-whatsapp"></i> WhatsApp
                                            </a>
                                        @endif
                                        <form class="delete-estimate" action="{{ route('estimates.destroy', $est) }}"
                                            method="POST" style="display:inline-block">
                                            @csrf @method('DELETE')
                                            <button class="btn" type="submit">
    <i class="ph ph-trash text-danger fs-2"></i>
</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $estimates->links() }}

                </div>
            </div>
        </div>
    </div>

@endsection
