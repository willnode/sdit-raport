<?php

namespace App\Entities;

use CodeIgniter\Entity;
use Config\Database;

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

    private static ?Config $cache = null;

    public static function get()
    {
        if (static::$cache)
            return static::$cache;
        $d = Database::connect()->table('config')->get()->getResult();
        $c = new Config();
        foreach ($d as $r) {
            $c->attributes[$r->key] = $r->value;
        }
        $c->original = $c->attributes;
        return static::$cache = $c;
    }

    public function save()
    {
        $table = Database::connect()->table('config');
        foreach ($this->toArray(true) as $key => $value) {
            $table->replace(['key' => $key, 'value' => $value]);
        }
    }
}
