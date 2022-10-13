<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiscountRequest;
use App\Models\Discount;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.discount.index', [
            'discounts' => Discount::latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.discount.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DiscountRequest $discountRequest)
    {
        $validatedData = $discountRequest->validated();
        $discount = Discount::create($validatedData);

        Alert::success('Success', 'Success Add Discount ' . $discount->name);

        return to_route('admin.discount.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        return view('admin.discount.edit', [
            'discount' => $discount
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(DiscountRequest $discountRequest, Discount $discount)
    {
        $validatedData = $discountRequest->validated();
        $discount->update($validatedData);

        Alert::success('Success', 'Success Update Discount ' . $discount->name);

        return to_route('admin.discount.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        Alert::success('Success', 'Success Delete Discount ' . $discount->name);

        return to_route('admin.discount.index');
    }
}
