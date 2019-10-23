<form class="form-inline">
    <input type="text" name="id" placeholder="Enter Voucher ID" value="{{ request('id') }}" class="form-control mr-2">
    <input type="text" name="name" placeholder="Enter Client Name" value="{{ request('name') }}" class="form-control mr-2">
    <button class="btn-primary btn">Filter</button>
</form>