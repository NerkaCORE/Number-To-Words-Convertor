<?php

function numberToWords($number) {
    $unites = array('', 'un', 'deux', 'trois', 'quatre', 'cinq', 'six', 'sept', 'huit', 'neuf', 'dix', 'onze', 'douze', 'treize', 'quatorze', 'quinze', 'seize', 'dix-sept', 'dix-huit', 'dix-neuf');
    $tens = array('', '', 'vingt', 'trente', 'quarante', 'cinquante', 'soixante', 'quatre-vingt');
    
    // Handle negative number
    if ($number < 0) {
        return 'moins ' . numberToWords(abs($number));
    }
    
    // Suppress comma
    $number = str_replace(',', '', $number);
    
    // Convert the whole part
    $wholePart = (int)$number;
    
    // Convert the decimal part
    $DecimalPart = 0;
    if (strpos($number, '.') !== false) {
        $DecimalPart = (int)substr($number, strpos($number, '.') + 1);
    }
    
    $word = '';
    
    if ($wholePart < 20) {
        $word .= $unites[$wholePart];
    } elseif ($wholePart < 100) {
        $unite = $wholePart % 10;
        $ten = floor($wholePart / 10);
        
        if ($ten == 7 || $ten == 9) {                    
            if ($unite == 1 && $ten == 7) {
                $word .= $tens[$ten - 1];
                $word .= '-et-onze';
            } elseif ($unite == 1 && $ten == 9) {
                $word .= $tens[$ten - 2];
                $word .= '-onze';
            } elseif ($unite > 1 && $unite < 10 && $ten == 7) {
                $word .= $tens[$ten - 1];
                $word .= '-' . $unites[$unite + 10];
            } elseif ($unite > 1 && $unite < 10 && $ten == 9) {
                $word .= $tens[$ten - 2];
                $word .= '-' . $unites[$unite + 10];
            }
        } else {        
            if ($unite == 1 && $ten != 8) {
                $word .= $tens[$ten];
                $word .= '-et-' . $unites[$unite];
            } elseif ($unite > 0 && $ten == 8) {
                $word .= $tens[$ten - 1];
                $word .= '-' . $unites[$unite];
            } elseif ($unite == 0 && $ten == 8) {
                $word .= $tens[$ten - 1] . 's';                
            } elseif ($unite > 1 && $ten != 8) {
                $word .= $tens[$ten];
                $word .= '-' . $unites[$unite];
            } elseif ($unite == 0 && $ten != 8) {
                $word .= $tens[$ten];                
            }
        }
    } elseif ($wholePart < 1000) {
        $centaine = floor($wholePart / 100);
        $remainder = $wholePart % 100;
        
        if ($centaine == 1) {
            $word .= 'cent';
        } else {
            $word .= $unites[$centaine];
            
            if ($remainder > 0){
                $word .= ' cent';
            } else {
                $word .= ' cents';
            }
        }
        
        if ($remainder > 0) {
            $word .= ' ' . numberToWords($remainder);
        }
    } elseif ($wholePart < 1000000) {
        $thousand = floor($wholePart / 1000);
        $remainder = $wholePart % 1000;
        
        if ($thousand == 1) {
            $word .= 'mille';
        } else {
            $word .= numberToWords($thousand) . ' mille';
        }
        
        if ($remainder > 0) {
            $word .= ' ';            
            $word .= numberToWords($remainder);
        }
    } elseif ($wholePart < 1000000000) {
        $million = floor($wholePart / 1000000);
        $remainder = $wholePart % 1000000;
        
        if ($million == 1) {
            $word .= 'un million';
        } else {
            $word .= numberToWords($million) . ' millions';
        }
        
        if ($remainder > 0) {
            if ($remainder < 1000) {
                $word .= ' ';
            } else {
                $word .= ' ';
            }
            
            $word .= numberToWords($remainder);
        }
    }
    
    // Add the decimal part if it exists
    if ($DecimalPart > 0) {
        if ($word !== '') {
            $word .= ' ';
        }
        
        if ($DecimalPart < 20) {
            $word .= $unites[$DecimalPart];
        } else {
            $unite = $DecimalPart % 10;
            $ten = floor($DecimalPart / 10);
            $word .= $tens[$ten];
            
            if ($unite > 0) {
                $word .= '-' . $unites[$unite];
            }
        }
    }
    
    return $word;
}

function convert_numbers_to_letters($number){
    $letters = array(
        0 => 'zéro',
        1 => 'un',
        2 => 'deux',
        3 => 'trois',
        4 => 'quatre',
        5 => 'cinq',
        6 => 'six',
        7 => 'sept',
        8 => 'huit',
        9 => 'neuf',
        10 => 'dix',
        11 => 'onze',
        12 => 'douze',
        13 => 'treize',
        14 => 'quatorze',
        15 => 'quinze',
        16 => 'seize',
        20 => 'vingt',
        30 => 'trente',
        40 => 'quarante',
        50 => 'cinquante',
        60 => 'soixante',
        70 => 'soixante-dix',
        80 => 'quatre-vingt',
        90 => 'quatre-vingt-dix'
    );

    if(!is_numeric($number)){
        return false;
    }

    if(($number < 0) || ($number > 999999999)){
        return false;
    }

    $number = round($number);

    $result = '';

    if($number == 0){
        $result = $letters[$number];
    }else{
        if($number >= 1000000){
            $result .= convert_numbers_to_letters(floor($number / 1000000)).' million ';
            $number = $number % 1000000;
        }

        if($number >= 1000){
            $result .= convert_numbers_to_letters(floor($number / 1000)).' mille ';
            $number = $number % 1000;
        }

        if($number >= 100){
            if ($number == 100){
                $result = 'cent';
            }
            elseif (floor($number / 100) == 1) {
                $number = $number % 100;
            }
            else {
                $result .= convert_numbers_to_letters(floor($number / 100)).' cent ';
                $number = $number % 100;
            }
        }

        if($number >= 20){
            if(($number >= 70) && ($number < 80)){
                $result .= 'soixante-dix ';
                $number = $number % 10;
            }elseif(($number >= 80) && ($number < 90)){
                $result .= 'quatre-vingt ';
                $number = $number % 10;
            }elseif(($number >= 90) && ($number < 100)){
                $result .= 'quatre-vingt-dix ';
                $number = $number % 10;
            }else{
                $result .= $letters[floor($number / 10) * 10].' ';
                $number = $number % 10;
            }
        }

        if($number > 0){
            $result .= $letters[$number];
        }
    }

    return $result;
}

?>