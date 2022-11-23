<?php

namespace app\entities;


class CountryEntity extends Entity
{
    public int $country_id;
    public string $name;
    public string $name_to;
    public string $to;
    public int $sort;

    public function fromArray(array $args): CountryEntity
    {
        $this->country_id = $args['country_id'];
        $this->name = $args['name'];
        $this->name_to = $args['name_to'];
        $this->to = $args['to'];
        $this->sort = $args['sort'];
        return $this;
    }

    public function toArray(): array
    {
        return [
            'country_id' => $this->country_id,
            'name' => $this->name,
            'name_to' => $this->name_to,
            'to' => $this->to,
            'sort' => $this->sort
        ];
    }

    public function verify(): string
    {
        if ($this->country_id < 0) {
            return "country_id cannot be negative";
        }
        if ($this->sort < 0) {
            return "sort cannot be negative";
        }
        if ($this->name == "") {
            return "name cannot be empty";
        }
        if ($this->name_to == "") {
            return "name_to cannot be empty";
        }
        if ($this->to == "") {
            return "to cannot be empty";
        }
        return "";
    }
}

