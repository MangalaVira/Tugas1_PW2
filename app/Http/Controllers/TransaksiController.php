<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $transaksi = Transaksi::all();
        return response()->json($transaksi, 200);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_transaksi' => 'required|string|max:50',
            'tipe_transaksi' => 'required|in:pemasukan,pengeluaran',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        $data['user_id'] = $request->user()->id;
        $transaksi = Transaksi::create($data);

        if ($transaksi) {
            $data['success'] = true;
            $data['message'] = "Data Transaksi Berhasil Disimpan";
            $data['data'] = $transaksi;
            return response()->json($data, 201);
        }
    }

    public function show($id, Request $request)
    {
        $transaksi = Transaksi::where('id', $id)
                              ->where('user_id', $request->user()->id)
                              ->firstOrFail();
        return response()->json($transaksi, 200);
    }

    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::where('id', $id)
                              ->where('user_id', $request->user()->id)
                              ->firstOrFail();

        $data = $request->validate([
            'nama_transaksi' => 'nullable|string|max:50',
            'tipe_transaksi' => 'nullable|in:pemasukan,pengeluaran',
            'jumlah' => 'nullable|numeric',
            'tanggal' => 'nullable|date',
            'keterangan' => 'nullable|string'
        ]);

        $transaksi->update($data);

        return response()->json([
            'success' => true,
            'message' => "Data Transaksi Berhasil Diperbarui",
            'data' => $transaksi
        ], 200);
    }

    public function destroy($id, Request $request)
    {
        $transaksi = Transaksi::where('id', $id)
                              ->where('user_id', $request->user()->id)
                              ->firstOrFail();

        $transaksi->delete();

        return response()->json(['message' => 'Transaksi berhasil dihapus'], 200);
    }
}
