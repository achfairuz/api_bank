<?php

namespace App\Http\Controllers\API;

use App\Models\Rekening;
use Illuminate\Http\Request;

class rekeningController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $no_rekening)
    {
        $rekening = Rekening::where("no_rekening", $no_rekening)->with("nasabah")->get();
        if ($rekening->isNotEmpty()) {
            return $this->sendResponse($rekening->first(), "Nasabah retrieved successfully.");
        }


        return $this->sendError('Data Not Exist.', ['error' => 'Not Exist']);
    }


    public function showAll()
    {
        $rekening = Rekening::with("nasabah")->get();

        return $this->sendResponse($rekening, 'Nasabah retrieved successfully.');
    }
    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
