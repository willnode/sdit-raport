<?php

namespace App\Entities;

use CodeIgniter\Entity;

/**
 * @property int $id
 * @property int $periode
 * @property int $tahun
 */
class Config extends Entity
{
    protected $casts = [
        'id' => 'integer',
        'periode' => 'integer',
    ];

    public function getTahun()
    {
        return floor($this->periode / 10);
    }

    public function getPeriodeFull()
    {
        return $this->tahun . '-' . ($this->tahun + 1) . ($this->periode % 2 == 1 ? ' Ganjil' : ' Genap');
    }
}
