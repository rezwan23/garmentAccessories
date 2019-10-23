@if(\Illuminate\Support\Facades\Session::has('success-message'))
    <script>
        swal({
            icon: "success",
            title: "{{\Illuminate\Support\Facades\Session::get('success-message')}}"
        });
    </script>

    @endif
@if(session()->has('errors')&& (session('errors')->first('error-message'))!=null)
    <script>
        swal({
            icon: "error",
            title: "{{session('errors')->first('error-message')}}",
        });
    </script>
    @endif
@if(session()->has('errors')&& (session('errors')->first('order_id'))!=null)
    <script>
        swal({
            icon: "error",
            title: "{{session('errors')->first('order_id')}}",
        });
    </script>
@endif
@if(session()->has('errors')&& (session('errors')->first('accessory_id.0'))!=null)
    <script>
        swal({
            icon: "error",
            title: "{{session('errors')->first('accessory_id.0')}}",
        });
    </script>
@endif
@if(session()->has('errors')&& (session('errors')->first('password'))!=null)
    <script>
        swal({
            icon: "error",
            title: "{{session('errors')->first('password')}}",
        });
    </script>
@endif