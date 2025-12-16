@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container">
                    <h3>Replacement Details</h3>

                    <table class="table table-bordered">
                        <tr>
                            <th>Client</th>
                            <td>{{ $replacement->client_name }}</td>
                        </tr>
                        <tr>
                            <th>Deposited By</th>
                            <td>{{ $replacement->deposited_by }}</td>
                        </tr>
                        <tr>
                            <th>Deposit Date</th>
                            <td>{{ $replacement->deposit_date }}</td>
                        </tr>
                        <tr>
                            <th>Items</th>
                            <td>
                                <ul>
                                    @foreach($replacement->items as $item)
                                        <li>{{ $item['item_name'] }} - Qty: {{ $item['quantity'] }}</li>
                                    @endforeach
                                </ul>
                        </tr>
                        
                        <tr>
                            <th>Replacement Date</th>
                            <td>{{ $replacement->replacement_date ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>{{ $replacement->status }}</td>
                        </tr>
                        <tr>
                            <th>Remarks</th>
                            <td>{{ $replacement->remarks }}</td>
                        </tr>
                    </table>

                    <a href="{{ route('replacements.index') }}" class="btn btn-secondary">Back</a>
                </div>

            </div>
        </div>
    </div>
@endsection
