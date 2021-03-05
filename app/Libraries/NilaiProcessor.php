<?php

namespace App\Libraries;

use App\Entities\Matkul;
use App\Entities\Nilai;
use App\Entities\Siswa;
use App\Models\MatkulModel;
use App\Models\NilaiModel;
use App\Models\SiswaModel;
use CodeIgniter\Files\File;
use CodeIgniter\HTTP\Files\UploadedFile;
use Config\Database;
use Config\Services;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class NilaiProcessor
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
            // ['Kode Matkul', 'Nama Matkul', 'NIS', 'Nama', 'Nilai']
            $data = $excel->getSheet(0)->toArray();
            $excel->disconnectWorksheets();
            $excel->garbageCollect();

            $db = Database::connect();
            $db->transBegin();
            $table = $db->table('nilai');
            $periode = Services::config()->periode;
            $count = 0;
            foreach ($data as $i => $row) {
                if ($i == 0) continue;
                $table->update([
                    'nilai' => $row[4] ?? null ?: null,
                ], [
                    'mkode' => $row[0],
                    'nis' => $row[2],
                    'periode' => $periode,
                ]);
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

    /** @param Nilai[] $data */
    public function export($data): Xlsx
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        /* header */
        foreach (['Kode Matkul', 'Nama Matkul', 'NIS', 'Nama', 'Nilai'] as $key => $value) {
            $sheet->getCellByColumnAndRow($key + 1, 1)->setValue($value);
            $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($key + 1)->setAutoSize(true);
        }
        foreach ($data as $i => $nilai) {
            $sheet->getCellByColumnAndRow(1, $i + 2)->setValue($nilai->mkode);
            $sheet->getCellByColumnAndRow(2, $i + 2)->setValue($nilai->nama_matkul);
            $sheet->getCellByColumnAndRow(3, $i + 2)->setValue($nilai->nis);
            $sheet->getCellByColumnAndRow(4, $i + 2)->setValue($nilai->nama_siswa);
            $sheet->getCellByColumnAndRow(5, $i + 2)->setValue($nilai->nilai);
        }

        return new Xlsx($spreadsheet);
    }

    public function exportLeger($kelas, $matkul, $siswa, $nilai)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        /* header */
        foreach (['No', 'NIS', 'Nama', 'Kelas'] as $key => $value) {
            $sheet->getCellByColumnAndRow($key + 1, 1)->setValue($value);
            $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($key + 1)->setAutoSize(true);
        }
        foreach ($matkul as $key => $m) {
            $sheet->getCellByColumnAndRow($key + 1 + 4, 1)->setValue($m->nama);
            $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($key + 1 + 4)->setAutoSize(true);
        }
        $sheet->getCellByColumnAndRow($key + 1 + 4 + count($matkul), 1)->setValue('NA');
        $spreadsheet->getActiveSheet()->getColumnDimensionByColumn($key + 1 + 4 + count($matkul))->setAutoSize(true);

        foreach ($siswa as $i => $s) {
            $sheet->getCellByColumnAndRow(1, $i + 2)->setValue($i + 1);
            $sheet->getCellByColumnAndRow(2, $i + 2)->setValue($s->nis);
            $sheet->getCellByColumnAndRow(3, $i + 2)->setValue($s->nama);
            $sheet->getCellByColumnAndRow(4, $i + 2)->setValue($s->kelasFull);
            foreach ($matkul as $im => $m) {
                $sheet->getCellByColumnAndRow(5 + $im, $i + 2)->setValue($nilai[$s->nis][$m->mkode] ?? '');
            }
        }

        return new Xlsx($spreadsheet);
    }

    public function synchronize()
    {
        $periode = Services::config()->periode;
        $tahun = Services::config()->tahun;
        /** @var Siswa[] $siswa */
        $siswa = (new SiswaModel)->withAktif()->findAll();
        /** @var Matkul[] $matkul */
        $matkul = (new MatkulModel)->withAktif()->findAll();
        $db = Database::connect();
        $t = $db->table('nilai');
        $data = [];
        foreach ($siswa as $s) {
            foreach ($matkul as $m) {
                if (floor(($m->semester - 1) / 2) == ($tahun - $s->thn_masuk)) {
                    $data[] = [
                        'nis' => $s->nis,
                        'mkode' => $m->mkode,
                        'nilai' => null,
                        'periode' => $periode,
                    ];
                }
            }
        }
        $t->ignore()->insertBatch($data);
        return $db->affectedRows();
    }

    public static function toAbjad($n)
    {
        if ($n == 0)
            return '-';
        else if ($n >= 80)
            return 'A';
        else if ($n >= 75)
            return 'AB';
        else if ($n >= 70)
            return 'B';
        else if ($n >= 65)
            return 'BC';
        else if ($n >= 60)
            return 'C';
        else if ($n >= 50)
            return 'D';
        else
            return 'E';
    }

    /** @param Nilai[] $data */
    public static function aggregate(array $data)
    {
        /** @var NilaiAgregasi $n */
        $n = (object)[
            'semester' => [],
            'ipk' => 0,
            'sum' => 0,
            'sks' => 0,
            'abjad' => '-',
        ];
        foreach ($data as $d) {
            if (!isset($n->semester[$d->semester])) {
                $n->semester[$d->semester] = (object)[
                    'nilai' => [],
                    'ips' => 0,
                    'sum' => 0,
                    'sks' => 0,
                    'abjad' => '-',
                ];
            }
            $n->semester[$d->semester]->nilai[] = $d;
        }
        foreach ($n->semester as &$v) {
            foreach ($v->nilai as $vv) {
                $v->sum += $vv->nilai;
                $v->sks += $vv->sks ?? $vv->matkul->sks;
            }
            $v->ips = $v->sum / $v->sks;
            $v->abjad = static::toAbjad($v->ips);
            $n->sum += $v->sum;
            $n->sks += $v->sks;
        }
        $n->ips = $n->sum / $n->sks;
        $n->abjad = static::toAbjad($n->ips);
        return $n;
    }
}

/**
 * @property NilaiSemester[] $semester
 * @property float $ipk
 * @property float $sum
 * @property int $sks
 * @property string $abjad
 */
class NilaiAgregasi
{
}

/**
 * @property Nilai[] $nilai
 * @property float $ips
 * @property float $sum
 * @property int $sks
 * @property string $abjad
 */
class NilaiSemester
{
}
