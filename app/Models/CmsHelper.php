<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

class CmsHelper
{
    use HasFactory;

    // ==============================
    // แปลงวันที่เป็นภาษาไทย
    // ==============================
    public static function DateThai($strDate)
    {
        if (empty($strDate) || $strDate === '0000-00-00') {
            return [
                "dmY" => '-',
                "dmy" => '-',
                "dMY" => '-',
                "dMYt" => '-',
                "dmYHi" => '-',
                "dMYHi" => '-',
                "dMYHin" => '-',
                "Hi" => '-',
                "Date" => '-',
                "d" => '-',
                "m" => '-',
                "M" => '-',
                "Y" => '-',
            ];
        }

        try {
            $date = Carbon::parse($strDate);
        } catch (\Exception $e) {
            return ['dmY' => '-'];
        }

        $year = $date->year + 543;
        $yearShort = substr($year, -2);

        $month = $date->month;
        $day = $date->day;

        $hour = $date->format('H');
        $minute = $date->format('i');

        $monthShort = [
            "", "ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.",
            "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."
        ];

        $monthFull = [
            "", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน",
            "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"
        ];

        return [
            "dmY" => "$day {$monthShort[$month]} $year",
            "dmy" => "$day {$monthShort[$month]} $yearShort",
            "dMY" => "$day {$monthFull[$month]} $year",
            "dMYt" => "$day เดือน {$monthFull[$month]} พ.ศ. $year",
            "dmYHi" => "$day {$monthShort[$month]} $year เวลา $hour:$minute",
            "dMYHi" => "$day {$monthFull[$month]} $year เวลา $hour:$minute",
            "dMYHin" => "$day {$monthFull[$month]} $year เวลา $hour:$minute น.",
            "Hi" => "$hour:$minute",
            "Date" => $date->format('Y-m-d'),
            "d" => $day,
            "m" => $monthShort[$month],
            "M" => $monthFull[$month],
            "Y" => $year,
        ];
    }

    // ==============================
    // เดือนเป็นภาษาไทย
    // ==============================
    public static function MonthThai($val)
    {
        $arr = [
            1 => 'มกราคม',
            2 => 'กุมภาพันธ์',
            3 => 'มีนาคม',
            4 => 'เมษายน',
            5 => 'พฤษภาคม',
            6 => 'มิถุนายน',
            7 => 'กรกฎาคม',
            8 => 'สิงหาคม',
            9 => 'กันยายน',
            10 => 'ตุลาคม',
            11 => 'พฤศจิกายน',
            12 => 'ธันวาคม',
        ];

        return $arr[(int)$val] ?? null;
    }

    // ==============================
    // แปลง format วันที่
    // ==============================
    public static function DateChangeFormat($val)
    {
        if (empty($val)) return false;

        try {
            [$day, $month, $year] = explode("/", $val);
            $year = (int)$year - 543;

            return [
                'dash' => sprintf('%04d-%02d-%02d', $year, $month, $day),
                'slash' => sprintf('%02d/%02d/%04d', $day, $month, $year),
            ];
        } catch (\Exception $e) {
            return false;
        }
    }

    // ==============================
    // เดือนภาษาไทย -> เลข
    // ==============================
    public static function Date_Month2Num($val)
    {
        if (empty($val)) return false;

        $months = [
            'มกราคม' => '01',
            'กุมภาพันธ์' => '02',
            'มีนาคม' => '03',
            'เมษายน' => '04',
            'พฤษภาคม' => '05',
            'มิถุนายน' => '06',
            'กรกฎาคม' => '07',
            'สิงหาคม' => '08',
            'กันยายน' => '09',
            'ตุลาคม' => '10',
            'พฤศจิกายน' => '11',
            'ธันวาคม' => '12',
        ];

        try {
            [$day, $monthName, $year] = explode(" ", $val);
            $month = $months[$monthName] ?? '01';
            $year = (int)$year - 543;

            return "$year-$month-$day";
        } catch (\Exception $e) {
            return false;
        }
    }

    // ==============================
    // เลขไทย
    // ==============================
    public static function Numth($val)
    {
        return strtr($val, [
            "0" => "๐", "1" => "๑", "2" => "๒", "3" => "๓", "4" => "๔",
            "5" => "๕", "6" => "๖", "7" => "๗", "8" => "๘", "9" => "๙"
        ]);
    }

    // ==============================
    // format text เช่น บัตรประชาชน / เบอร์โทร
    // ==============================
    public static function TextFormat($text = '', $pattern = '', $separator = '-')
    {
        if (empty($text)) return '';

        $pattern = $pattern ?: '_-____-_____-__-_';
        $blocks = explode('-', $pattern);

        $result = [];
        $offset = 0;

        foreach ($blocks as $block) {
            $length = strlen($block);
            $result[] = substr($text, $offset, $length);
            $offset += $length;
        }

        return implode($separator, $result);
    }

    // companies_id => ชื่อบริษัท
    public static function CompanyName($id)
    {
        $company = Company::find($id);
        return $company ? $company->name : '-';
    }

       public static function GetCompany($id)
{
    // 1. Find the customer
    $customer = Customer::find($id);

    // 2. Safely find the company only if the customer exists
    $company = ($customer && $customer->companies_id)
               ? Company::find($customer->companies_id)
               : null;

    // 3. Return the array with defaults
    return [
        'name' => $company->name ?? '-',
        'tax'  => $company->tax_id ?? '-'
    ];
}
}
