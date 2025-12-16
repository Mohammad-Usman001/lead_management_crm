@php
$items = old('items', $replacement->items ?? [['item_name'=>'','quantity'=>'']]);
@endphp

<div class="row">
    <div class="col-md-6 mb-3">
        <label>Client Name</label>
        <input type="text" name="client_name" class="form-control"
               value="{{ old('client_name', $replacement->client_name ?? '') }}" required>
    </div>

    <div class="col-md-6 mb-3">
        <label>Deposited By</label>
        <input type="text" name="deposited_by" class="form-control"
               value="{{ old('deposited_by', $replacement->deposited_by ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Deposit Date</label>
        <input type="date" name="deposit_date" class="form-control"
               value="{{ old('deposit_date', $replacement->deposit_date ?? '') }}" required>
    </div>

    <div class="col-md-4 mb-3">
        <label>Replacement Date</label>
        <input type="date" name="replacement_date" class="form-control"
               value="{{ old('replacement_date', $replacement->replacement_date ?? '') }}">
    </div>

    <div class="col-md-4 mb-3">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="Pending" {{ (old('status',$replacement->status ?? '')=='Pending')?'selected':'' }}>Pending</option>
            <option value="Replaced" {{ (old('status',$replacement->status ?? '')=='Replaced')?'selected':'' }}>Replaced</option>
        </select>
    </div>
</div>

<hr>

<h5>Items</h5>

<table class="table table-bordered" id="itemsTable">
<thead class="table-dark">
<tr>
    <th>#</th>
    <th>Item Name</th>
    <th width="120">Qty</th>
    <th width="80">Action</th>
</tr>
</thead>
<tbody>
@foreach($items as $i => $item)
<tr>
    <td>{{ $i+1 }}</td>
    <td><input type="text" name="items[{{ $i }}][item_name]" class="form-control" value="{{ $item['item_name'] }}" required></td>
    <td><input type="number" name="items[{{ $i }}][quantity]" class="form-control" value="{{ $item['quantity'] }}" required></td>
    <td class="text-center">
        <button type="button" class="btn btn-danger btn-sm removeRow">✖</button>
    </td>
</tr>
@endforeach
</tbody>
</table>

<button type="button" class="btn btn-outline-primary" id="addItem">+ Add Item</button>

<div class="mt-3">
    <label>Remarks</label>
    <textarea name="remarks" class="form-control">{{ old('remarks', $replacement->remarks ?? '') }}</textarea>
</div>

<script>
let index = {{ count($items) }};

document.getElementById('addItem').onclick = function(){
    document.querySelector('#itemsTable tbody').insertAdjacentHTML('beforeend', `
        <tr>
            <td>${index+1}</td>
            <td><input type="text" name="items[${index}][item_name]" class="form-control" required></td>
            <td><input type="number" name="items[${index}][quantity]" class="form-control" required></td>
            <td><button type="button" class="btn btn-danger btn-sm removeRow">✖</button></td>
        </tr>
    `);
    index++;
};

document.addEventListener('click', function(e){
    if(e.target.classList.contains('removeRow')){
        e.target.closest('tr').remove();
    }
});
</script>
