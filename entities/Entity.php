<?php

namespace app\entities;

abstract class Entity
{
    abstract public function verify(): string;
    abstract public function fromArray(array $args): Entity;

    /**
     * @return Entity[]
     */
    abstract public function toArray(): array;
}