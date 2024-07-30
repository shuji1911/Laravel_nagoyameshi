<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $company = Company::first();
        return view('dashboard.companies.index', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(Company $company) {
        return view('dashboard.companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Company $company) {
        $request->validate([
            'name' => 'required',
            'representative' => 'required',
            'establishment_year' => 'required|digits:4',
            'establishment_month' => 'required|numeric|between:1,12',
            'establishment_day' => 'required|numeric|between:1,31',
            'postal_code1' => 'required|digits:3',
            'postal_code2' => 'required|digits:4',
            'address' => 'required',
            'business' => 'required',
        ]);

        $company->name = $request->input('name');
        $company->representative = $request->input('representative');
        $company->establishment_date = $request->input('establishment_year') . '-' . $request->input('establishment_month') . '-' . $request->input('establishment_day');
        $company->postal_code = $request->input('postal_code1') . $request->input('postal_code2');
        $company->address = $request->input('address');
        $company->business = $request->input('business');
        $company->save();

        return redirect()->route('dashboard.companies.index', $company)->with('flash_message', '会社情報を編集しました。');
    }
}
