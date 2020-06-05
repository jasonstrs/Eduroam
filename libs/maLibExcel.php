
<?php
require '..\vendor\autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function exportSpectaclesToExcel($tab){
    /* $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->setCellValue('A1', 'Hello World !');
    
    $writer = new Xlsx($spreadsheet);
    $writer->save('C:\helloWorld.xlsx'); */


    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

    $spreadsheet->getProperties()
    ->setCreator("Site Web Greg Tabibian")
    ->setLastModifiedBy("Site Web Greg Tabibian")
    ->setTitle("Résumé des spectacles")
    ->setSubject("Résumé des spectacles")
    ->setDescription("Résumé des spectacles");

    $i=0;
    $spreadsheet->removeSheetByIndex(0);
    foreach($tab as $cat){
        // Create a new worksheet called "My Data"
        $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $cat["descTab"]);

        // Attach the "My Data" worksheet as the first worksheet in the Spreadsheet object
        $spreadsheet->addSheet($myWorkSheet, $i);

        $dates = $cat["dates"];
        $thead = array("ID Spectacle","Ville","Intitulé","ID Date","Date","Lien Site de vente","Nombre d'Inscrits");
        $spreadsheet->setActiveSheetIndex($i++);

        $spreadsheet->getActiveSheet()->fromArray($thead,null,"A1");

        $tabComplet = array();
        foreach($dates as $date){
            $ligne = array( $date["idSpectacle"],
                            $date["ville"],
                            $date["description"],
                            $date["idDate"],
                            $date["dateSpectacle"],
                            $date["lien"],
                            $date["nbInscrits"]
            );

            array_push($tabComplet,$ligne);

        }

        $spreadsheet->getActiveSheet()->fromArray($tabComplet,null,"A2");
    }

    $writer = new Xlsx($spreadsheet);
    
    chdir("..");
    chdir("ressources");
    chdir("ExcelExports");
    
    $spreadsheet->setActiveSheetIndex(0);
    $nom = "ResumeSpectacle".date("dmYHms").".xlsx";
    $path = getcwd()."\\$nom";
    $writer->save($path);

    return array("ressources/ExcelExports/$nom",getcwd()."\\$nom");

}


?>