@extends('layouts.master')
@section('title', 'Add New Company')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="tile">
                <h3 class="tile-title">Add New Company</h3>
                <form action="{{route('company.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control {{$errors->has('name')?'is-invalid':''}}" name="name" type="text" placeholder="Enter Company Name">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Web Site</label>
                            <input class="form-control {{$errors->has('website')?'is-invalid':''}}" name="website" type="text" placeholder="Enter web site address">
                            @if ($errors->has('website'))
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('website') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <textarea class="form-control {{$errors->has('address')?'is-invalid':''}}" rows="4" name="address" placeholder="Enter your address"></textarea>
                            @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Emails (Separated by comma)</label>
                            <input type="text" name="emails" class="form-control {{$errors->has('emails')?'is-invalid':''}}" placeholder="Emter Company Emails">
                            @if ($errors->has('emails'))
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('emails') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">phones (Separated by comma)</label>
                            <input class="form-control {{$errors->has('phones')?'is-invalid':''}}" name="phones" type="text" placeholder="Enter Company Phones">
                            @if ($errors->has('phones'))
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('phones') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Logo</label>
                            <input class="form-control {{$errors->has('logo')?'is-invalid':''}}" type="file" name="logo" onchange="readURL(this);">
                            @if ($errors->has('logo'))
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('logo') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label"></label>
                            <img id="blah" width="150px" height="100px" src="{{!empty($info)?asset('uploads/'.$info->logo):asset('/uploads/photo.png')}}" alt="">
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('footer')
    <script>
    function readURL(input) {
    if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
    $('#blah')
    .attr('src', e.target.result);
    };

    reader.readAsDataURL(input.files[0]);
    }
    }
    </script>
    @endsection

@section('footer')

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>

    @endsection