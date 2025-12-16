@extends('admin.layouts.app')
@section('content')
    <div class="main-content">
        <div class="page-content">
            <div class="container-fluid">
                <div class="container">

                    <h3 class="mb-3">Edit Replacement Entry</h3>

                    <form action="{{ route('replacements.update', $replacement->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label>Client / Party Name</label>
                                <input type="text" name="client_name" class="form-control"
                                    value="{{ old('client_name', $replacement->client_name) }}" required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label>Deposited By</label>
                                <input type="text" name="deposited_by" class="form-control"
                                    value="{{ old('deposited_by', $replacement->deposited_by) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Deposit Date</label>
                                <input type="date" name="deposit_date" class="form-control"
                                    value="{{ old('deposit_date', $replacement->deposit_date) }}" required>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Replacement Date</label>
                                <input type="date" name="replacement_date" class="form-control"
                                    value="{{ old('replacement_date', $replacement->replacement_date) }}">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="Pending" {{ $replacement->status == 'Pending' ? 'selected' : '' }}>
                                        Pending
                                    </option>
                                    <option value="Replaced" {{ $replacement->status == 'Replaced' ? 'selected' : '' }}>
                                        Replaced
                                    </option>
                                </select>
                            </div>
                        </div>

                        <hr>

                        <h5>Replacement Items</h5>

                        <table class="table table-bordered" id="itemsTable">
                            <thead class="table-dark">
                                <tr>
                                    <th width="50">#</th>
                                    <th>Item Name</th>
                                    <th width="120">Quantity</th>
                                    <th width="80">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($replacement->items as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td>
                                            <input type="text" name="items[{{ $index }}][item_name]"
                                                value="{{ $item['item_name'] }}" class="form-control" required>
                                        </td>
                                        <td>
                                            <input type="number" name="items[{{ $index }}][quantity]"
                                                value="{{ $item['quantity'] }}" class="form-control" required>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-danger btn-sm removeRow">
                                                ✖
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <button type="button" class="btn btn-outline-primary mb-3" id="addItem">
                            + Add Item
                        </button>

                        <div class="mb-3">
                            <label>Remarks</label>
                            <textarea name="remarks" class="form-control">{{ old('remarks', $replacement->remarks) }}</textarea>
                        </div>

                        <button class="btn btn-success">Update</button>
                        <a href="{{ route('replacements.index') }}" class="btn btn-secondary">Back</a>

                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- JS --}}
    <script>
        let rowIndex = {{ count($replacement->items) }};

        document.getElementById('addItem').addEventListener('click', function() {
            const tbody = document.querySelector('#itemsTable tbody');

            tbody.insertAdjacentHTML('beforeend', `
        <tr>
            <td class="text-center">${rowIndex + 1}</td>
            <td>
                <input type="text" name="items[${rowIndex}][item_name]" class="form-control" required>
            </td>
            <td>
                <input type="number" name="items[${rowIndex}][quantity]" class="form-control" required>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger btn-sm removeRow">✖</button>
            </td>
        </tr>
    `);

            rowIndex++;
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('removeRow')) {
                e.target.closest('tr').remove();
                reindexRows();
            }
        });

        function reindexRows() {
            rowIndex = 0;
            document.querySelectorAll('#itemsTable tbody tr').forEach((row, index) => {
                row.children[0].innerText = index + 1;
                row.querySelector('[name*="item_name"]').name = `items[${index}][item_name]`;
                row.querySelector('[name*="quantity"]').name = `items[${index}][quantity]`;
                rowIndex++;
            });
        }
    </script>
@endsection
