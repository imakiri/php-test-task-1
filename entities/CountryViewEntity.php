<?php

namespace app\entities;

class CountryViewEntity extends Entity
{
    public int $country_id;
    public string $name;
    public string $name_to;
    public string $to;
    public int $sort;
    public string $departs;

    public function fromArray(array $args): CountryViewEntity
    {
        $this->country_id = $args['country_id'];
        $this->name = $args['name'];
        $this->name_to = $args['name_to'];
        $this->to = $args['to'];
        $this->sort = $args['sort'];
        $this->departs = $args['departs'];
        return $this;
    }

    public function toArray(): array
    {
        return [
            'country_id' => $this->country_id,
            'name' => $this->name,
            'name_to' => $this->name_to,
            'to' => $this->to,
            'sort' => $this->sort,
            'departs' => $this->departs
        ];
    }

    public function verify(): string
    {
        return "view only";
    }
}