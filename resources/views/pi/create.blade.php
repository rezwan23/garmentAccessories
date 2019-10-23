@extends('layouts.master')

@section('title', 'Add PI')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="tile">
                <div class="tile-body">
                    <form action="" id="garments_form">
                    <label for="" class="control-label">Select Garments</label>
                    <input class="form-control" type="text" id="garment_name" onkeypress="loadGarments(this.id)" placeholder="Enter garment name">
                        <input type="hidden" name="garments_id" id="garments_id">
                    </form>
                </div>
            </div>
            @if($orders!=null)
            <div class="tile">
                <h3 class="tile-title float-left">Garment - {{$garment->name}}</h3>
                <a href="{{route('pi.index')}}" class="btn btn-primary float-right">All PI</a>
                <div class="clearfix"></div>
                <form action="{{route('pi.create')}}" method="post">
                    @csrf
                <div class="tile-body">
                    <div class="form-group">
                        <label class="control-label">Job Id</label>
                        <select name="order_id[]" onchange="myFunction($(this))" multiple id="demoSelect" style="width: 100%;">
                            @foreach($orders as $order)
                                <option value="{{$order->job_id}}">{{$order->job_id}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Total ($)</label>
                        <input type="hidden" name="garment_id" value="{{$garment->id}}">
                        <input readonly class="form-control" id="total" name="total" step=".0001" type="number" placeholder="Enter Item total">
                    </div>
                </div>
                <div class="tile-footer">
                    <button class="btn btn-primary" type="submit">Submit</button>
                </div>
                </form>
            </div>
                @endif
        </div>
    </div>
@endsection
@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection
@section('footer')
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
    <script>
        function loadGarments(id){
            $('#'+id).autocomplete({
                source : function(request, response){
                    $.get('{{route('garments.all')}}', {name:request.term}, function(data){
                        response($.map(data, function(garment){
                            return {
                                label : garment.name,
                                value: garment.name,
                                id: garment.id,
                            }
                        }))
                    })
                },
                select: function(event, ui){
                    $('#garments_id').val(ui.item.id);
                    $('#garments_form').submit();
                }
            })
        }
    </script>
    <script type="text/javascript" src="{{asset('admin/js/plugins/select2.min.js')}}"></script>
    <script>
        $('#demoSelect').select2();
        function myFunction(el){
            $.get('{{route('pi.total.get')}}', {'id':el.val()}, function(data){
                console.log(data.total);
                $('#total').val(data.total);
            });
        }
    </script>
@endsection