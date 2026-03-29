<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Facades\Excel;

class QuotationExport implements FromArray, WithStyles, ShouldAutoSize
{
    protected $quotation;

    public function __construct($quotation)
    {
        $this->quotation = $quotation;
    }

    public function array(): array
    {
        $data = [];

        // 🔹 Header
        $data[] = ['ใบเสนอราคา'];
        $data[] = ['เลขที่', $this->quotation->quotation_no ?? '-'];
        $data[] = [];

        // 🔹 Table Header
        $data[] = ['รายการ', 'จำนวน', 'ราคา', 'รวม'];

        // 🔹 Items
        $items = $this->quotation->items ?? [];

        if (!empty($items)) {
            foreach ($items as $item) {
                $qty = $item['qty'] ?? 0;
                $price = $item['price'] ?? 0;

                $data[] = [
                    $item['description'] ?? '',
                    $qty,
                    $price,
                    $qty * $price
                ];
            }
        } else {
            $data[] = ['ไม่มีรายการ', '', '', ''];
        }

        // 🔹 Total
        $data[] = [];
        $data[] = ['รวมทั้งหมด', '', '', $this->quotation->total ?? 0];

        return $data;
    }

    // 🎨 Style Excel
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 16]],
            4 => ['font' => ['bold' => true]],
        ];
    }
}
