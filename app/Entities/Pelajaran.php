<?php

namespace App\Entities;

use CodeIgniter\Entity;

/**
 * @property int $mkode
 * @property string $nama
 * @property string $sifat
 * @property int $kkm
 */
class Pelajaran extends Entity
{
    protected $casts = [
        'mkode' => 'integer',
        'kkm' => 'integer',
    ];
}
