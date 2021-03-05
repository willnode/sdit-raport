<?php

namespace App\Libraries;

use App\Entities\Matkul;
use CodeIgniter\HTTP\Files\UploadedFile;
use Config\Database;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class MatkulProcessor
{
    public function import(UploadedFile $file)
    {
        try {
            if (!$file || !$file->isValid()) {
                throw new Exception("File is missing");
            }
            if (!($excel = IOFactory::load($file->getRealPath()))) {
                throw new Exception("Can't read data");
            }
            // ['Kode', 'Nama', 'SKS', 'Semester']
            $data = $excel->getSheet(0)->toArray();
            $excel->disconnectWorksheets();
            $excel->garbageCollect();

            $db = Database::connect();
            $db->transBegin();
            $table = $db->table('matkul');
            $count = 0;
            foreach ($data as $i => $row) {
                if ($i == 0) continue;
                if (!$table->ignore()->insert([
                    'mkode' => $row[0],
                    'nama' => $row[1],
                    'sks' => $row[2],
                    'semester' => $row[3],
                ])) {
                    throw new Exception('Insert Fail');
                } else if (!$db->affectedRows()) {
                    $table->update([
                        'nama' => $row[1],
                        'sks' => $row[2],
                        'semester' => $row[3],
                    ], [
                        'mkode' => $row[0],
                    ]);
                }
                $count += $db->affectedRows();
            }
            $db->transComplete();
            return $count;
        } catch (\Throwable $th) {
            echo $th->getMessage();
            echo '<br> gagal saat memproses: '.json_encode($row ?? []);
            exit;
        } finally {
            unlink($file->getRealPath());
        }
    }

    /** @param Matkul[] $data */
    public function export($data): Xlsx
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        /* header */
        foreach (['Kode', 'Nama', 'SKS', 'Semester'] as $key => $value) {
            $sheet->getCellByColumnAndRow($key + 1, 1)->setValue($value);
            $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($key + 1)->setAutoSize(true);
        }
        foreach ($data as $i => $matkul) {
            $sheet->getCellByColumnAndRow(1, $i + 2)->setValue($matkul->mkode);
            $sheet->getCellByColumnAndRow(2, $i + 2)->setValue($matkul->nama);
            $sheet->getCellByColumnAndRow(3, $i + 2)->setValue($matkul->sks);
            $sheet->getCellByColumnAndRow(4, $i + 2)->setValue($matkul->semester);
        }

        return new Xlsx($spreadsheet);
    }

}
