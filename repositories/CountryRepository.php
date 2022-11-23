<?php

namespace app\repositories;

use app\entities\CountryViewEntity;
use Yii;
use app\entities\CountryEntity;
use yii\db\Exception;

class CountryRepository
{
    /**
     * @return CountryViewEntity[]
     * @throws Exception
     */
    public function list(): array
    {
        $raw = Yii::$app->getDb()->createCommand('
        select
            countries.country_id,
            `name`,
            name_to,
            `to`,
            sort,
            IF(COUNT(directions.city_id) = 0, JSON_ARRAY(), JSON_ARRAYAGG(directions.city_id)) as departs
        from
            countries
        left outer join directions on countries.country_id = directions.country_id
        group by countries.country_id;
        ')->queryAll();

        $data = [];
        foreach ($raw as $city) {
            $data[$city['country_id']] = (new CountryEntity)->fromArray($city);
        }

        return $data;
    }

    /**
     * @throws Exception
     */
    public function set(CountryEntity $country): string
    {
        $err = $country->verify();
        if ($err != "") {
            return $err;
        }
        $i = Yii::$app->getDb()->createCommand('
        insert into countries (`name`, name_to, `to`, sort, country_id)
        values (:name, :name_to, :to, :sort, :country_id)
        on duplicate key update 
                             `name` = :name,
                             name_to = :name_to,
                             `to` = :to,
                             sort = :sort
        ')->bindValues($country->toArray())->execute();
        if ($i == 0) {
            return "no rows were affected";
        }
        return "";
    }
}