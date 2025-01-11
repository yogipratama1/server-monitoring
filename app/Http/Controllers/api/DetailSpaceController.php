<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use App\Models\SpaceDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class DetailSpaceController extends Controller
{
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'lokasi_id' => 'required|integer',
            'total_space' => 'required|string',
            'used_space' => 'required|string',
            'free_space' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }

        $lokasiId = $request->input('lokasi_id');

        // Cek apakah lokasi_id ada di tabel lokasi
        $lokasi = Location::find($lokasiId);
        if (!$lokasi) {
            return response()->json([
                'success' => false,
                'message' => 'Lokasi tidak ditemukan.',
            ], 404);
        }

        // Cek apakah lokasi_id sudah ada di tabel detail_penyimpanan
        $detailPenyimpanan = SpaceDetail::where('lokasi_id', $lokasiId)->first();

        if ($detailPenyimpanan) {
            // Update data jika lokasi_id sudah ada
            $currentTime = Carbon::defaultTimezone();
            $detailPenyimpanan->update([
                'total_space' => $request->input('total_space'),
                'used_space' => $request->input('used_space'),
                'free_space' => $request->input('free_space'),
                'updated_at'=> $currentTime
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diperbarui.',
                'data' => $detailPenyimpanan,
            ], 200);
        } else {
            // Insert data baru jika lokasi_id belum ada
            $newDetailPenyimpanan = SpaceDetail::create([
                'lokasi_id' => $lokasiId,
                'total_space' => $request->input('total_space'),
                'used_space' => $request->input('used_space'),
                'free_space' => $request->input('free_space'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan.',
                'data' => $newDetailPenyimpanan,
            ], 201);
        }
    }
}
