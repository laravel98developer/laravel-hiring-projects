<?php

if (! function_exists('change_numbers_to_english')) {
    function change_digits_to_english(string $digits): string
    {
        $persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $arabicDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];

        $number = range(0, 9);
        $convertPersianToEnglish = str_replace($persianDigits, $number, $digits);
        $convertArabicToEnglish = str_replace($arabicDigits, $number, $convertPersianToEnglish);

        return $convertArabicToEnglish;
    }
}
