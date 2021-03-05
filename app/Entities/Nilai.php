<?php

namespace App\Entities;

use App\Libraries\NilaiProcessor;
use App\Models\MatkulModel;
use App\Models\SiswaModel;
use CodeIgniter\Entity;

/**
 * @property int $id
 * @property int $nis
 * @property Siswa $siswa
 * @property Matkul $matkul
 * @property int $mkode
 * @property int $nilai
 */
class Nilai extends Entity
{
    protected $casts = [
        'id' => 'integer',
        'nis' => 'integer',
        'nilai' => 'integer',
        'mkode' => 'integer',
    ];

    public function getSiswa()
    {
        return (new SiswaModel())->find($this->nis);
    }

    public function getMatkul()
    {
        return (new MatkulModel())->find($this->mkode);
    }

    public function getAbjad()
    {
        return NilaiProcessor::toAbjad($this->nilai);
    }
}
