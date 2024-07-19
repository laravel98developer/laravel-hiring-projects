<?php

const TRANSACTION_WAGE = 5000;

const GET_MONNY_SMS_MESSAGE = "واریز به حساب: {{Account}} \n مبلغ: {{Amount}}";
const GIVE_MONNY_SMS_MESSAGE = "برداشت از حساب: {{Account}} \n مبلغ: {{Amount}}";

const TRANSACTION_STATUS_SUCCEED = 'succeed';
const TRANSACTION_STATUS_NO_BALANCE = 'no_balance';
const TRANSACTION_STATUS_ERROR = 'error';


// function to change arabic and persian numbers to english
function fatoEnNumeric($string) {

    return strtr($string, array('۰'=>'0', '۱'=>'1', '۲'=>'2', '۳'=>'3', '۴'=>'4', '۵'=>'5', '۶'=>'6', '۷'=>'7', '۸'=>'8', '۹'=>'9', '٠'=>'0', '١'=>'1', '٢'=>'2', '٣'=>'3', '٤'=>'4', '٥'=>'5', '٦'=>'6', '٧'=>'7', '٨'=>'8', '٩'=>'9'));
}