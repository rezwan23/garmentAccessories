@extends('layouts.master')

@section('title', 'Print Challan')

@section('head')
    <style>
            .company_meta h4{

            }
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <h4 class="card-header">Print Challan</h4>
                <div class="tile">
                    <section  style="margin-left: 20px;" class="invoice" id="print">
                        <div class="row mb-4">
                            <div class="col-md-2"></div>
                            <div class="col-md-8">
                                <div class="company_meta">
                                    <div class="text-center">
                                        <h1 style="text-transform: uppercase;">{{auth()->user()->company->name}}</h1>
                                        <p style="text-transform: uppercase">{{auth()->user()->company->address}}
                                        <br> Email : {{auth()->user()->company->emails}}
                                            <br> Phone : {{auth()->user()->company->phones}}</p>
                                        <h1>DELIVERY CHALLAN</h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 20px;">
                            <div style="float:left;width:8%">
                                <strong><p>Challan ID : </p></strong>
                            </div>
                            <div style="float:left;width:8%;border-bottom: 1px solid #000;">
                                <strong><p>{{$order->getChallanId()}}</p></strong>
                            </div>
                            <div style="width:63%;"></div>
                            <div style="float:right;width:5%;">
                                <strong><p>Date : </p></strong>
                            </div>
                            <div style="float:right;width:8%;border-bottom: 1px dotted #000;">
                                <strong><p>{{$order->order_date}}</p></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div style="float:left;width:8%">
                                <strong><p>To : </p></strong>
                            </div>
                            <div style="float:left;width:92%;border-bottom: 1px solid #000;">
                                <strong><p>{{$order->dyeingCompany->name}}</p></strong>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 20px;margin-bottom: 20px;">
                            <div style="float:left;width:8%">
                                <strong><p>Address : </p></strong>
                            </div>
                            <div style="float:left;width:92%;border-bottom: 1px solid #000;">
                                <strong><p>{{$order->dyeingCompany->address}}</p></strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>SL No.</th>
                                        <th>Material Description</th>
                                        <th>Quantity</th>
                                        <td>Unit</td>
                                        <th>Remarks</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($order->materials as $material)
                                    <tr>
                                        <td>{{$loop->index+1}}</td>
                                        <td>{{$material->accessory->name}}</td>
                                        <td>{{$material->quantity}}</td>
                                        <td>{{$material->accessory->unit->name}}</td>
                                        <td>{{$material->remarks}}</td>
                                    </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 20px;">
                            <div width="25%">
                                <h2>Signature of the Recipient</h2>
                                <div width="5%" style="float:left;margin-top: 100px;">Name</div>
                                <div width="95%" style="border-bottom: 1px dotted #000;float:left;width:200px;padding-top:120px;">
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top:20px">
                            <div width="25%">
                                <div width="5%" style="float:left">Designation</div>
                                <div width="95%" style="border-bottom: 1px dotted #000;float:left;width:165px;padding-top:20px;">
                                </div>
                            </div>
                        </div>
                        <div class="row d-print-none mt-2">
                            <div class="col-12 text-right"><a href="javascript:void(0)" onclick="print()" class="btn btn-primary">Print</a></div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script src="{{asset('admin/js/printThis.js')}}"></script>
    <script>
        function print()
        {
            $('#print').printThis({
                importStyle: true,
            });
        }
    </script>
@endsection