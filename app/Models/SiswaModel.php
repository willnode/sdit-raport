<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Services;

class SiswaModel extends Model
{
    protected $table         = 'siswa';
    protected $allowedFields = [
        'nis', 'nama', 'kelas', 'nisn', 'tugas_akhir', 'angkatan', 'password'
    ];
    protected $primaryKey = 'nis';
    protected $returnType = 'App\Entities\Siswa';

    public function withAktif()
    {
        $b = $this->builder();
        $y = Services::config()->tahun;
        $b->where('angkatan between ' . ($y - 2) . ' and ' . $y);
        return $this;
        # code...
    }
    public function withKelas($id)
    {
        if ($id) {
            $id = explode(',', $id);
            if ($id[0] ?? '') {
                $this->builder()->where('angkatan', $id[0]);
            }
            if ($id[1] ?? '') {
                $this->builder()->where('kelas', $id[1]);
            }
            $this->builder()->orderBy('angkatan, kelas');
        }
        return $this;
        # code...
    }
    public function allKelas()
    {
        $b = $this->builder();
        $b->select('kelas, angkatan, COUNT(nis) as jumlah');
        $b->groupBy('kelas, angkatan');
        $b->orderBy('angkatan, kelas');
        return $b->get()->getResult($this->returnType);
    }

    // public function processWeb($id)
    // {
    //     if ($id === null) {
    //         $item = (new Article($_POST));
    //         $item->user_id = Services::login()->id;
    //         return $this->insert($item);
    //     } else if ($item = $this->find($id)) {
    //         /** @var Article $item */
    //         $item->fill($_POST);
    //         if ($item->hasChanged()) {
    //             $this->save($item);
    //         }
    //         return $id;
    //     }
    //     return false;
    // }
}
