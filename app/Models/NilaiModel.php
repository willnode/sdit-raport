<?php

namespace App\Models;

use App\Entities\Nilai;
use CodeIgniter\Model;

class NilaiModel extends Model
{
    protected $table         = 'nilai';
    protected $allowedFields = [
        'nis', 'mkode', 'nilai'
    ];
    protected $primaryKey = 'id';
    protected $returnType = 'App\Entities\Nilai';

    public function where($filter)
    {
        $this->builder()->where($filter);
        return $this;
    }

    /** @return int[][] */
    public function asLeger()
    {
        /** @var Nilai[] $data */
        $data = $this->findAll();
        $result = [];
        foreach ($data as $d) {
            $result[$d->nis][$d->mkode] = $d->nilai;
        }
        return $result;
    }

    public function withSiswa($nis)
    {
        $b = $this->builder();
        $this->builder()->where('nis', $nis);
        $b->select('matkul.mkode, matkul.nama as nama_matkul, nilai, sks, semester');
        $b->join('matkul', 'matkul.mkode = nilai.mkode');
        return $this;
    }

    public function withKelasMatkul($id)
    {
        $b = $this->builder();
        if ($id) {
            $id = explode(',', $id);
            if ($id[0] ?? '') {
                $this->builder()->where('thn_masuk', $id[0]);
            }
            if ($id[1] ?? '') {
                $this->builder()->where('kelas', $id[1]);
            }
            if ($id[2] ?? '') {
                $this->builder()->where('matkul.mkode', $id[2]);
            }
        }
        $b->select('kelas, thn_masuk, siswa.nis, matkul.mkode, matkul.nama as nama_matkul, siswa.nama as nama_siswa, nilai');
        $b->join('matkul', 'matkul.mkode = nilai.mkode');
        $b->join('siswa', 'siswa.nis = nilai.nis');
        return $this;
    }
    public function allKelasMatkul()
    {
        $b = $this->builder();
        $b->select('kelas, thn_masuk, matkul.mkode, matkul.nama as nama_matkul, COUNT(1) as total, COUNT(nilai) as terisi');
        $b->join('matkul', 'matkul.mkode = nilai.mkode');
        $b->join('siswa', 'siswa.nis = nilai.nis');
        $b->groupBy('kelas, thn_masuk, periode, mkode');
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
