@extends('layouts.master')
@section('title', 'Company Settings')
@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="tile">
                <h3 class="tile-title">Company Settings</h3>
                <form action="{{route('info.update')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label">Name</label>
                            <input class="form-control {{$errors->has('name')?'is-invalid':''}}" value="{{!empty($info)?$info->name:''}}" name="name" type="text" placeholder="Enter Company Name">
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Web Site</label>
                            <input class="form-control {{$errors->has('website')?'is-invalid':''}}" value="{{!empty($info)?$info->website:''}}" name="website" type="text" placeholder="Enter web site address">
                            @if ($errors->has('website'))
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('website') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Address</label>
                            <textarea class="form-control {{$errors->has('address')?'is-invalid':''}}" rows="4" name="address" placeholder="Enter your address">{{!empty($info)?$info->address:''}}</textarea>
                            @if ($errors->has('address'))
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('address') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Emails (Separated by comma)</label>
                            <input type="text" name="emails" class="form-control {{$errors->has('emails')?'is-invalid':''}}" value="{{!empty($info)?$info->emails:''}}" placeholder="Emter Company Emails">
                            @if ($errors->has('emails'))
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('emails') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">phones (Separated by comma)</label>
                            <input class="form-control {{$errors->has('phones')?'is-invalid':''}}" name="phones" value="{{!empty($info)?$info->phones:''}}" type="text" placeholder="Enter Company Phones">
                            @if ($errors->has('phones'))
                                <span class="invalid-feedback" role="alert">N
                                     <strong>{{ $errors->first('phones') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Terms and Conditions</label>
                            <textarea class="form-control {{$errors->has('terms_conditions')?'is-invalid':''}}" rows="4" name="terms_conditions" placeholder="Enter Commercial Terms And Conditions">{{!empty($info)?$info->terms_conditions:''}}</textarea>
                            @if ($errors->has('terms_conditions'))
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('terms_conditions') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Authorize Name</label>
                            <textarea class="form-control {{$errors->has('authorize_name')?'is-invalid':''}}" rows="4" name="authorize_name" placeholder="Enter Commercial Authorize Name">{{!empty($info)?$info->authorize_name:''}}</textarea>
                            @if ($errors->has('authorize_name'))
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('authorize_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Additional Details</label>
                            <textarea class="form-control {{$errors->has('additional_details')?'is-invalid':''}}" rows="4" name="additional_details" placeholder="Enter Commercial Additional Details">{{!empty($info)?$info->additional_details:''}}</textarea>
                            @if ($errors->has('additional_details'))
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('additional_details') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="control-label">Dyeing Delivery Place</label>
                            <textarea class="form-control {{$errors->has('dyeing_delivery_place')?'is-invalid':''}}" rows="4" name="dyeing_delivery_place" placeholder="Enter Dyeing Yarn Delivery place">{{!empty($info)?$info->dyeing_delivery_place:''}}</textarea>
                            @if ($errors->has('dyeing_delivery_place'))
                                <span class="invalid-feedback" role="alert">
                                     <strong>{{ $errors->first('dyeing_delivery_place') }}</strong>
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
                    <input type="hidden" name="company_id" value="{{$info->id}}">
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