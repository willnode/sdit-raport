<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Services;

class SiswaModel extends Model
{
    protected $table         = 'siswa';
    protected $allowedFields = [
        'nis', 'nama', 'kelas', 'nisn', 'tugas_akhir', 'thn_masuk', 'password'
    ];
    protected $primaryKey = 'nis';
    protected $returnType = 'App\Entities\Siswa';

    public function withAktif()
    {
        $b = $this->builder();
        $y = Services::config()->tahun;
        $b->where('thn_masuk between ' . ($y - 2) . ' and ' . $y);
        return $this;
        # code...
    }
    public function withKelas($id)
    {
        if ($id) {
            $id = explode(',', $id);
            if ($id[0] ?? '') {
                $this->builder()->where('thn_masuk', $id[0]);
            }
            if ($id[1] ?? '') {
                $this->builder()->where('kelas', $id[1]);
            }
            $this->builder()->orderBy('thn_masuk, kelas');
        }
        return $this;
        # code...
    }
    public function allKelas()
    {
        $b = $this->builder();
        $b->select('kelas, thn_masuk, COUNT(nis) as jumlah');
        $b->groupBy('kelas, thn_masuk');
        $b->orderBy('thn_masuk, kelas');
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
