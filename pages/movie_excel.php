<?php

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();


$sql = "SELECT m.*, GROUP_CONCAT(g.nama_genre) as genre
        FROM movie_genre as mg 
        JOIN movie as m on m.id_movie=mg.id_movie 
        JOIN genre as g on g.id_genre=mg.id_genre 
        WHERE mg.deleted_at IS null 
        GROUP BY id_movie";

$result = mysqli_query($koneksi, $sql);

$sheet->setCellValue('A1', 'No.');
$sheet->setCellValue('B1', 'Judul Movie');
$sheet->setCellValue('C1', 'Tahun');
$sheet->setCellValue('D1', 'Deskripsi');

$no = 0;
$baris = 2;
while($row = mysqli_fetch_assoc($result))
{
    $sheet->setCellValue('A'.$baris, $no);
    $sheet->setCellValue('B'.$baris, $row['judul_movie']);
    $sheet->setCellValue('C'.$baris, $row['tahun']);
    $sheet->setCellValue('D'.$baris, $row['deskripsi']);

    $baris++;
}

$writer = new Xlsx($spreadsheet);
// $writer->save('movie.xlsx');

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="movie.xlsx"');
$writer->save('php://output');