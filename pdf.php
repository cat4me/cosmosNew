<?php

require 'D:/OSPanel/vendor/autoload.php';
require_once 'databaseConnect.php';

class Pdf
{
    public function showPdf() {
        $query = new DB();
        $query->beginTransaction();
        try {
            $sql = "SELECT * FROM objects";
            $params = [];
            $result = $query->query($sql, $params);
            //
            $pdf = new TCPDF();
            $pdf->SetCreator('My Application');
            $pdf->SetAuthor('Me');
            $pdf->SetTitle('My PDF');
            $pdf->SetSubject('Table from MySQL');
            $pdf->SetKeywords('TCPDF, PDF, MySQL, table');
            $pdf->SetPrintHeader(false);
            $pdf->SetPrintFooter(false);
            $pdf->SetMargins(10, 10, 10);
            $pdf->SetAutoPageBreak(true, 10);
            $pdf->SetFont('times', '', 12);

            $pdf->AddPage();
            $pdf->SetFont('times', 'B', 14);
            $pdf->Cell(0, 10, 'Table from MySQL', 0, 1, 'C');
            $pdf->Ln();

            $header = array('id', 'parent_id', 'name', 'type');
            $pdf->SetFont('times', 'B', 12);
            foreach ($header as $col) {
                $pdf->Cell(40, 10, $col, 1, 0, 'C');
            }
            $pdf->Ln();

            $pdf->SetFont('times', '', 12);
            foreach ($result as $array) {
                foreach ($array as $value) {
                    $pdf->Cell(40, 10, $value, 1, 0, 'C');
                }
                $pdf->Ln();
            }

            $pdf->Output('objects.pdf', 'I');
            //
        } catch (\Exception $exception) {
            $query->rollBack();
            var_dump($exception->getMessage());
            die;
        }
    }
}