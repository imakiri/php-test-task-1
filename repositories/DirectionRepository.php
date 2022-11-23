<?php

namespace app\repositories;

use app\entities\DirectionEntity;
use Yii;
use app\entities\CountryEntity;
use yii\db\Exception;

class DirectionRepository
{
    /**
     * @return DirectionEntity[]
     * @throws Exception
     */
    public function list(): array
    {
        $raw = Yii::$app->getDb()->createCommand('
        select
            country_id,
            city_id,
            price,
            cur,
            days,
            default_date
        from
            directions
        ')->queryAll();

        $data = [];
        foreach ($raw as $direction) {
            $data[] = (new DirectionEntity())->fromArray($direction);
        }

        return $data;
    }

    /**
     * @throws Exception
     */
    public function set(DirectionEntity $direction): string
    {
        $err = $direction->verify();
        if ($err != "") {
            return $err;
        }
        $i = Yii::$app->getDb()->createCommand('
        insert into directions (city_id, country_id, price, cur, days, default_date)
        values (:city_id, :country_id, :price, :cur, :days, :default_date)
        on duplicate key update 
                             price = :price,
                             cur = :cur,
                             days = :days,
                             default_date = :default_date
        ')->bindValues($direction->toArray())->execute();
        if ($i == 0) {
            return "no rows were affected";
        }
        return "";
    }
}