<?php

namespace app\repositories;

use Yii;
use app\entities\CityEntity;
use yii\db\Exception;

class CityRepository
{
    /**
     * @return CityEntity[]
     * @throws Exception
     */
    public function list(): array
    {
        $raw = Yii::$app->getDb()->createCommand('
        select city_id, `name`, name_from, sort
        from cities
        ')->queryAll();

        $data = [];
        foreach ($raw as $city) {
            $data[$city['city_id']] = (new CityEntity)->fromArray($city);
        }

        return $data;
    }

    /**
     * @throws Exception
     */
    public function set(CityEntity $city): string
    {
        $err = $city->verify();
        if ($err != "") {
            return $err;
        }
        $i = Yii::$app->getDb()->createCommand('
        insert into cities (`name`, name_from, sort, city_id) 
        values (:name, :name_from, :sort, :city_id)
        on duplicate key update 
                             `name` = :name,
                             name_from = :name_from,
                             sort = :sort
        ')->bindValues($city->toArray())->execute();
        if ($i == 0) {
            return "no rows were affected";
        }
        return "";
    }
}