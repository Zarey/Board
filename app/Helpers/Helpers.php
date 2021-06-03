<?php

namespace app\Helpers;

class Helpers
{
    public static function url_translit($value)
    {
        $value = mb_strtolower($value);
        $value = trim($value);
        $value = strtr($value, ['ъе'=>'ye','ый'=>'iy','ий'=>'iy',' '=>'_']);
        $value = strtr($value, [
            'ае'=>'aye',
            'ое'=>'oye',
            'уе'=>'uye',
            'эе'=>'eye',
            'ые'=>'iye',
            'яе'=>'yaye',
            'ёе'=>'yoye',
            'юе'=>'yuye',
            'ее'=>'eye',
            'ие'=>'iye'
        ]);
        $value = strtr($value, [
            'а'=>'a',
            'б'=>'b',
            'в'=>'v',
            'г'=>'g',
            'д'=>'d',
            'е'=>'e',
            'ё'=>'yo',
            'ж'=>'zh',
            'з'=>'z',
            'и'=>'i',
            'й'=>'y',
            'к'=>'k',
            'л'=>'l',
            'м'=>'m',
            'н'=>'n',
            'о'=>'o',
            'п'=>'p',
            'р'=>'r',
            'с'=>'s',
            'т'=>'t',
            'у'=>'u',
            'ф'=>'f',
            'х'=>'kh',
            'ц'=>'ts',
            'ч'=>'ch',
            'ш'=>'sh',
            'щ'=>'sch',
            'ъ'=>'',
            'ы'=>'y',
            'ь'=>'',
            'э'=>'e',
            'ю'=>'yu',
            'я'=>'ya',
        ]);
        $value = mb_ereg_replace('[^-0-9a-z]', '_', $value);
        $value = preg_replace("/\s+/", '_', $value);
        return $value;
    }
}