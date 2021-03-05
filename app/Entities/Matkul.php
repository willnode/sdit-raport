<?php

namespace App\Entities;

use CodeIgniter\Entity;

/**
 * @property int $mkode
 * @property string $nama
 * @property int $sks
 * @property int $semester
 */
class Matkul extends Entity
{
    protected $casts = [
        'mkode' => 'integer',
        'sks' => 'integer',
        'semester' => 'integer',
    ];
}
