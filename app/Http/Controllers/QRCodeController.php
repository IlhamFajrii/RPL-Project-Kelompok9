<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Peminjaman;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Response;

class QRCodeController extends Controller
{
    public function generateAlatQR(Alat $alat)
    {
        $qrCode = QrCode::create('alat_' . $alat->id . '_' . $alat->kode_alat)
            ->setWriter(new PngWriter())
            ->setSize(300)
            ->setMargin(10);

        $result = $qrCode->render();

        // Store in database as base64
        $alat->update([
            'qr_code' => base64_encode($result),
        ]);

        return response($result, 200, [
            'Content-Type' => 'image/png',
        ]);
    }

    public function showAlatQR(Alat $alat)
    {
        return view('qr.alat', compact('alat'));
    }

    public function scanIn(Peminjaman $peminjaman)
    {
        if ($peminjaman->status_approval !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman belum disetujui',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'QR Code terbaca',
            'data' => $peminjaman,
        ]);
    }

    public function scanOut(Peminjaman $peminjaman)
    {
        if ($peminjaman->status_approval !== 'approved') {
            return response()->json([
                'success' => false,
                'message' => 'Peminjaman tidak valid',
            ], 400);
        }

        return response()->json([
            'success' => true,
            'message' => 'QR Code terbaca untuk pengembalian',
            'data' => $peminjaman,
        ]);
    }
}
