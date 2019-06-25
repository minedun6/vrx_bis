<?php

namespace App\Helpers\Utilities;

class ChartUtility
{

    public static function groupByDay($data, $month, $year, $fancy = false)
    {
        $labels = [];
        $values = [];

        $month = $month ? $month : date('m');
        $year = $year ? $year : date('Y');

        $days = date('t', strtotime("$year-$month-01"));

        for ($i = 1; $i <= $days; $i++) {
            if ($i < 10) {
                $day = "0$i";
            } else {
                $day = "$i";
            }
            $date = "$year-$month-$day";

            $value = 0;

            foreach ($data as $v) {
                if (date('Y-m-d', strtotime($v->played_at)) == $date) {
                    $value += $v->price;
                } else {
                    $value += 0;
                }
            }

            $date_get = $fancy ? 'l M' : 'd';
            $label = date($date_get, strtotime("$year-$month-$day"));

            array_push($labels, $label);
            array_push($values, $value);
        }
        return [
            $labels,
            $values
        ];
    }

}