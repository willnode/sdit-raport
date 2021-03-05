<?php

namespace App\Libraries;

use App\Entities\Siswa;
use CodeIgniter\HTTP\Files\UploadedFile;
use Config\Database;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class SiswaProcessor
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
            // ['NIS', 'Nama', 'Kelas', 'Tahun Masuk', 'Tugas Akhir']
            $data = $excel->getSheet(0)->toArray();
            $excel->disconnectWorksheets();
            $excel->garbageCollect();

            $db = Database::connect();
            $db->transBegin();
            $table = $db->table('siswa');
            $count = 0;
            foreach ($data as $i => $row) {
                if ($i == 0) continue;
                if (!$table->ignore()->insert([
                    'nis' => $row[0],
                    'nisn' => $row[1],
                    'nama' => $row[2],
                    'kelas' => $row[3],
                    'thn_masuk' => $row[4],
                    //'tugas_akhir' => $row[5] ?? null ?: null,
                ])) {
                    throw new Exception('Insert Fail');
                } else if (!$db->affectedRows()) {
                    $table->update([
                        'nisn' => $row[1],
                        'nama' => $row[2],
                        'kelas' => $row[3],
                        'thn_masuk' => $row[4],
                        //'tugas_akhir' => $row[5] ?? null ?: null,
                    ], [
                        'nis' => $row[0],
                    ]);
                }
                $count += $db->affectedRows();
            }
            $db->transComplete();
            return $count;
        } catch (\Throwable $th) {
            echo $th->getMessage();
            echo '<br> gagal saat memproses: ' . json_encode($row ?? []);
            exit;
        } finally {
            unlink($file->getRealPath());
        }
    }

    /** @param Siswa[] $data */
    public function export($data): Xlsx
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        /* header */
        foreach (['NIS', 'NISN', 'Nama', 'Kelas', 'Tahun Masuk', 'Tugas Akhir'] as $key => $value) {
            $sheet->getCellByColumnAndRow($key + 1, 1)->setValue($value);
            $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($key + 1)->setAutoSize(true);
        }
        foreach ($data as $i => $Siswa) {
            $sheet->getCellByColumnAndRow(1, $i + 2)->setValue($Siswa->nis);
            $sheet->getCellByColumnAndRow(2, $i + 2)->setValue($Siswa->nisn);
            $sheet->getCellByColumnAndRow(3, $i + 2)->setValue($Siswa->nama);
            $sheet->getCellByColumnAndRow(4, $i + 2)->setValue($Siswa->kelas);
            $sheet->getCellByColumnAndRow(5, $i + 2)->setValue($Siswa->thn_masuk);
            $sheet->getCellByColumnAndRow(6, $i + 2)->setValue($Siswa->tugas_akhir);
        }

        return new Xlsx($spreadsheet);
    }
}
