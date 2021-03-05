<?php

use App\Models\MatkulModel;
use CodeIgniter\Entity;
use CodeIgniter\HTTP\Files\UploadedFile;
use Config\Services;

/**
 * The goal of this file is to allow developers a location
 * where they can overwrite core procedural functions and
 * replace them with their own. This file is loaded during
 * the bootstrap process and is called during the frameworks
 * execution.
 *
 * This can be looked at as a `master helper` file that is
 * loaded early on, and may also contain additional functions
 * that you'd like to use throughout your entire application
 *
 * @link: https://codeigniter4.github.io/CodeIgniter4/
 */

function find_with_filter(\CodeIgniter\Model $model, int $length = 500)
{
    $req = Services::request();
    $page = intval($req->getGet('page'));
    $size = intval($req->getGet('size'));
    $offset = intval($req->getGet('offset'));
    if ($size === 0) $size = $length;
    else if ($size < 0) $size = 0;
    if ($offset === 0)
        $offset = max(0, $page - 1) * $size;
    // if ($offset > 0)
    $c = $model->countAllResults(false);
    // getting the C makes this easier to reverse
    $o = $c - ($offset + 1) - ($c % $size);
    $r = $model->findAll($size + min(0, $o), max(0, $o));
    $r = array_reverse($r);
    // generate pagination
    $_SERVER['pagination'] = [
        'page' => ($size == 0 ? 0 : floor($offset / $size)) + 1,
        'max' => isset($c) ? ceil($c / $size) : ceil((count($r) + 1) / $size),
        'certain' => isset($c),
    ];
    return $r;
}

function get_gravatar($email, $s = 80, $d = 'mp', $r = 'g')
{
    $url = 'https://www.gravatar.com/avatar/';
    $url .= md5(strtolower(trim($email)));
    $url .= "?s=$s&d=$d&r=$r";
    return $url;
}

function get_excerpt($content, $length = 40, $more = '...')
{
    $excerpt = strip_tags(trim($content));
    $words = str_word_count($excerpt, 2);
    if (count($words) > $length) {
        $words = array_slice($words, 0, $length, true);
        end($words);
        $position = key($words) + strlen(current($words));
        $excerpt = substr($excerpt, 0, $position) . $more;
    }
    return $excerpt;
}

/**
 * @param string|null $file
 */
function post_file(Entity $entity, $name, string $folder = null)
{
    if (!is_dir($path  = WRITEPATH . implode(DIRECTORY_SEPARATOR, ['uploads', $folder ?? $name, '']))) {
        mkdir($path, 0775, true);
    }
    $req = Services::request();
    $file = $req->getFile($name);
    if ($file && $file->isValid() && $file->move($path)) {
        if ($entity->{$name} && is_file($path . $entity->{$name})) {
            unlink($path . $entity->{$name});
        }
        $entity->{$name} = $file->getName();
    } else if ($req->getPost('_' . $name) === 'delete') {
        if ($entity->{$name} && is_file($path . $entity->{$name})) {
            unlink($path . $entity->{$name});
        }
        $entity->{$name} = null;
    }
}

function set_excel_header($filename)
{
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header("Content-Disposition: attachment;filename=" . rawurlencode(date('Ymd') . '-' . $filename) . ".xlsx");
}
function get_kelas_nice_name($x)
{
    if (is_string($x)) {
        $x = explode(',', $x);
        return get_kelas_nice_name((object)[
            'thn_masuk' => $x[0] ?? 0,
            'kelas' => $x[1] ?? 0,
        ]);
    }
    $k = '';
    switch (Services::config()->tahun - $x->thn_masuk) {
        case 0:
            $k = 'X ';
            break;
        case 1:
            $k = 'XI ';
            break;
        case 2:
            $k = 'XII ';
            break;
        default:
            $k = 'Alumni '.$x->thn_masuk.' ';
            break;
    }
    switch ($x->kelas[0] ?? '') {
        case 'A':
            $k .= 'MIA ';
            break;
        case 'B':
            $k .= 'IIB ';
            break;
        case 'K':
            $k .= 'IIK ';
            break;
        case 'S':
            $k .= 'IIS ';
            break;
        case 'P':
            $k .= 'MAPK ';
            break;
    }
    $k .= $x->kelas[1] ?? '';
    return $k;
}

function get_kelas_matkul_nice_name($x)
{
    $x = explode(',', $x);
    return get_kelas_nice_name((object)[
        'thn_masuk' => $x[0] ?? '',
        'kelas' => $x[1] ?? '',
    ]) . '-' . ((new MatkulModel)->find($x[2] ?? '')->nama ?? '');
}
