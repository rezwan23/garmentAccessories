@extends('layouts.master')
@section('title', 'Delivery Challan')

@section('head')
    <style>
            @media print{
                #print_0{
                    page-break-after: always;
                }
                .no-show{
                    display: none;
                }
                #print_1{
                    page-break-after: always;
                }
                #print_2{
                    page-break-after: always;
                }
                /**{*/
                    /*font-family: "Times New Roman";*/
                /*}*/
            }
    </style>
@endsection


@section('content')
    <div style="float:right" class="no-show">
        <button class="btn btn-warning btn-sm" id="print_btn" onclick="window.print()">Print</button>
    </div>
    <div id="print-content">
    <?php for($i=0;$i<3;$i++):?>
         <div class="row" id="print" style="position: relative">
             <div style="position: absolute;top: 50px;left: 50px;">
                 <div style="height: 60px;width:170px;border:1px solid #000;float: left;">
                     <span style="font-size: 15px;font-weight: 700;">
                        Challan No.: {{$delivery->id}}
                     </span>
                 </div>
             </div>
            <div class="col-md-12">
                <div style="text-align: center;">
                    <div style="text-align: center;" class="text-center">
                        <div class="text-center">
                            <h1>{{auth()->user()->company->name}}</h1>
                            <p>{!! auth()->user()->company->address !!}<br>
                                E-mail : {{auth()->user()->company->emails}}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <p style="margin:0 auto;display: block;text-align:center;font-size: 20px;font-weight: 800;color:#000;border: 2px solid #3B3B3B;width:280px;padding:8px;">Delivery Challan
                    <br> job ID {{$delivery->order->id}}</p>
            </div>
             <div class="col-md-12">
                 <p style="margin:20px auto;display: block;text-align:center;font-size: 18px;font-weight: 800;width:200px;padding:10px;">
                     @if($i==0)
                         Buyer Copy
                     @elseif($i==1)
                        Lc Document Copy
                     @else
                        Office Copy
                     @endif
                 </p>
             </div>
            <div class="col-md-6">
                <h4>Date: <span style="text-decoration: underline">{{$delivery->delivery_date}}</span></h4>
                <h4>To: <span style="text-decoration: underline">{{$delivery->order->garments->name}}</span></h4>
                <h4>Address: <span style="text-decoration: underline;">{{$delivery->order->garments->address}}</span> </h4>
            </div>
             <div class="col-md-6">
                 <h4>Buyer: <span style="text-decoration: underline">{{$delivery->order->buyer->name}}</span></h4>
                 <h4>Merchant Name: <span style="text-decoration:underline">{{$delivery->order->merchant->name}}</span></h4>
                 <h4>Style No:  <span style="text-decoration: underline">{{$delivery->order->style_number}}</span></h4>
             </div>
            <div class="col-md-12">
                <p>Please receive the following articles in proper condition against your order No.</p>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>Item</th>
                        <th>Color</th>
                        <td>Order Quantity</td>
                        {{--<th>Past Delivery</th>--}}
                        <th>Current Delivery</th>
                        <th>Due Quantity</th>
                        <th>Unit</th>
                        <th>Remarks</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($delivery->items as $item)
                        <tr>
                            <td>{{$item->item->name .'-'.$item->orderedItem->size}}</td>
                            <td>{{$item->color->name}}</td>
                            <td>{{$item->orderedItem->quantity}}</td>
                            {{--<td>{{$item->orderedItem->getDeliveryCount()-$item->quantity}}</td>--}}
                            <td>{{number_format($item->quantity, 0)}}</td>
                            <td>{{$item->orderedItem->getDeliveryDue()}}</td>
                            <td>{{$item->item->unit->name}}</td>
                            <td>{{$item->remarks}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-12">
                <div style="margin-top:40px;">
                    <h4 style="display: inline-block;float:left">Signature of the Recipient</h4>
                    <h4 style="display: inline-block;float:right">For {{auth()->user()->company->name}}</h4>
                </div>
            </div>
            <div class="col-md-12">
                <div style="float: left; margin-top:30px;">
                    <h6>Name :</h6>
                    <h6>Designation :</h6>
                </div>
                <div style="float: left;margin-top:30px;margin-left:34%">
                    <h6>Store Incharge</h6>
                </div>
                <div style="float: Right; margin-top:30px;">
                    <h6>Authorized Signature</h6>
                </div>
            </div>
        </div>
        <div id="print_{{$i}}"></div>
    <?php endfor;?>
    </div>
@endsection

@section('footer')
    <script src="{{asset('admin/js/printThis.js')}}"></script>
    <script>
//        function print()
//        {
//            $('#print-content').printThis({
//                importStyle: true,
//            });
//        }
    </script>
@endsection