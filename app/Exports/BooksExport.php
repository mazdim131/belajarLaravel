<?php

namespace App\Exports;

use App\Models\Book;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BooksExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    public function collection(): Collection
    {
        return Book::with('category')->get();
    }

    public function headings(): array
    {
        return [
            'No', 'Alamat Gambar Sampul Buku', 'Nama Kategori Buku', 'Judul Buku',
            'Penulis', 'Penerbit', 'Tanggal Rilis', 'Jumlah Halaman', 'Bahasa', 'Harga',
        ];
    }

    private $no = 0;

    public function map($book): array
    {
        return [
            ++$this->no,
            $book->cover,
            $book->category?->name ?? '-',
            $book->title,
            $book->writer,
            $book->publisher,
            date('d-m-Y', strtotime($book->release_data)),
            $book->page_of_book,
            $book->languange,
            'Rp ' . number_format($book->price, 0, ',', '.'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        $totalRows = $this->collection()->count() + 1;

        return [
            1 => [
                'font' => ['bold' => true],
            ],
            "A1:J{$totalRows}" => [
                'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]],
            ],
        ];
    }
}
