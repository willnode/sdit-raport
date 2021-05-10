<?php

namespace App\Libraries;

class SiswaProcessor extends BaseExcelProcessor
{
    public $table = 'siswa';

    public $columns = [
        [
            'key' => 'nis',
            'title' => 'NIS',
        ], [
            'key' => 'nama',
            'title' => 'Nama Siswa',
        ], [
            'key' => 'kelas',
            'title' => 'Kelas',
        ], [
            'key' => 'angkatan',
            'title' => 'Angkatan',
        ], [
            'key' => 'nisn',
            'title' => 'NISN',
        ], [
            'key' => 'tempat_lahir',
            'title' => 'Tempat Lahir',
        ], [
            'key' => 'tanggal_lahir',
            'title' => 'Tanggal Lahir',
        ], [
            'key' => 'kelamin',
            'title' => 'Kelamin',
        ], [
            'key' => 'agama',
            'title' => 'Agama',
        ], [
            'key' => 'status_keluarga',
            'title' => 'Status Keluarga',
        ], [
            'key' => 'anak_ke',
            'title' => 'Anak Ke',
        ], [
            'key' => 'alamat',
            'title' => 'Alamat',
        ], [
            'key' => 'asal_sekolah',
            'title' => 'Asal Sekolah',
        ], [
            'key' => 'nama_ayah',
            'title' => 'Nama Ayah',
        ], [
            'key' => 'pekerjaan_ayah',
            'title' => 'Pekerjaan Ayah',
        ], [
            'key' => 'nama_ibu',
            'title' => 'Nama Ibu',
        ], [
            'key' => 'pekerjaan_ibu',
            'title' => 'Pekerjaan Ibu',
        ], [
            'key' => 'nama_wali',
            'title' => 'Nama Wali',
        ], [
            'key' => 'pekerjaan_wali',
            'title' => 'Pekerjaan Wali',
        ]
    ];

    public function __construct()
    {
        $this->importModifier = function ($value) {
            return [
                'nis' => $value['nis'],
                'nama' => $value['nama'],
                'kelas' => $value['kelas'],
                'angkatan' => $value['angkatan'],
                'biodata' => json_encode([
                    'nisn' => $value['nisn'],
                    'tempat_lahir' => $value['tempat_lahir'],
                    'tanggal_lahir' => $value['tanggal_lahir'],
                    'kelamin' => $value['kelamin'],
                    'agama' => $value['agama'],
                    'status_keluarga' => $value['status_keluarga'],
                    'anak_ke' => $value['anak_ke'],
                    'alamat' => $value['alamat'],
                    'asal_sekolah' => $value['asal_sekolah'],
                    'nama_ayah' => $value['nama_ayah'],
                    'pekerjaan_ayah' => $value['pekerjaan_ayah'],
                    'nama_ibu' => $value['nama_ibu'],
                    'pekerjaan_ibu' => $value['pekerjaan_ibu'],
                    'nama_wali' => $value['nama_wali'],
                    'pekerjaan_wali' => $value['pekerjaan_wali'],
                ])
            ];
        };
        $this->exportModifier = function ($value)
        {
            $biodata = json_decode($value->biodata ?: '[]');
            return [
                'nis' => $value->nis,
                'nama' => $value->nama,
                'kelas' => $value->kelas,
                'angkatan' => $value->angkatan,
                'nisn' => $biodata->nisn,
                'tempat_lahir' => $biodata->tempat_lahir,
                'tanggal_lahir' => $biodata->tanggal_lahir,
                'kelamin' => $biodata->kelamin,
                'kelamin' => $biodata->agama,
                'status_keluarga' => $biodata->status_keluarga,
                'anak_ke' => $biodata->anak_ke,
                'alamat' => $biodata->alamat,
                'asal_sekolah' => $biodata->asal_sekolah,
                'nama_ayah' => $biodata->nama_ayah,
                'pekerjaan_ayah' => $biodata->pekerjaan_ayah,
                'nama_ibu' => $biodata->nama_ibu,
                'pekerjaan_ibu' => $biodata->pekerjaan_ibu,
                'nama_wali' => $biodata->nama_wali,
                'pekerjaan_wali' => $biodata->pekerjaan_wali,
            ];
        };
    }
}
