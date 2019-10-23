<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img style="width: 50px;" height="50px" class="app-sidebar__user-avatar" src="{{asset('uploads/'.auth()->user()->company->logo)}}" alt="User Image">
        <div>
            <p class="app-sidebar__user-name">{{auth()->user()->name}}</p>
        </div>
    </div>
    <ul class="app-menu">
        <li><a class="app-menu__item" href="{{route('sample.order.create')}}"><i class="app-menu__icon fa fa-ticket" aria-hidden="true"></i><span class="app-menu__label">Sample Order</span></a></li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-address-book-o"></i><span class="app-menu__label">Order (JOB)</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                @can('order-create')
                    <li><a class="treeview-item" href="{{route('order.showForm')}}"><i class="icon fa fa-circle-o"></i> Create Order</a></li>
                @endcan
                <li><a class="treeview-item" href="{{route('order.index')}}"><i class="icon fa fa-circle-o"></i> All Orders</a></li>
                @can('raw-materials-assign')
                    <li><a class="treeview-item" href="{{route('order.raw')}}"><i class="icon fa fa-circle-o"></i> Raw Materials Assign</a></li>
                @endcan
                {{--<li><a class="treeview-item" href="{{route('order.assign.commercial.show.form')}}"><i class="icon fa fa-circle-o"></i> Assign Commercial Details</a></li>--}}
                {{--<li><a class="treeview-item" href="{{route('orders.commercial.assigned.get')}}"><i class="icon fa fa-circle-o"></i> Commercial Assigned Orders</a></li>--}}
                <li><a class="treeview-item" href="{{route('order.print.index')}}"><i class="icon fa fa-circle-o"></i> Print Orders</a></li>
                @can('inactive-order')
                    <li><a class="treeview-item" href="{{route('order.inactive')}}"><i class="icon fa fa-circle-o"></i> Inactive Orders</a></li>
                @endcan
            </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-shopping-cart"></i><span class="app-menu__label">Commercial</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                @can('commercial-details-assign')
                    <li><a class="treeview-item" href="{{route('order.assign.commercial.show.form')}}"><i class="icon fa fa-circle-o"></i> Commercial Details Assign</a></li>
                @endcan
                <li><a class="treeview-item" href="{{route('orders.commercial.assigned.get')}}"><i class="icon fa fa-circle-o"></i>All Commercial Assigned Orders</a></li>
                @can('add-lc')
                    <li><a class="treeview-item" href="{{ route('lc.create') }}"><i class="icon fa fa-circle-o"></i>Add New LC</a></li>
                @endcan
                @can('add-pi')
                    <li><a class="treeview-item" href="{{ route('pi.create') }}"><i class="icon fa fa-circle-o"></i>Add New PI</a></li>
                @endcan
                <li><a class="treeview-item" href="{{ route('pi.index') }}"><i class="icon fa fa-circle-o"></i>All PI</a></li>
            </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-thermometer-empty"></i><span class="app-menu__label">Dyeing </span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{route('dyeing.order.index')}}"><i class="icon fa fa-circle-o"></i> All Dyeing Assigns</a></li>
                <li><a class="treeview-item" href="{{route('dyeing.order.create')}}"><i class="icon fa fa-circle-o"></i> Assign New Dyeing</a></li>
            </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-credit-card-alt"></i><span class="app-menu__label">Factory</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                @can('view-production')
                    <li><a class="treeview-item" href="{{route('production.index')}}"><i class="icon fa fa-circle-o"></i>All Productions</a></li>
                @endcan
                @can('add-production-record')
                    <li><a class="treeview-item" href="{{route('production.create')}}"><i class="icon fa fa-circle-o"></i>Add Production Record</a></li>
                @endcan
                @can('order-delivery')
                    <li><a class="treeview-item" href="{{route('delivery.index')}}"><i class="icon fa fa-circle-o"></i>Order Delivery</a></li>
                @endcan
                @can('receive-dyeing-yarn')
                    <li><a class="treeview-item" href="{{route('dyeing.receive.form')}}"><i class="icon fa fa-circle-o"></i>Receive Dyeing Yarn</a></li>
                @endcan
                @can('receive-dyeing-yarn-all')
                    <li><a class="treeview-item" href="{{route('receive.dyeing.index')}}"><i class="icon fa fa-circle-o"></i>All Receive Dyeing Yarn</a></li>
                @endcan
            </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Item Settings</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                {{--<li><a class="treeview-item" href="{{route('product_brand.index')}}"><i class="icon fa fa-circle-o"></i> Product Brands</a></li>--}}
                @can('raw-materials-crud')
                <li><a class="treeview-item" href="{{route('accessory.index')}}"><i class="icon fa fa-circle-o"></i> Raw Materials</a></li>
                @endcan
                @can('materials-category-crud')
                <li><a class="treeview-item" href="{{route('accessory_category.index')}}"><i class="icon fa fa-circle-o"></i> Raw Materials Categories</a></li>
                @endcan
                @can('items-crud')
                <li><a class="treeview-item" href="{{route('item.index')}}"><i class="icon fa fa-circle-o"></i> Items</a></li>
                @endcan
                @can('units-crud')
                <li><a class="treeview-item" href="{{route('product_unit.index')}}"><i class="icon fa fa-circle-o"></i> Units</a></li>
                @endcan
                @can('colors-crud')
                <li><a class="treeview-item" href="{{route('color.index')}}"><i class="icon fa fa-circle-o"></i> Colors</a></li>
                @endcan
            </ul>
        </li>
        @can('purchase')
            <li><a class="app-menu__item" href="{{route('purchase.create')}}"><i class="app-menu__icon fa fa-university" aria-hidden="true"></i><span class="app-menu__label">Purchase Accessory</span></a></li>
        @endcan
        @can('debit')
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-money"></i><span class="app-menu__label">Debit (Payment)</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                @can('debit-voucher')
                <li><a class="treeview-item" href="{{ route('accounts.debit-vouchers.create') }}"><i class="icon fa fa-circle-o"></i> Voucher</a></li>
                @endcan
                @can('debit-payment')
                <li><a class="treeview-item" href="{{route('accounts.debit-vouchers.payment')}}"><i class="icon fa fa-circle-o"></i>Payment</a></li>
                @endcan
            </ul>
        </li>
        @endcan
        @can('credit')
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-credit-card-alt"></i><span class="app-menu__label">Credit (Receive)</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                @can('credit-voucher')
                    <li><a class="treeview-item" href="{{ route('accounts.credit-vouchers.create') }}"><i class="icon fa fa-circle-o"></i> Voucher</a></li>
                @endcan
                @can('credit-payment')
                    <li><a class="treeview-item" href="{{ route('accounts.credit-vouchers.payment') }}"><i class="icon fa fa-circle-o"></i> Payment Receive</a></li>
                @endcan
            </ul>
        </li>
        @endcan
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-pencil-square-o"></i><span class="app-menu__label">Account Configuration</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                @can('sector-view')
                    <li><a class="treeview-item" href="{{route('accountSector.index')}}"><i class="icon fa fa-circle-o"></i> Account Sector</a></li>
                @endcan
                @can('account-view')
                    <li><a class="treeview-item" href="{{route('account.index')}}"><i class="icon fa fa-circle-o"></i> Accounts</a></li>
                @endcan
                @can('payment-method-view')
                    <li><a class="treeview-item" href="{{route('paymentMethod.index')}}"><i class="icon fa fa-circle-o"></i> Payment Methods</a></li>
                @endcan
            </ul>
        </li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-briefcase"></i><span class="app-menu__label">Employee Management</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                @can('add-department')
                    <li><a class="treeview-item" href="{{route('department.index')}}"><i class="icon fa fa-circle-o"></i>Add Department</a></li>
                @endcan
                @can('add-designation')
                    <li><a class="treeview-item" href="{{route('designation.index')}}"><i class="icon fa fa-circle-o"></i>Add Designation</a></li>
                @endcan
                @can('add-employee')
                    <li><a class="treeview-item" href="{{route('employee.create')}}"><i class="icon fa fa-circle-o"></i>Add Employee</a></li>
                @endcan
                    @can('salary-setup')
                        <li><a class="treeview-item" href="{{route('salary.prepare.show.form')}}"><i class="icon fa fa-circle-o"></i>Prepare Salary</a></li>
                        <li><a class="treeview-item" href="{{route('salary.sheet')}}"><i class="icon fa fa-circle-o"></i>Salary Generate</a></li>
                        <li><a class="treeview-item" href="{{route('salary.sheet.record')}}"><i class="icon fa fa-circle-o"></i>Salary Sheet</a></li>
                    @endcan
            </ul>
        </li>
        @can('allowance-&-deduction')
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-server"></i><span class="app-menu__label">Salary Extra Allowance</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{URL::to('allowance')}}"><i class="icon fa fa-circle-o"></i>Allowance & Deduction</a></li>
            </ul>
        </li>
        @endcan
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Users</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{route('role.index')}}"><i class="icon fa fa-circle-o"></i>Roles</a></li>
                <li><a class="treeview-item" href="{{route('user.index')}}"><i class="icon fa fa-circle-o"></i>Users</a></li>
            </ul>
        </li>
        @can('company-user-crud')
        {{--<li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-users"></i><span class="app-menu__label">Company</span><i class="treeview-indicator fa fa-angle-right"></i></a>--}}
            {{--<ul class="treeview-menu">--}}
                {{--<li><a class="treeview-item" href="{{\Illuminate\Support\Facades\URL::to('/company')}}"><i class="icon fa fa-circle-o"></i>Companies</a></li>--}}
                {{--<li><a class="treeview-item" href="{{route('user.index')}}"><i class="icon fa fa-circle-o"></i>Users</a></li>--}}
            {{--</ul>--}}
        {{--</li>--}}
        @endcan
        {{--<li><a class="app-menu__item" href="{{route('order.showForm')}}"><i class="app-menu__icon fa fa-shopping-cart" aria-hidden="true"></i><span class="app-menu__label">Add Order</span></a></li>--}}
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-cog"></i><span class="app-menu__label">Reports</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                {{--<li><a class="treeview-item" href="{{route('product_brand.index')}}"><i class="icon fa fa-circle-o"></i> Product Brands</a></li>--}}
                @can('inventory-report')
                <li><a class="treeview-item" href="{{route('report.inventory')}}"><i class="icon fa fa-circle-o"></i> Inventory Report</a></li>
                @endcan
                <li><a class="treeview-item" href="{{route('report.dyeing')}}"><i class="icon fa fa-circle-o"></i> Dyeing Yarn Company Report</a></li>
                <li><a class="treeview-item" href="{{route('report.dyeing.company')}}"><i class="icon fa fa-circle-o"></i> Dyeing Yarn Receive Report</a></li>
                @can('yarn-inventory-report')
                <li><a class="treeview-item" href="{{route('report.yarn')}}"><i class="icon fa fa-circle-o"></i>Dyeing Yarn Inventory Report</a></li>
                @endcan
                @can('item-inventory-report')
                <li><a class="treeview-item" href="{{route('report.item')}}"><i class="icon fa fa-circle-o"></i>Item Inventory Report</a></li>
                @endcan
                <li><a class="treeview-item" href="{{route('report.production')}}"><i class="icon fa fa-circle-o"></i>Production Report</a></li>
                @can('income-expense')
                <li><a class="treeview-item" href="{!! route('accounts.report.income-expense') !!}"><i class="icon fa fa-circle-o"></i>Income / Expense</a></li>
                @endcan
{{--                <li><a class="treeview-item" href="{!! route('accounts.report.party') !!}"><i class="icon fa fa-circle-o"></i>Party Report</a></li>--}}
                @can('party-report')
                <li><a class="treeview-item" href="{!! route('accounts.report.party-bill') !!}"><i class="icon fa fa-circle-o"></i>Party Report</a></li>
                @endcan
                @can('cash-report')
                <li><a class="treeview-item" href="{!! route('accounts.report.cash') !!}"><i class="icon fa fa-circle-o"></i>Cash Report</a></li>
                @endcan
                <li><a class="treeview-item" href="{{ route('report.order') }}"><i class="icon fa fa-circle-o"></i>Order Report</a></li>
                <li><a class="treeview-item" href="{{ route('report.delivery') }}"><i class="icon fa fa-circle-o"></i>Delivery Report</a></li>
                <li><a class="treeview-item" href="{{ route('report.daily.delivery') }}"><i class="icon fa fa-circle-o"></i>Daily Delivery Report</a></li>
                <li><a class="treeview-item" href="{{ route('report.purchase') }}"><i class="icon fa fa-circle-o"></i>Purchase Report</a></li>
            </ul>
        </li>
        <li><a class="app-menu__item" href="{{route('company.index')}}"><i class="app-menu__icon fa fa-cogs"></i><span class="app-menu__label">Company Settings</span></a></li>
        <li class="treeview"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-cogs"></i><span class="app-menu__label">Other Settings</span><i class="treeview-indicator fa fa-angle-right"></i></a>
            <ul class="treeview-menu">
                <li><a class="treeview-item" href="{{route('garments.index')}}"><i class="icon fa fa-circle-o"></i>Garments</a></li>
                <li><a class="treeview-item" href="{{route('dyeing_companies.index')}}"><i class="icon fa fa-circle-o"></i>Dyeing Companies</a></li>
                <li><a class="treeview-item" href="{{route('buyers.index')}}"><i class="icon fa fa-circle-o"></i>Buyers</a></li>
                <li><a class="treeview-item" href="{{route('merchants.index')}}"><i class="icon fa fa-circle-o"></i>Merchants</a></li>
                <li><a class="treeview-item" href="{{route('vendors.index')}}"><i class="icon fa fa-circle-o"></i>Vendors</a></li>
            </ul>
        </li>
        @can('backup-data')
        <li><a class="app-menu__item" href="{{route('backup')}}"><i class="app-menu__icon fa fa-building"></i><span class="app-menu__label">BackUp Data</span></a></li>
        @endcan
    </ul>
</aside>
