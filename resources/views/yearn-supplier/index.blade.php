@extends('layouts.master')
@section('title', 'All Supplier')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">All Suppliers <span class="float-right">
                        <a href="{{route('yearn_supplier.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span></h4>
                <div class="clearfix"></div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($suppliers as $supplier)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <td>{{$supplier->name}}</td>
                                <td>{{$supplier->phone}}</td>
                                <td>{{$supplier->email}}</td>
                                <td>
                                    <input type="hidden" value="{{$supplier->id}}" class="supplier_id">
                                    <a class="btn btn-primary btn-sm float-left edit_btn" href="javascript:void(0);">Edit</a>
                                    <form class="float-left" style="margin-left:6px;" onsubmit="return confirm('Are you sure? You want to delete this item?');" action="{{route('yearn_supplier.destroy', $supplier->id)}}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-warning btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="editSupplier">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Supplier</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form action="" method="post" id="edit-form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Name</label>
                                    <input name="name" id="supplier_name" class="form-control" type="text" placeholder="Enter Supplier name">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Representative</label>
                                    <input class="form-control" id="supplier_representative" type="text" name="representative" placeholder="Enter Supplier Representative"></input>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Phone</label>
                                    <input class="form-control" id="supplier_phone" type="text" name="phone" placeholder="Enter Supplier Phone Number">
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Website Address</label>
                                    <input type="text" class="form-control" id="supplier_website_address" name="website_address" placeholder="Enter Company Website Address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="control-label">Address</label>
                                    <textarea name="address" id="supplier_address" cols="30" rows="4" class="form-control" placeholder="Enter Supplier Address"></textarea>
                                </div>
                                <div class="form-group">
                                    <label class="control-label">Email</label>
                                    <input class="form-control" id="supplier_email" type="email" name="email" placeholder="Enter Supplier Email">
                                </div>
                            </div>
                        </div>
                        @csrf
                        @method('PUT')

                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('footer')
    <script src="{{asset('js/form.js')}}"></script>
    <script>
        $(document).on('click', '.edit_btn', function(){
            $('#edit-form').trigger('reset');
            var supplier_id = $(this).siblings('input.supplier_id').val();
            var action = 'yearn_supplier/'+supplier_id;
            $.get('yearn_supplier/'+supplier_id+'/edit', {}, function(data){
                $('#edit-form').attr('action', action);
                $('#supplier_name').val(data.name);
                $('#supplier_address').val(data.address);
                $('#supplier_website_address').val(data.website_address);
                $('#supplier_phone').val(data.phone);
                $('#supplier_representative').val(data.representative);
                $('#supplier_email').val(data.email);
                $('#editSupplier').modal('show');
            });
        });
        $('#edit-form').transmitData({
            formReset: false,
            successCallback: function () {
                location.reload();
            }
        });
    </script>
@endsection