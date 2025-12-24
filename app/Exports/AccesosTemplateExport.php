<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class AccesosTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    protected $plataforma;

    public function __construct($plataforma = 'ODOO')
    {
        $this->plataforma = $plataforma;
    }

    /**
     * @return array
     */
    public function array(): array
    {
        return [
            [$this->plataforma, 'https://ejemplo.com', 'usuario1@ejemplo.com', 'MiContraseña123'],
            [$this->plataforma, 'https://ejemplo.com', 'usuario2@ejemplo.com', 'OtraContraseña456'],
            [$this->plataforma, '', 'admin@ejemplo.com', 'AdminPass789'],
        ];
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'plataforma',
            'url',
            'user',
            'password',
        ];
    }

    /**
     * @return array
     */
    public function columnWidths(): array
    {
        return [
            'A' => 20,  // plataforma
            'B' => 40,  // url
            'C' => 30,  // user
            'D' => 25,  // password
        ];
    }

    /**
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5'], // Índigo
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ],
        ];
    }
}

