<?php

namespace App\Http\Controllers\API;

use App\Models\Rekening;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Validator;

class TransaksiController extends BaseController
{
    public function addBuyTransaction(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'no_rekening' => 'required',
            'jumlah_transaksi' => 'required',
            'rekening_tujuan' => 'required',


        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $rekening = Rekening::where('no_rekening', $request['no_rekening'])->get();
        if ($rekening->isEmpty()) {
            return $this->sendError('No Rekening Tidak Valid.', ['error' => 'No Rekening Tidak Valid.']);
        }

        $rekening_tujuan = Rekening::where('no_rekening', $request['rekening_tujuan'])->get();
        if ($rekening_tujuan->isEmpty()) {
            return $this->sendError('No Rekening Tujuan Tidak Valid.', ['error' => 'No Rekening Tujuan Tidak Valid.']);
        }

        $rekening = $rekening->first();
        $rekening_tujuan = $rekening_tujuan->first();

        if ($rekening['saldo'] < $request['jumlah_transaksi']) {
            return $this->sendError('Saldo Kurang.', ['error' => 'Saldo Kurang.']);
        }



        $input = [
            "id_rekening" => $rekening['id_rekening'],
            "rekening_tujuan" => $rekening_tujuan['id_rekening'],
            "jumlah_transaksi" => $request['jumlah_transaksi'],
            "jenis_transaksi" => "Pembelian",
        ];

        $transaksi = Transaksi::create($input);

        if ($transaksi) {
            $rekening['saldo'] = $rekening['saldo'] - $request['jumlah_transaksi'];
            $rekening_tujuan['saldo'] = $rekening_tujuan['saldo'] + $request['jumlah_transaksi'];
            $rekening->save();
            $rekening_tujuan->save();
        } else {
            return $this->sendError('Transaksi Gagal', ['error' => 'Transaksi Gagal']);
        }

        return $this->sendResponse("Transaksi Sukses.", 'Transaksi Sukses.');
    }


    public function destroy($id)
    {
        $id_transaksi = Transaksi::findOrFail($id);


        $id_transaksi->delete();
    }
}
