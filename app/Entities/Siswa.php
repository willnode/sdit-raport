<?php

namespace App\Entities;

use CodeIgniter\Entity;
use Config\Services;

/**
 * @property int $nis
 * @property string $nisn
 * @property string $nama
 * @property string $kelas
 * @property SiswaBiodata $biodata
 * @property int $angkatan
 */
class Siswa extends Entity
{
    protected $casts = [
        'nis' => 'integer',
        'angkatan' => 'integer',
        'biodata' => 'json',
    ];

    public function getKelasFull()
    {
        return get_kelas_nice_name($this);
    }

    public function getSemester()
    {
        return (floor(Services::config()->periode / 10) - $this->angkatan) * 2 + Services::config()->periode % 10;
    }
}

/**
 * @property string $tempat_lahir
 * @property string $tanggal_lahir
 * @property string $kelamin
 * @property string $agama
 * @property string $status_keluarga
 * @property string $anak_ke
 * @property string $alamat
 * @property string $asal_sekolah
 * @property string $nama_ayah
 * @property string $pekerjaan_ayah
 * @property string $nama_ibu
 * @property string $pekerjaan_ibu
 * @property string $nama_wali
 * @property string $pekerjaan_wali
 */
class SiswaBiodata
{
}