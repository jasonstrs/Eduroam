
<?php
require '..\vendor\autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function exportSpectaclesToExcel($tab){
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Hello World !');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('C:\helloWorld.xlsx');
}


?>