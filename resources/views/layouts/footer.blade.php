        <script src="{{asset('admin/js/jquery-3.2.1.min.js')}}"></script>
        <script src="{{asset('admin/js/popper.min.js')}}"></script>
        <script src="{{asset('admin/js/bootstrap.min.js')}}"></script>
        <script src="{{asset('admin/js/main.js')}}"></script>
        <!-- The javascript plugin to display page loading on top-->
        <script src="{{asset('admin/js/plugins/pace.min.js')}}"></script>
        <script src="{{asset('js/sweetalert.js')}}"></script>
        @yield('footer')
        @include('layouts.messages')
        <script>
                $('document').ready(function(){
                    $('ul.pagination').addClass('float-right');
                })
        </script>
        </body>
</html>