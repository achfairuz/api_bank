<?php

namespace App\Http\Controllers\API;

use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

use function PHPUnit\Framework\isEmpty;

class NasabahController extends BaseController
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
        $validator = Validator::make($request->all(), [
            'nama_lengkap'    => 'required',
            'alamat'          => 'required',
            'nomor_telepon'   => 'required',
            'email'           => 'required|email',
            'tanggal_lahir'   => 'required',
            'jenis_kelamin'   => 'required',
            'nama_ibu'        => 'required',
        ]);

        // Cek apakah user sudah login
        $user = Auth::user();
        if (!$user) {
            return $this->sendError('401', 'Silahkan login terlebih dahulu.');
        }

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        // Cek apakah user sudah punya data nasabah
        $nasabah = Nasabah::where('user_id', $user->id)->first();
        if ($nasabah) {
            return $this->sendError('Validation Error.', 'Anda sudah mempunyai data nasabah.');
        }

        // Simpan data nasabah
        $input = [
            'user_id'        => $user->id,
            'nama_lengkap'   => $request->nama_lengkap,
            'alamat'         => $request->alamat,
            'nomor_telepon'  => $request->nomor_telepon,
            'email'          => $request->email,
            'tanggal_lahir'  => $request->tanggal_lahir,
            'jenis_kelamin'  => $request->jenis_kelamin,
            'nama_ibu'       => $request->nama_ibu,
        ];

        Nasabah::create($input);

        return $this->sendResponse('success', 'Data berhasil ditambahkan');
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
    public function show(string $id)
    {
        $nasabah = Nasabah::where("id_nasabah", $id)->get();
        if ($nasabah->isNotEmpty()) {
            return $this->sendResponse($nasabah, 'Nasabah retrieved successfully.');
        }
        return $this->sendError('Data Not Exist.', ['error' => 'Not Exist']);
    }

    public function showAll()
    {
        $nasabah = Nasabah::all();
        return $this->sendResponse($nasabah, 'Nasabah retrieved successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // $request->validate([
        //     'nama_lengkap' => 'required',
        //     'alamat' => 'required',
        //     'nomor_telepon' => 'required',
        //     'email' => 'required|email',
        //     'tanggal_lahir' => 'required',
        //     'jenis_kelamin' => 'required',
        //     'nama_ibu' => 'required',


        // ]);

        $nasabah = Nasabah::find($request->id);

        if ($nasabah == null) {
            return $this->sendError('404', 'Not Found');
        }

        $nasabah->update($request->all());

        return $this->sendResponse('success', 'Data Berhasil di Perbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $nasabah = Nasabah::find($id);

        if ($nasabah == null) {
            return $this->sendError('404', 'Not Found');
        }

        $nasabah->delete($id);

        return $this->sendResponse('success', 'Data berhasil didelete');
    }
}
