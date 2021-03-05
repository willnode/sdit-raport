<?php

namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;

/**
 * @property int $nis
 * @property string $nisn
 * @property string $nama
 * @property string $kelas
 * @property string $password
 * @property string $tmp_lahir
 * @property string $tgl_lahir
 * @property string $tugas_akhir
 * @property int $thn_masuk
 */
class Siswa extends Entity
{
    protected $casts = [
        'nis' => 'integer',
        'thn_masuk' => 'integer',
    ];

    public function getKelasFull()
    {
        return get_kelas_nice_name($this);
    }

    public function getSemester()
    {
        return (floor(Services::config()->periode / 10) - $this->thn_masuk) * 2 + Services::config()->periode % 10;
    }
}
