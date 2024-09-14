<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DynamicExport implements FromArray, WithStyles
{
    protected $data, $api_rows, $value_rows;

    public function __construct(array $data, array $api_rows, array $value_rows)
    {
        $this->data = $data;
        $this->api_rows = $api_rows;
        $this->value_rows = $value_rows;
    }
    public function array(): array
    {
        return $this->data;
    }


    public function styles(Worksheet $sheet)
    {
        $sheet->setTitle("ONF.MOS-IT.CL");
        $sheet->getParentOrThrow()->getDefaultStyle()->applyFromArray([
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FFF'], // Fondo rojo
            ],
        ]);
        $sheet->getColumnDimension('A')->setWidth(31);
        $sheet->getColumnDimension('B')->setWidth(3.14);
        $sheet->getColumnDimension('C')->setWidth(24);
        $sheet->getColumnDimension('D')->setWidth(21);
        $sheet->getColumnDimension('E')->setWidth(21);
        $sheet->getColumnDimension('F')->setWidth(21);
        $sheet->getColumnDimension('G')->setWidth(21);
        $sheet->getColumnDimension('H')->setWidth(21);
        $sheet->getColumnDimension('I')->setWidth(21);
        $sheet->getColumnDimension('J')->setWidth(21);
        $sheet->getColumnDimension('K')->setWidth(21);
        $sheet->getColumnDimension('L')->setWidth(21);
        $sheet->getColumnDimension('M')->setWidth(21);
        $sheet->getColumnDimension('N')->setWidth(21);

        $sheet->getRowDimension(1)->setRowHeight(33);

        $sheet->getStyle("A1:E1")->applyFromArray([
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'font' => [
                'bold' => true,
            ],
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FA7201'],
            ],
        ]);
        $sheet->getStyle("B2:E4")->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ]);
        foreach ($this->api_rows as $row) {
            $sheet->getStyle("A$row:N$row")->applyFromArray([
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ],
                'font' => [
                    'bold' => true,
                ],
                'borders' => [
                    'outline' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '00000000'],
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FA7201'],
                ],
            ]);
        }
        foreach ($this->value_rows as $row) {
            $sheet->getStyle("B$row:N$row")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => '00000000'],
                    ],
                ],
            ]);
        }
        $row = 5;
        $highestColumn = $sheet->getHighestColumn();
        $columns = range('A', $highestColumn);

        foreach ($columns as $column) {
            $cell = $column . $row;

            $validation = $sheet->getCell($cell)->getDataValidation();
            $validation->setType(DataValidation::TYPE_CUSTOM)
                ->setFormula1('COUNTIF($A$5:$' . $highestColumn . '$5, ' . $cell . ')=1')
                ->setShowErrorMessage(true)
                ->setErrorTitle('El Nombre del grupo debe ser único');
        }
    }
}
