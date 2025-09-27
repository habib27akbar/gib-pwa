<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use DateTime;

class TanggalHelper
{
    function get_tanggal($tanggal)
    {
        $explode = explode("-", $tanggal);
        if ($explode[1] == '01') {
            $get_date = $explode[2] . ' Januari ' . $explode[0];
        } else if ($explode[1] == '02') {
            $get_date = $explode[2] . ' Februari ' . $explode[0];
        } else if ($explode[1] == '03') {
            $get_date = $explode[2] . ' Maret ' . $explode[0];
        } else if ($explode[1] == '04') {
            $get_date = $explode[2] . ' April ' . $explode[0];
        } else if ($explode[1] == '05') {
            $get_date = $explode[2] . ' Mei ' . $explode[0];
        } else if ($explode[1] == '06') {
            $get_date = $explode[2] . ' Juni ' . $explode[0];
        } else if ($explode[1] == '07') {
            $get_date = $explode[2] . ' Juli ' . $explode[0];
        } else if ($explode[1] == '08') {
            $get_date = $explode[2] . ' Agustus ' . $explode[0];
        } else if ($explode[1] == '09') {
            $get_date = $explode[2] . ' September ' . $explode[0];
        } else if ($explode[1] == '10') {
            $get_date = $explode[2] . ' Oktober ' . $explode[0];
        } else if ($explode[1] == '11') {
            $get_date = $explode[2] . ' November ' . $explode[0];
        } else if ($explode[1] == '12') {
            $get_date = $explode[2] . ' Desember ' . $explode[0];
        }

        return $get_date;
    }

    function get_dd_mm_yyyy($tanggal)
    {
        $explode = explode("-", $tanggal);
        $get_date = $explode[2] . '/' . $explode[1] . '/' . substr($explode[0], 2, 2);

        return $get_date;

        //return $get_date;
    }

    public function get_day_name($tanggal)
    {
        $days = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $date = new DateTime($tanggal);
        $dayName = $date->format('l'); // Get the day name in English

        return isset($days[$dayName]) ? $days[$dayName] : null;
    }

    function get_date_time($tanggal)
    {
        $ex = explode(" ", $tanggal);
        $explode = explode("-", $ex[0]);
        $get_date = $explode[2] . '/' . $explode[1] . '/' . $explode[0] . ' ' . substr($ex[1], 0, 5);

        return $get_date;
    }
}
