<?php

namespace app\entities;


class CityEntity extends Entity
{
    public int $city_id;
    public string $name;
    public string $name_from;
    public int $sort;

    public function fromArray(array $args): CityEntity
    {
        $this->city_id = $args['city_id'];
        $this->name = $args['name'];
        $this->name_from = $args['name_from'];
        $this->sort = $args['sort'];
        return $this;
    }

    public function toArray(): array
    {
        return [
            'city_id' => $this->city_id,
            'name' => $this->name,
            'name_from' => $this->name_from,
            'sort' => $this->sort
        ];
    }

    public function verify(): string
    {
        if ($this->city_id < 0) {
            return "city_id: cannot be negative";
        }
        if ($this->sort < 0) {
            return "sort: cannot be negative";
        }
        if ($this->name == "") {
            return "name: cannot be empty";
        }
        if ($this->name_from == "") {
            return "name_from: cannot be empty";
        }
        return "";
    }
}


