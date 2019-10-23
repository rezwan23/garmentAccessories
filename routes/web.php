<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Auth::routes(['register'=>false]);

Route::get('/home', 'HomeController@index')->name('home');
// middleware added to controller
Route::group(['middleware'=>'auth'], function(){

    //Company Crud
    Route::resource('company', 'CompanyController')->middleware('can:company-user-crud');

    Route::resource('color', 'ColorController');

    Route::get('/company-settings', 'InfoController@index')->middleware('permission:edit-company-settings')->name('company.index');
    Route::post('/company-settings', 'InfoController@update')->middleware('permission:edit-company-settings')->name('info.update');

    Route::resource('yearn_supplier', 'YearnSupplierController')->except('show');
    Route::resource('product_category', 'ProductCategoryController')->except('show');
    Route::resource('product_brand', 'ProductBrandController')->except('show');
    Route::resource('product_unit', 'ProductUnitController')->except('show');
    Route::get('yarn-order', 'YarnOrderController@showForm')->name('yarnOrder.showForm');

    //Purchase Routes
    Route::get('purchase', 'PurchaseController@index')->name('purchase.index')->middleware('can:purchase-view');
    Route::get('purchase/{purchase}/view', 'PurchaseController@show')->name('purchase.view');
//    Route::get('purchase/{purchase}/edit', 'PurchaseController@edit')->name('purchase.edit');
    Route::put('purchase/{purchase}/edit', 'PurchaseController@update')->name('purchase.update');
    Route::delete('purchase/{purchase}/delete', 'PurchaseController@destroy')->name('purchase.destroy')->middleware('can:purchase-delete');
    Route::get('purchase/create', 'PurchaseController@create')->name('purchase.create')->middleware('can:purchase-view');
    Route::post('purchase/create', 'PurchaseController@store')->name('purchase.store');
    Route::get('purchase/get-unit', 'PurchaseController@getUnit')->name('purchase.get.unit');

    //reports Routes
    Route::get('report/inventory', 'ReportController@inventory')->name('report.inventory')->middleware('can:inventory-report');
    Route::get('report/dyeing-yarn', 'ReportController@yarnInventory')->name('report.yarn')->middleware('can:yarn-inventory-report');
    Route::get('report/item', 'ReportController@ItemInventory')->name('report.item')->middleware('can:item-inventory-report');
    Route::get('report/order-based-report', 'ReportController@orderReport')->name('report.order')->middleware('can:order-report');
    Route::get('report/dyeing-based-report', 'ReportController@dyeingCompanyReport')->name('report.dyeing')->middleware('can:dyeing-yarn-report');
    Route::get('report/dyeing-company-report', 'ReportController@dyeingCompanyBasedReport')->name('report.dyeing.company')->middleware('can:dyeing-yarn-company-report');
    Route::get('report/production', 'ReportController@production')->name('report.production')->middleware('can:production-report');
    Route::get('report/delivery', 'ReportController@delivery')->name('report.delivery')->middleware('can:delivery-report');
    Route::get('report/purchase', 'ReportController@purchase')->name('report.purchase');
    Route::get('report/daily-delivery', 'ReportController@dailyDelivery')->name('report.daily.delivery');

    // Order Routes
    Route::get('add-order', 'OrderController@showForm')->middleware('can:order-create')->name('order.showForm');
    Route::post('add-order', 'OrderController@OrderCreate');
    Route::get('all-orders', 'OrderController@index')->name('order.index')->middleware('can:view-orders');
    Route::get('all-orders-without-raw-materials', 'OrderController@toBeGivenRawMaterialsOrders')->name('order.raw');
    Route::get('all-orders/{order}/edit', 'OrderController@edit')->name('order.edit');
    Route::get('all-orders/{order}/changeStatus', 'OrderController@changeStatus')->name('order.change.status')->middleware('can:inactive-order');
    Route::get('all-orders/inactive-orders', 'OrderController@inactiveOrders')->name('order.inactive')->middleware('can:inactive-order');
    Route::put('all-orders/{order}/edit', 'OrderController@update')->name('order.update');
    Route::get('all-orders/{order}/assign-requirements/', 'OrderController@assingRequirementsForm')->middleware('can:raw-materials-assign')->name('order.assign.requirements.show.form');
    Route::post('all-orders/{order}/assign-requirements/', 'OrderController@assignRequirements')->middleware('can:raw-materials-assign')->name('order.assign.requirements.show.form');
    Route::get('all-orders/{order}/requirements/edit', 'OrderController@requirementsEdit')->middleware('can:raw-materials-edit')->name('requirement.edit');
    Route::post('all-orders/{order}/requirements/edit', 'OrderController@requirementsUpdate')->middleware('can:raw-materials-edit')->name('requirement.update');
    Route::get('orders/assign-commercial/', 'OrderController@assingCommercialForm')->middleware('can:commercial-details-assign')->name('order.assign.commercial.show.form');
    Route::post('orders/assign-commercial/', 'OrderController@commercialStore')->name('assign.commercial.store');
    Route::get('all-orders/{order}/requirements/view', 'OrderController@viewRequirements')->name('order.requirements.view');
    Route::get('all-orders/{order}/show', 'OrderController@show')->name('order.show');
    Route::delete('all-orders/{order}/delete', 'OrderController@destroy')->name('order.destroy');
    Route::get('all-orders/{order}/commercial-assigned/print', 'OrderController@commercialAssignedPrint')->name('orders.commercial.assigned.print');
    Route::get('all-orders/commercial-assigned', 'OrderController@showCommercialAssignedOrders')->name('orders.commercial.assigned.get');
    Route::get('all-orders/{order}/commercial-assigned/edit', 'OrderController@editCommercial')->name('commercial.edit')->middleware('can:commercial-edit');
    Route::get('all-orders/{order}/commercial-assigned/view', 'OrderController@viewCommercial')->name('commercial.view')->middleware('can:commercial-view');
    Route::post('all-orders/{order}/commercial-assigned/edit', 'OrderController@updateCommercial')->name('commercial.update');
    Route::delete('all-orders/{order}/commercial-assigned/delete', 'OrderController@commercialDestroy')->name('commercial.destroy')->middleware('can:commercial-delete');
    Route::get('all-order/print-copy', 'OrderPrintController@index')->name('order.print.index');
    Route::get('all-order/print-copy/office-copy/{order}', 'OrderPrintController@officeCopy')->name('order.print.office');
    Route::get('all-order/print-copy/factory-copy/{order}', 'OrderPrintController@factoryCopy')->name('order.print.factory');
    Route::get('all-order/print-copy/dyeing-copy/{order}', 'OrderPrintController@dyeingCopy')->name('order.print.dyeing');
    Route::resource('item', 'ItemController');
    Route::get('all-items/get-item-details', 'OrderController@getItemDetails')->name('item.details');
    Route::get('all-accessory/get-accessory-unit', 'OrderController@getAccessoryUnitDetails')->name('raw.unit.get');
    Route::get('all-accessory/get-accessory-color', 'OrderController@getAccessoryColorDetails')->name('raw.colors.get');
    Route::get('order/get-garments', 'OrderController@getGarmentsInfo')->name('garments.get');





    //Dyeing Order Routes
    Route::get('dyeing/create', 'DyeingOrderController@create')->name('dyeing.order.create')->middleware('can:dyeing-assign');
    Route::get('dyeing/all-order', 'DyeingOrderController@index')->name('dyeing.order.index')->middleware('can:dyeing-view');
    Route::post('dyeing/create', 'DyeingOrderController@storeOrder')->name('dyeing.order.store');
    Route::get('get/all/accessories', 'DyeingOrderController@allAccessories')->name('accessories.get');
    Route::delete('dyeing/all-order/{order}/delete', 'DyeingOrderController@destroy')->name('dyeing.order.delete');
    Route::get('dyeing/all-order/{order}/challan', 'DyeingOrderController@challan')->name('dyeing.order.challan')->middleware('can:dyeing-delete');
    Route::get('dyeing/all-company/get', 'DyeingOrderController@getAllDyeingCompany')->name('dyeing.company.all');

    //Dyeing Receive
    Route::get('dyeing/receive/order-based', 'ReceiveDyeingYarnController@showReceiveForm')->name('dyeing.receive.form')->middleware('can:receive-dyeing-yarn');
    Route::post('dyeing/receive/order-based', 'ReceiveDyeingYarnController@receiveOrderBased')->name('yarn.receive.order.based');
    Route::get('dyeing/{order}/show', 'ReceiveDyeingYarnController@showReceived')->name('receive.material.show');
    Route::get('dyeing/all/get/index', 'ReceiveDyeingYarnController@index')->name('receive.dyeing.index')->middleware('can:receive-dyeing-yarn-all');
    Route::post('dyeing/receive', 'ReceiveDyeingYarnController@receive')->name('dyeing.order.receive');
    Route::get('color-search', 'ReceiveDyeingYarnController@searchColor')->name('colors.get');
    Route::get('/get/accessory', 'ReceiveDyeingYarnController@getAccessory')->name('accessory.get');

    //Accounts Routes
    Route::resource('accountPayable', 'AccountPayableController');
    Route::get('payment/{accountPayable}', 'AccountPayableController@payment')->name('payment');
    Route::post('payment/{accountPayable}', 'AccountPayableController@makePayment')->name('payment.make');
    Route::get('account/methods', 'AccountPayableController@getMethods')->name('account.methods');
    Route::get('vendors-all', 'AccountPayableController@getVendors')->name('vendors.get');
//    Route::resource('debitVoucher', 'DebitVoucherController');
//    Route::resource('creditVoucher', 'CreditVoucherController');
    Route::resource('accountSector', 'AccountSectorController');
    Route::resource('account', 'AccountController');
    Route::resource('paymentMethod', 'PaymentMethodController');
    Route::get('/debit/pay', 'DebitPaymentController@index')->name('payment.debit');

    // sample order routes
    Route::get('/sample/order/create', 'SampleController@createOrder')->name('sample.order.create')->middleware('can:sample-order-create');
    Route::post('/sample/order/create', 'SampleController@storeOrder');
    Route::get('/sample/order', 'SampleController@index')->name('sample.order.index');
    Route::delete('/sample/order/{order}/delete', 'SampleController@destroy')->name('sample.order.destroy')->middleware('can:sample-order-delete');
    Route::get('/sample/order/{order}/deliver', 'SampleController@deliver')->name('order.deliver')->middleware('can:sample-order-delivery');
    Route::post('/sample/order/{order}/deliver', 'SampleController@deliverOrder');
    Route::get('/sample/order/{order}/remarks-edit', 'SampleController@editRemarks')->name('order.remarks.edit')->middleware('can:sample-edit-remarks');
    Route::post('/sample/order/{order}/remarks-edit', 'SampleController@updateRemarks');
    Route::get('/sample/order/{order}/edit', 'SampleController@edit')->name('sample.order.edit')->middleware('can:sample-order-edit');
    Route::put('/sample/order/{order}/edit', 'SampleController@update')->name('sample.order.update');


    // Accessory Category Routes
    Route::resource('/accessory_category', 'AccessoryCategoryController');

    // Accessory CRUD Routes
    Route::resource('accessory', 'AccessoryController');

    //  Employee
    Route::resource('department','DepartmentController');
    Route::resource('designation','DesignationController');
    Route::resource('employee','EmployeeController');
    Route::get('employee/get-all/designations', 'EmployeeController@getDesignations')->name('designations.get');

    // Salary Allowance
    Route::resource('allowance','AllowanceController');

    // Production
    Route::get('production/create', 'ProductionController@create')->name('production.create');

    Route::post('production/create', 'ProductionController@store')->name('production.store')->middleware('can:add-production-record');
    Route::get('production/index', 'ProductionController@index')->name('production.index')->middleware('can:view-production');
    Route::delete('production/{production}/delete', 'ProductionController@destroy')->name('production.destroy')->middleware('can:production-record-delete');
    Route::get('production/delivery', 'DeliveryController@index')->name('delivery.index')->middleware('can:order-delivery');
    Route::get('production/{order}/delivery', 'DeliveryController@create')->name('delivery.create');
    Route::get('production/{order}/delivery/show', 'DeliveryController@show')->name('delivery.show');
    Route::post('production/{order}/delivery', 'DeliveryController@store')->name('delivery.store');
    Route::get('production/{production}', 'ProductionController@view')->name('production.show');
    Route::delete('delivery-item/{delivery}/delete', 'DeliveryController@destroy')->name('delivery.record.delete')->middleware('can:delivery-record-delete');

    Route::get('jobs/all/production', 'ProductionController@getJobs')->name('jobs.get');
    Route::delete('/production/{production}/delete', 'ProductionController@destroy')->name('production.destroy');



   Route::group(['prefix' => 'accounts', 'namespace' => 'Accounts', 'as' => 'accounts.'], function (){
       Route::resource('parties', 'PartyController')->only('store', 'index');

       Route::get('debit-vouchers/payment/{party?}', 'DebitVoucherController@payment')->name('debit-vouchers.payment')->middleware('can:debit-payment');
       Route::post('debit-vouchers/{voucher}/paid', 'DebitVoucherController@paid')->middleware('can:debit');
       Route::resource('debit-vouchers', 'DebitVoucherController')->except('edit', 'update');
       Route::get('debit-voucher-payments/{payment}/voucher', 'DebitVoucherController@paymentVoucher')->name('debit-voucher.payments.invoice')->middleware('can:debit');
       Route::get('debit-vouchers/payments/{voucher}/history', 'DebitVoucherController@paymentList')->name('debit-voucher.payments.history')->middleware('can:debit');
       Route::delete('debit-vouchers/payments/{payment}', 'DebitVoucherController@destroyPayment')->name('debit-voucher.payments.destroy')->middleware('can:fdsa');


       Route::get('credit-vouchers/payment/{party?}', 'CreditVoucherController@payment')->name('credit-vouchers.payment')->middleware('can:credit-payment');
       Route::post('credit-vouchers/{voucher}/paid', 'CreditVoucherController@paid')->middleware('can:credit');
       Route::resource('credit-vouchers', 'CreditVoucherController')->except('edit', 'update')->middleware('can:credit-voucher');
       Route::get('credit-voucher-payments/{payment}/voucher', 'CreditVoucherController@paymentVoucher')->name('credit-voucher.payments.invoice')->middleware('can:credit');
       Route::get('credit-vouchers/payments/{voucher}/history', 'CreditVoucherController@paymentList')->name('credit-voucher.payments.history')->middleware('can:credit');
       Route::delete('credit-vouchers/payments/{payment}', 'CreditVoucherController@destroyPayment')->name('credit-voucher.payments.destroy')->middleware('can:credit');

       Route::get('reports/income-expense', 'ReportController@incomeExpense')->name('report.income-expense')->middleware('can:income-expense');
       Route::get('reports/party', 'ReportController@partyReport')->name('report.party')->middleware('can:party-report');
       Route::get('reports/cash', 'ReportController@cashReport')->name('report.cash')->middleware('can:cash-report');
       Route::get('reports/party-bill', 'ReportController@partyReportV3')->name('report.party-bill');
   });

    Route::get('production/delivery/challan/{delivery}/', 'DeliveryController@challan')->name('delivery.challan');

    //PI routes
    Route::get('pi/create', 'PIController@create')->name('pi.create')->middleware('can:add-pi');
    Route::get('pi/index', 'PIController@index')->name('pi.index');
    Route::get('pi/index/get-total', 'PIController@getTotal')->name('pi.total.get');
    Route::delete('pi/{pi}/delete', 'PIController@destroy')->name('pi.destroy')->middleware('can:delete-pi');
    Route::post('pi/create', 'PIController@store');
    Route::get('pi/create/all-garments', 'PIController@garmentsGet')->name('garments.all');
    Route::get('pi/create/all-buyers', 'PIController@buyersGet')->name('buyers.all');
    Route::get('pi/create/all-merchants', 'PIController@merchantsGet')->name('merchants.all');
    Route::get('pi/create/all-items', 'PIController@itemsGet')->name('items.all');

    Route::get('lc/create', 'LcController@create')->name('lc.create')->middleware('can:add-lc');
    Route::get('lc/{lc}/view', 'LcController@view')->name('lc.view');
    Route::get('lc/{lc}/print', 'LcController@printLc')->name('lc.print');
    Route::get('lc/{lc}/edit', 'LcController@edit')->name('lc.edit');
    Route::put('lc/{lc}/edit', 'LcController@update')->name('lc.update');
    Route::delete('lc/{lc}/delete', 'LcController@destroy')->name('lc.destroy')->middleware('can:delete-lc');
    Route::get('lc/index', 'LcController@index')->name('lc.index');
    Route::post('lc/index/{lc}/mark-as-done', 'LcController@markAsDone')->name('lc.mark.as.done')->middleware('can:lc-status-change');
    Route::post('lc/index/{lc}/mark-as-pending', 'LcController@markAsPending')->name('lc.mark.as.pending')->middleware('can:lc-status-change');
    Route::post('lc/create', 'LcController@store')->name('lc.create');
    Route::get('pi/search-serial-number', 'LcController@search')->name('pi.get');
    Route::get('pi/{pi}/print', 'PIController@printPi')->name('pi.print');


    Route::resource('user', 'UserController');
    Route::get('profile', 'UserController@profile')->name('profile');
    Route::post('profile', 'UserController@profileUpdate');
    Route::post('/user/{admin}/change-password', 'UserController@changePassword')->name('password.change');
    Route::put('users/{user}/inactive', 'UserController@inactive')->name('user.inactive');
    Route::put('users/{user}/active', 'UserController@active')->name('user.active');
    Route::resource('role', 'RoleController');
    Route::get('role/{role}/set-permission', 'RoleController@permissionForm')->name('role.permission.set')->middleware('can:set-permission');
    Route::post('role/{role}/set-permission', 'RoleController@setPermission')->name('role.permission.set');


    Route::get('user/{admin}/change-pass', 'UserController@passwordForm')->name('user.password.change')->middleware('can:change-password');
    Route::post('user/{admin}/change-pass', 'UserController@changePass')->middleware('can:change-password');

    // salary routes
    Route::get('prepare-salary/new', 'PrepareSalaryController@prepare')->name('salary.prepare.show.form');
    Route::get('prepare-salary/get-all', 'PrepareSalaryController@getAll')->name('salary.sheet');
    Route::post('prepare-salary/get-all', 'PrepareSalaryController@salaryPayment')->name('salary.payment');
    Route::delete('prepare-salary/{salary}/delete', 'PrepareSalaryController@destroy')->name('salary.destroy');
    Route::post('prepare-salary/new', 'PrepareSalaryController@store')->name('salary.prepare.store');
    Route::get('employee/all/get', 'PrepareSalaryController@getEmployee')->name('employees.get');
    Route::get('salary/get-salary-sheet/all', 'PrepareSalaryController@getAllSalaryRecord')->name('salary.sheet.record');
    Route::delete('salary/get-salary-sheet/all/{salary}/delete', 'PrepareSalaryController@destroySalarySheet')->name('salary.sheet.destroy');
    Route::get('salary/get-salary-sheet/{salary}/view', 'PrepareSalaryController@viewSalaryRecord')->name('salary.record.view');
    Route::get('salary/get-salary/{detail}/payslip/get', 'PrepareSalaryController@payslip')->name('payslip');

    Route::resource('garments', 'GarmentsController');
    Route::get('garments/{garment}/inactive', 'GarmentsController@inactive')->name('garment.inactive');
    Route::resource('dyeing_companies', 'DyeingCompanyController');
    Route::get('dyeing_companies/{company}/inactive', 'DyeingCompanyController@inactive')->name('dyeing.inactive');
    Route::resource('buyers', 'BuyerController');
    Route::get('buyers/{buyer}/inactive', 'BuyerController@inactive')->name('buyer.inactive');
    Route::resource('merchants', 'MerchantController');
    Route::get('merchants/{merchant}/inactive', 'MerchantController@inactive')->name('merchant.inactive');
    Route::resource('vendors', 'VendorController');
    Route::get('vendors/{vendor}/change-status', 'VendorController@changeStatus')->name('vendor.change.status');
    Route::get('/db-backup', 'BackupController@backup')->name('backup')->middleware('can:backup-data');

});
