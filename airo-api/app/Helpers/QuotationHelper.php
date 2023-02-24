<?php

namespace App\Helpers;

use Exception;

class QuotationHelper
{
    const FIXED_RATE = 3;


    const AGE_LOAD = [
        ['min-age' => 18, 'max-age' => 30, 'load' => 0.6 ],
        ['min-age' => 31, 'max-age' => 40, 'load' => 0.7 ],
        ['min-age' => 41, 'max-age' => 50, 'load' => 0.8 ],
        ['min-age' => 51, 'max-age' => 60, 'load' => 0.9 ],
        ['min-age' => 61, 'max-age' => 70, 'load' => 1 ],
    ];

    const CURRENCIES = ['EUR', 'USD', 'GBP' ];

    public static function calculateQuotation($ages, $start_date, $end_date){
        $total = 0;

        $ageValues = explode(',', $ages);
        $diff = strtotime($end_date) - strtotime($start_date);
        $days = round($diff /(24 * 60 * 60));

        foreach ($ageValues as $ageValueStr) {
            $ageValue = (int)$ageValueStr;
            $validAge = false;
            foreach (self::AGE_LOAD as $rangeAgeload) {
                if($rangeAgeload['min-age'] <= $ageValue && $rangeAgeload['max-age'] >= $ageValue 
                ){
                    $validAge = true;
                    $total = $total + (self::FIXED_RATE * $rangeAgeload['load'] * $days);
                }
            }
            if(!$validAge){
                throw new Exception("Age $ageValue Not valid");
            }
        }

        return $total;
    }

}
