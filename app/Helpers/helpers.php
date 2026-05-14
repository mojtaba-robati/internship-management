<?php

if (!function_exists('jalali_date')) {
    function jalali_date($date)
    {
        if (!$date) return '-';
        
        $timestamp = strtotime($date);
        $year = date('Y', $timestamp);
        $month = date('m', $timestamp);
        $day = date('d', $timestamp);
        
        // محاسبه سال و ماه شمسی
        if ($month >= 3 && $month <= 12) {
            $jy = $year - 621;
            $jm = $month - 3;
        } else {
            $jy = $year - 622;
            $jm = $month + 9;
        }
        
        return $jy . '/' . str_pad($jm, 2, '0', STR_PAD_LEFT) . '/' . str_pad($day, 2, '0', STR_PAD_LEFT);
    }
}