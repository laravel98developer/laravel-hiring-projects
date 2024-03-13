<?php


function bigeastSum2number($array, $number): array
{
    foreach($array as $itme) {
        if(getType($itme) != "integer" && getType($itme) != "double") {
            return array("message" => "All of array items should be integer or double");
        }
    }

    if(getType($number) != "integer" && getType($number) != "double") {
        return array("message" => "input number should be integer or double");
    }

    if(count($array) < 2) {
        return array("message" => "In input array should exist atleast 2 number");
    }

    rsort($array);

    if($array[0] + $array[1] > $number) {
        return array($array[0],$array[1]);
    } else {
        return array("message" => "The sum of none of the numbers in this array is greater than ".$number);
    }

}
