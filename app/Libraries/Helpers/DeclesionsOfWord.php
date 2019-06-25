<?php

namespace App\Libraries\Helpers;


class DeclesionsOfWord
{

    /**
     * Функция склонения числительных в русском языке
     *
     * @param int    $number Число которое нужно просклонять
     * @param array  $titles Массив слов для склонения для 1, 2, 5
     * @return string
     **/
    public static function make($number, $titles)
    {
        $cases = array (2, 0, 1, 1, 1, 2);

        return $titles[ ($number%100 > 4 && $number %100 < 20) ? 2 : $cases[min($number%10, 5)] ];
    }
}