<?php
namespace App\Utils;

class DateConverter
{
    public static function convertDateFormat(array $period): array
    {
        return [
            'inicio' => self::convertDate($period[0]),
            'fim'    => self::convertDate($period[1]),
        ];
    }

    private static function convertDate(string $date): string
    {
        $dateParts = explode('/', $date);
        $date = $dateParts[2] . '-' . $dateParts[1] . '-' . $dateParts[0];
        return date('Y-m-d', strtotime($date));
    }
}
