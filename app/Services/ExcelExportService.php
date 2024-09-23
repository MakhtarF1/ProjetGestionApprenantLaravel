<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelExportService
{
    public function generateExcelFile()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // En-têtes
        $sheet->setCellValue('A1', 'nom');
        $sheet->setCellValue('B1', 'prenom');
        $sheet->setCellValue('C1', 'adresse');
        $sheet->setCellValue('D1', 'telephone');
        $sheet->setCellValue('E1', 'email');
        $sheet->setCellValue('F1', 'photo');
        $sheet->setCellValue('G1', 'referentiel');
        $sheet->setCellValue('H1', 'date_naissance');
        $sheet->setCellValue('I1', 'sexe');

        // Données des apprenants
        $data = [
            ['Doe', 'John', '123 Rue Exemple', '123456789', 'john.doe@example.com', 'base64_photo_string', 'Informatique', '2000-01-01', 'M'],
            ['Smith', 'Jane', '456 Rue Exemple', '987654321', 'jane.smith@example.com', 'base64_photo_string', 'Gestion', '1999-05-15', 'F'],
            ['Johnson', 'Paul', '789 Rue Exemple', '111222333', 'paul.johnson@example.com', 'base64_photo_string', 'Science', '1998-10-12', 'M'],
            ['Brown', 'Emily', '321 Rue Exemple', '444555666', 'emily.brown@example.com', 'base64_photo_string', 'Informatique', '1997-08-25', 'F'],
            ['Taylor', 'Michael', '654 Rue Exemple', '777888999', 'michael.taylor@example.com', 'base64_photo_string', 'Gestion', '2001-12-01', 'M'],
            ['Anderson', 'Laura', '987 Rue Exemple', '000111222', 'laura.anderson@example.com', 'base64_photo_string', 'Science', '1995-07-04', 'F'],
            ['Thomas', 'David', '147 Rue Exemple', '333444555', 'david.thomas@example.com', 'base64_photo_string', 'Informatique', '1994-09-17', 'M'],
            ['Jackson', 'Emma', '258 Rue Exemple', '666777888', 'emma.jackson@example.com', 'base64_photo_string', 'Gestion', '1993-03-10', 'F'],
            ['White', 'Robert', '369 Rue Exemple', '999000111', 'robert.white@example.com', 'base64_photo_string', 'Science', '1992-11-30', 'M'],
            ['Harris', 'Sophia', '789 Rue Exemple', '222333444', 'sophia.harris@example.com', 'base64_photo_string', 'Informatique', '1991-06-21', 'F'],
        ];

        $row = 2; // Début des données
        foreach ($data as $apprenant) {
            $sheet->fromArray($apprenant, null, 'A' . $row++);
        }

        // Enregistrer le fichier
        $filePath = storage_path('app/apprenants.xlsx'); // Enregistrer dans le dossier de stockage
        $writer = new Xlsx($spreadsheet);
        $writer->save($filePath);

        return $filePath;
    }
}
