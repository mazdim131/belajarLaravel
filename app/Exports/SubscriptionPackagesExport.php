<?php

namespace App\Exports;

use App\Models\SubscriptionPackage;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SubscriptionPackagesExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithCustomStartCell, WithEvents
{
    public function collection(): Collection
    {
        return SubscriptionPackage::all();
    }

    public function startCell(): string
    {
        return 'A2';
    }

    public function headings(): array
    {
        return [
            'No', 'Nama Paket Langganan', 'Harga', 'Jumlah Buku', 'Pelanggan Aktif',
        ];
    }

    private $no = 0;

    public function map($package): array
    {
        return [
            ++$this->no,
            $package->name,
            'Rp ' . number_format($package->prices, 0, ',', '.'),
            $package->SubscriptionPackageBook()->count(),
            $package->SubscriptionPackageUser()->where('expired_date', '>=', now()->toDateString())->count(),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $totalRows = $this->collection()->count() + 2;
        return [
            2 => [
                'font' => ['bold' => true],
            ],
            "A2:E{$totalRows}" => [
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->setCellValue('A1', 'Data Paket Langganan dengan Buku dan Pengguna');
                $sheet->mergeCells('A1:E1');
                $sheet->getStyle('A1')->getFont()->setSize(18);
            },
        ];
    }
}
