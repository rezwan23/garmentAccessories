@extends('layouts.master')
@section('title', 'All Brands')
@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <h4 class="card-header">All Brands <span class="float-right">
                        <a href="{{route('product_brand.create')}}" class="btn btn-warning btn-sm">Add New</a>
                    </span></h4>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Brand Name</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($brands as $brand)
                        <tr>
                            <td>{{$loop->index+1}}</td>
                            <td>{{$brand->name}}</td>
                            <td>
                                <input type="hidden" value="{{$brand->id}}" class="brand_id">
                                <a href="javascript:void(0);" class="btn btn-primary btn-sm float-left editBrandBtn">Edit</a>
                                <form class="float-left" onsubmit="return confirm('Are you sure?')" style="margin-left:4px;" action="{{route('product_brand.destroy', $brand->id)}}" method="post">
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
    <div class="modal fade" id="editBrand">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Brand</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal body -->
                <form action="" method="post" id="edit-brand-form">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label">Name</label>
                                    <input name="name" id="brand_name" class="form-control" type="text" required placeholder="Enter Supplier name">
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
    <script src="{{asset('js/sweetalert.js')}}"></script>
    <script src="{{asset('js/form.js')}}"></script>
    <script>
        $(document).on('click', '.editBrandBtn', function(){
            $('#edit-brand-form').trigger('reset');
            var brand_id = $(this).siblings('input.brand_id').val();
            var action = 'product_brand/'+brand_id;
            $('#edit-brand-form').attr('action', action);
            $.get('product_brand/'+brand_id+'/edit', {}, function(data){
                $('#brand_name').val(data.name);
                $('#editBrand').modal('show');
            });
        });
        $('#edit-brand-form').transmitData({
            formReset: false,
            successCallback: function () {
                location.reload();
            }
        });
    </script>
@endsection