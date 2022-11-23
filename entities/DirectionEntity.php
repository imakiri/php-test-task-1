<?php

namespace app\entities;

use Yii;
use yii\helpers\Json;


class DirectionEntity extends Entity
{
    public int $city_id;
    public int $country_id;
    public int $price;
    public string $cur;
    public string $days;
    public string $default_date;

    public function fromArray(array $args): DirectionEntity
    {
        $this->city_id = $args['city_id'];
        $this->country_id = $args['country_id'];
        $this->price = $args['price'];
        $this->cur = $args['cur'];
        $this->days = $args['days'];
        $this->default_date = $args['default_date'];
        return $this;
    }

    public function toArray(): array
    {
        return [
            'city_id' => $this->city_id,
            'country_id' => $this->country_id,
            'price' => $this->price,
            'cur' => $this->cur,
            'days' => $this->days,
            'default_date' => $this->default_date
        ];
    }

    public function verify(): string
    {
        if ($this->city_id < 0) {
            return "city_id: cannot be negative";
        }
        if ($this->country_id < 0) {
            return "country_id: cannot be negative";
        }
        if ($this->cur == "") {
            return "cur: cannot be empty";
        }
        if ($this->default_date == "") {
            return "default_date: cannot be empty";
        }
        if ($this->price < 0) {
            return "price: cannot be negative";
        }
        try {
            Json::decode($this->days);
        } catch (yii\base\InvalidArgumentException $ex) {
            return "days: invalid json: " . $ex->getMessage();
        }
        return "";
    }
}
