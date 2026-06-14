<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class PeminjamanExport implements FromCollection, WithHeadings, WithStyles
{
    protected $peminjaman;

    public function __construct($peminjaman)
    {
        $this->peminjaman = $peminjaman;
    }

    public function collection(): Collection
    {
        return $this->peminjaman->map(function ($item) {
            return [
                $item->id,
                $item->user->name,
                $item->user->email,
                $item->alat->nama_alat,
                $item->tanggal_pinjam->format('d-m-Y H:i'),
                $item->tanggal_rencana_kembali->format('d-m-Y'),
                $item->tanggal_kembali ? $item->tanggal_kembali->format('d-m-Y') : '-',
                $item->status_approval,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID Peminjaman',
            'Nama Peminjam',
            'Email',
            'Nama Alat',
            'Tanggal Pinjam',
            'Rencana Kembali',
            'Tanggal Kembali',
            'Status',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
