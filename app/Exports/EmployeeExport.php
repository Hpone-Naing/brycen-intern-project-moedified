<?php

namespace App\Exports;

use App\Models\Employee;
use App\Traits\ConstantKeys;
use App\Traits\MakeEmployee;
use Illuminate\Http\Request;
use App\Interfaces\EmployeeInterface;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class EmployeeExport implements FromCollection, WithTitle, WithStyles, ShouldAutoSize, WithHeadings, WithEvents
{
    use ConstantKeys;
    use MakeEmployee;
    protected $request, $employeeInterface;

    function __construct(Request $request, EmployeeInterface $employeeInterface) {
        $this->request = $request;
        $this->employeeInterface = $employeeInterface;
    }

     /**
     * Set heading
     * @author HponeNaingTun
     * @create 23/06/2023
     */
    private $headings = [
        'ID',
        'Employee Id', 
        'Name',
        'NRC',
        'Phone',
        'Email',
        'Gender',
        'Date of Birth',
        'Address',
        'Language',
        'Career Part',
        'Level',
    ];

     /**
     * Excel download
     * @author HponeNaingTun
     * @create 23/06/2023
     * @return Array
     */
    public function collection()
    {   
        $employeeList = $this->employeeInterface->getAllEmployees($this->request);
        $employees = $this->makeEmployees($employeeList);
        return $employees;//$this->employeeInterface->getAllEmployees($this->request);
    }

    /**
     * Set Sheet Name
     * @author HponeNaingTun
     * @create 23/06/2023
     * @return String
     */
    public function title(): string
    {
        return 'Employee';
    } 

    /**
     * Set Sheet Heading
     * @author HponeNaingTun
     * @create 23/06/2023
     * @return String
     */
    public function headings() : array
    {
        return $this->headings;	
    } 

     /**
     * Set Sheet Name
     * @author HponeNaingTun
     * @create 23/06/2023
     */
    public function styles(Worksheet $sheet)
    {
        
        return [
        ];
    }

     /**
     * Set style of sheets
     * @author HponeNaingTun
     * @create 23/06/2023
     * @return Sheet
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $event->sheet->getDefaultColumnDimension()->setWidth(25);
                $event->sheet->getDefaultRowDimension()->setRowHeight(30);
                $event->sheet->getStyle($event->sheet->calculateWorksheetDimension())->applyFromArray([
                    'font' => [
                        'size' => 14,
                    ],
                ]);
                // Set the color of title headings
                $event->sheet->getStyle('A1:L1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'CCCCFF'],
                    ],
                    'fill' => [
                        'fillType' => Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '6495ED'],
                    ],
                ]);
            },
        ];

    }
}
