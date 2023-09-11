<?php

require 'D:/OSPanel/vendor/autoload.php';
require_once 'databaseConnect.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Excel
{
    public function showExcel()
    {
        $query = new DB();
        $query->beginTransaction();
        try {
            $sql = "SELECT * FROM objects";
            $params = [];
            $result = $query->query($sql, $params);
            var_dump($result);
            $spreadsheet = new Spreadsheet();
            $worksheet = $spreadsheet->getActiveSheet();

            $row = 1;
            foreach ($result as $array) {
                $col = 1;
                foreach ($array as $value) {
                    $worksheet->setCellValueByColumnAndRow($col, $row, $value);
                    $col++;
                }
                $row++;
            }
            $writer = new Xlsx($spreadsheet);
            $writer->save('objects.xlsx');
        } catch (\Exception $exception) {
            $query->rollBack();
            var_dump($exception->getMessage());
            die;
        }
    }
}