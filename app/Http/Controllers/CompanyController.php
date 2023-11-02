<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Http\Requests\StoreCompanyRequest;
use App\Http\Requests\UpdateCompanyRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $companies = Company::all();
        return response()->json(['Companies' => $companies], 200);
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
    public function store(StoreCompanyRequest $request)
    {
        $data = $request->validated();
        $path = $this->storeLogo($request);
        Company::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'logo' => $path,
            'website' => $data['website'],
        ]);
        return response()->json(['message' => 'Company created successfully']);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Company not found', 'url' => '/404'], 404);
        }
        return response()->json(['company' => $company]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCompanyRequest $request, $id)
    {
        $validatedData = $request->validated();
        $path = $this->storeLogo($request);
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Company not found', 'url' => '/404'], 404);
        }
        $company->update([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'website' => $validatedData['website'],
            'logo' => $path,
        ]);
        return response()->json(['message' => 'Company updated successfully']);
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $company = Company::find($id);
        if (!$company) {
            return response()->json(['message' => 'Company not found', 'url' => '/404'], 404);
        }

        $company->delete();
        return response()->json(['message' => 'Company deleted successfully']);
    }

    private function storeLogo(Request $request)
    {
        $pathToRemove = url('/');
        $path = str_replace($pathToRemove.'/', '', $request->logo);

        if ($request->hasFile('logo')) {
            $logoFile = $request->file('logo');
            $logoFileName = uniqid('logo_') . '.' . $logoFile->getClientOriginalExtension();
            $logoFile->storeAs('public', $logoFileName);
            $path = 'storage/' . $logoFileName;
        }

        return $path;
    }
}