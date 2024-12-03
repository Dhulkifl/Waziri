<?php
// app/Helpers/JalaliHelper.php


namespace App\Helpers;

use Morilog\Jalali\Jalalian;

class JalaliHelper
    {
        private static $monthNames = [
            1 => 'فروردین',
            2 => 'اردیبهشت',
            3 => 'خرداد',
            4 => 'تیر',
            5 => 'مرداد',
            6 => 'شهریور',
            7 => 'مهر',
            8 => 'آبان',
            9 => 'آذر',
            10 => 'دی',
            11 => 'بهمن',
            12 => 'اسفند',
        ];

        // Custom month names
        private static $customMonthNames = [
            1 => 'حمل',
            2 => 'ثور',
            3 => 'جوزا',
            4 => 'سرطان',
            5 => 'اسد',
            6 => 'سنبله',
            7 => 'میزان',
            8 => 'عقرب',
            9 => 'قوس',
            10 => 'جدی',
            11 => 'دلو',
            12 => 'حوت',
        ];

        public static function getYear()
        {
            return Jalalian::now()->getYear();
        }

        public static function getMonthName()
        {
            $month = Jalalian::now()->getMonth();
            // Return custom month name
            return self::$customMonthNames[$month];
        }

        public static function getDays()
        {
            $days = [];
            for ($i = 1; $i <= Jalalian::now()->getMonthDays(); $i++) {
                $days[] = $i;
            }
            return $days;
        }
    }
?>