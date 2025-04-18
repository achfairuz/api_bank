<?php

namespace App\Http\Controllers\API;

use App\Models\Rekening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Validator;


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
    public function create(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'no_rekening' => 'required',
                'saldo' => 'required',
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('Validation error', $validator->errors());
        }

        // cek user 
        $user = Auth::user()->nasabah;

        if ($user == null) {
            return $this->sendError('404', 'Buat data nasabah terlebih dahulu');
        }

        $data =  Rekening::create(
            [
                'id_nasabah' => $user->id_nasabah,
                'no_rekening' => Crypt::encryptString($request->no_rekening),
                'saldo' => $request->saldo,
            ]
        );


        return $this->sendResponse($data, 'Rekening berhasil dibuat');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }


    public function showByAuthId()
    {
        // Cek user login
        $user = Auth::user();

        if ($user == null) {
            return $this->sendError('401', 'Silahkan login terlebih dahulu');
        }

        // Cek apakah user punya data nasabah
        if ($user->nasabah == null) {
            return $this->sendError('404', 'Silahkan buat nasabah terlebih dahulu');
        }

        // Ambil data rekening berdasarkan ID nasabah
        $rekenings = Rekening::where("id_nasabah", $user->nasabah->id_nasabah)
            ->with('nasabah')
            ->get();

        // Cek apakah rekening ditemukan
        if (!$rekenings) {
            return $this->sendError('404', 'Data rekening tidak ditemukan');
        }

        foreach ($rekenings as $rekening) {
            try {
                $rekening->no_rekening = Crypt::decryptString($rekening->no_rekening);
            } catch (\Exception $e) {
                $rekening->no_rekening = 'ERROR DEKRIPSI';
            }
        }


        return $this->sendResponse($rekenings, "Data Sukses Diambil");
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
