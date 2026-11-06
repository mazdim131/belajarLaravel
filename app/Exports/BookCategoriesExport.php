<?php

namespace App\Exports;

use App\Models\BookCategory;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Border;

class BookCategoriesExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection(): Collection
    {
        return BookCategory::withCount('books')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Kategori',
            'Jumlah Buku'
        ];
    }

    private $no = 0;

    public function map($bookCategory): array
    {
        return [
            ++$this->no,
            $bookCategory->name,
            $bookCategory->books_count // properti bawaan otomatis fungsi with count
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $totalRows = $this->collection()->count() + 1;

        return [
            // Bold pada Header (Baris 1)
            1 => ['font' => ['bold' => true]],

            // Border pada seluruh rentang sel A1 sampai C{totalRows}
            "A1:C{$totalRows}" => [
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ]
            ]
        ];
    }
}
