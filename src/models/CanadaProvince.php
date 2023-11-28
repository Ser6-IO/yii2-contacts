<?php 

namespace ser6io\yii2contacts\models;

class CanadaProvince
{
    const CODE_NAME = [
        ['AB' => "Alberta"],
        ['BC' => "British Columbia"],
        ['MB' => "Manitoba"],
        ['NB' => "New Brunswick"],
        ['NL' => "Newfoundland"],
        ['NT' => "Northwest Territories"],
        ['NS' => "Nova Scotia"],
        ['NU' => "Nunavut"],
        ['ON' => "Ontario"],
        ['PE' => "Prince Edward Island"],
        ['QC' => "Quebec"],
        ['SK' => "Saskatchewan"],
        ['YT' => "Yukon"],
    ];

    //unnest one level
    public static function getProvinces()
    {
        $result = [];
        foreach (self::CODE_NAME as $item) {
            $result[] = array_keys($item)[0];
        }
        return $result;
    }
}
?>