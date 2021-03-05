<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Services;

class MatkulModel extends Model
{
    protected $table         = 'matkul';
    protected $allowedFields = [
        'mkode', 'nama', 'sks', 'semester'
    ];
    protected $primaryKey = 'mkode';
    protected $returnType = 'App\Entities\Matkul';

    public function withAktif()
    {
        $b = $this->builder();
        $y = Services::config()->periode % 2; // is ganjil
        $b->where("MOD(semester, 2) = $y");
        //echo $b->getCompiledSelect(); exit;
        return $this;
        # code...
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
