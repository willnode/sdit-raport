<?php

namespace App\Libraries;

class PelajaranProcessor extends BaseExcelProcessor
{

    public $table = 'pelajaran';

    public $columns = [
        [
            'key' => 'mkode',
            'title' => 'ID',
        ], [
            'key' => 'nama',
            'title' => 'Nama Pelajaran',
        ], [
            'key' => 'sifat',
            'title' => 'Sifat Pelajaran',
        ], [
            'key' => 'kkm',
            'title' => 'KKM',
        ]
    ];
}