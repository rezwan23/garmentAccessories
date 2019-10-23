@extends('layouts.master')

@section('title', 'Create Lc Document')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">New LC Document <span class="float-right">
                        <a href="{{route('lc.index')}}" class="btn btn-warning btn-sm">View All</a>
                    </span></h4>
                <div class="card-body">
                    <form action="" method="post">
                        <div class="tile">
                            <div class="tile-body">
                                <div class="row">
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Seller Bank</label>
                                        <input name="seller_bank" autocomplete="off" class="form-control" type="text" placeholder="Enter Seller Bank Name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Seller Bank Branch</label>
                                        <input name="seller_bank_branch" autocomplete="off" class="form-control" type="text" placeholder="Enter Seller Bank Branch">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Buyer Bank</label>
                                        <input name="buyer_bank" autocomplete="off" class="form-control" type="text" placeholder="Enter Buyer Bank Name">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Buyer Bank Branch</label>
                                        <input name="buyer_bank_branch" autocomplete="off" class="form-control" type="text" placeholder="Enter Buyer Bank Branch">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">LC Number</label>
                                        <input name="lc_number" autocomplete="off" class="form-control" type="text" placeholder="Enter LC Number">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Payment terms</label>
                                        <input name="payment_terms" autocomplete="off" class="form-control" type="text" placeholder="Enter Payment terms">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Document Forward Party Date</label>
                                        <input id="date1" name="party_date" autocomplete="off" class="form-control" type="text" placeholder="Enter Doc forward party date">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Document Forward Bank Date</label>
                                        <input id="date2" name="bank_date" autocomplete="off" class="form-control" type="text" placeholder="Enter Doc forward bank date">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Acceptance date</label>
                                        <input id="date3" name="accept_date" autocomplete="off" class="form-control" type="text" placeholder="Enter Acceptance date">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Adjust Remarks</label>
                                        <input id="date4" name="adjust_remarks" autocomplete="off" class="form-control" type="text" placeholder="Enter Adjust Remarks">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Garments</label>
                                        <input id="garment" onkeypress="loadGarments(this.id)"  autocomplete="off" class="form-control" type="text" placeholder="Enter Garment">
                                        <input type="hidden" id="garment_id" name="garment_id">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label class="control-label">Bank Ref.</label>
                                        <input id="bank_ref"  autocomplete="off" name="bank_ref_no" class="form-control" type="text" placeholder="Enter Bank Ref No.">
                                    </div>
                                </div>
                            </div>
                            @csrf
                                <div class="tile-body">
                                    <h4 class="card-header"> Details</h4>
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th>Serial(PI)</th>
                                            <th>Total ($)</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody class="container_1">
                                        <tr class="group_1">
                                            <td>
                                                <input required class="form-control" type="text" onkeypress="loadSerialNumber(this.id)" name="serial_number[0]" data-pattern-name="serial_number[++]" id="serial_0" data-pattern-id="serial_++">
                                            </td>
                                            <td>
                                                <input required readonly class="form-control each_total" type="text" step=".001" name="total_value[0]" data-pattern-name="total_value[++]" id="total_0" data-pattern-id="total_++">
                                            </td>
                                            <td>
                                                <button class="add_1 btn btn-primary btn-sm" style="margin-right:4px;"><i class="fa fa-plus"></i></button>
                                                <button class="del_1 btn btn-danger btn-sm" onclick="calculate()"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <h4 class="card-header">Total ($)</h4>
                                            <div class="card-body">
                                                <input type="text" readonly id="subtotal" name="all_total" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <div class="tile-footer">
                                <div class="row">
                                    <div class="col-md-12">
                                        <button class="btn btn-primary float-right" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('head')
    <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}">
@endsection

@section('footer')
    <script src="{{asset('admin/js/jquery.form-repeater.js')}}"></script>
    <script src="{{asset('js/jquery-ui.min.js')}}"></script>
        <script type="text/javascript">
            $('.container_1').repeater({
                btnAddClass: 'add_1',
                btnRemoveClass: 'del_1',
                groupClass: 'group_1',
                minItems: 1,
                maxItems: 0,
                startingIndex: 0,
                reindexOnDelete: true,
                repeatMode: 'append',
                animation: null,
                animationSpeed: 400,
                animationEasing: 'swing',
                clearValues: true,
                afterDelete:function(){
                    calculate();
                }
            });
            function loadSerialNumber(id){
                var pi = [];
                @foreach($pis as $pi)
                        pi.push('{{$pi->serial_number}}')
                @endforeach
                $('#'+id).autocomplete({
                    source: pi,
                    select:function(event, ui){
                        $.get('{{route('pi.get')}}', {serial:ui.item.value}, function(data){
                            var idNo = id.split('_')[1];
                            $('#total_'+idNo).val(data.total);
                            calculate();
                        });
                    }
                })
            }
            function calculate(){
                var total = 0.0000;
                $('.each_total').each(function(){
                    total+=parseFloat($(this).val());
                })
                $('#subtotal').val(total);
            }
        </script>
    <script src="{{asset('admin/js/plugins/bootstrap-datepicker.min.js')}}"></script>
    <script>
        @for($i=1;$i<=3;$i++)
            $('#date{{$i}}').datepicker({
                format: "yyyy-mm-dd",
                autoclose: true,
                todayHighlight: true
            });
            @endfor
    </script>

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
                    $('#garment_id').val(ui.item.id);
                }
            })
        }
    </script>
@endsection