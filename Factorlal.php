<?php

function getFactorial($num)
{

    if (!is_int($num) || $num < 0) {
        return "Factorial is not defined for negative numbers or non-integers.";
    } else if ($num <= 1) {
        return 1;
    } else {
        return $num * getFactorial($num - 1);
    }
}

$number = 5;
$result = getFactorial($number);

echo "The factorial of $number is: $result";
