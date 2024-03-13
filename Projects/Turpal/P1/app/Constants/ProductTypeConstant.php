<?php


namespace App\Constants;


use App\Models\ProductType;

class ProductTypeConstant
{
    public const EVENT = 'event';
    public const TOUR = 'tour';
    public const ACTIVITY = 'activity';

    public static function getTypes(): array
    {
        return [
          self::EVENT,
          self::TOUR,
          self::ACTIVITY
        ];
    }

    public static function getId($type)
    {
        return ProductType::query()->where('type',$type)->first()->id;
    }
}
