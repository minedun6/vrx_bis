<?php

namespace App\Http\Controllers\Backend\Customer;

use App\DataTables\CustomerDataTable;
use App\Models\Customer\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index(CustomerDataTable $dataTable)
    {
        return $dataTable->render('backend.customers.index');
    }

    public function create()
    {
        return view('backend.customers.create');
    }

    public function store(Request $request)
    {
        $customer = Customer::create($request->all());
        return redirect()->route('admin.customer.index')
            ->withFlashSuccess('<i class="fa fa-check-circle-o"></i> Le client a été crée avec Succès.');
    }

}
