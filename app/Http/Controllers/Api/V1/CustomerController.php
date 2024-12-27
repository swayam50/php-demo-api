<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\V2\CustomersFilter;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Http\Requests\V1\StoreCustomerRequest;
use App\Http\Requests\V1\UpdateCustomerRequest;
use App\Http\Resources\V1\CustomerCollection;
use App\Http\Resources\V1\CustomerResource;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // return Customer::all();
        // return new CustomerCollection(Customer::all());
        // return new CustomerCollection(Customer::paginate());

        $filter = new CustomersFilter();
        $filterQueryItems = $filter->transform($request); //[['column', 'operator', 'value']]

        $includeInvoicesQuery = $request->query(('includeInvoices'));
        $customers = Customer::where($filterQueryItems);

        if ($includeInvoicesQuery)
            $customers = $customers->with('invoices');

        return new CustomerCollection($customers->paginate()->appends($request->query()));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource(Customer::create($request->all()));
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        // return $customer;

        $includeInvoicesQuery = request()->query(('includeInvoices'));

        if ($includeInvoicesQuery)
            return new CustomerResource($customer->loadMissing('invoices'));

        return new CustomerResource($customer);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $customer->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        //
    }
}
