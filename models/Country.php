<?php

namespace app\models;

use Yii;
use yii\data\ArrayDataProvider;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\DataReader;
use yii\db\Exception;

/**
 * This is the model class for table "countries".
 *
 * @property int $country_id
 * @property string $name
 * @property string $name_to
 * @property string $to
 * @property int $sort
 *
 * @property Direction[] $directions
 */
class Country extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'countries';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['country_id','name', 'name_to', 'to', 'sort'], 'required'],
            [['country_id'], 'integer'],
            [['sort'], 'integer'],
            [['name', 'name_to'], 'string', 'max' => 100],
            [['to'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'country_id' => 'Country ID',
            'name' => 'Name',
            'name_to' => 'Name To',
            'to' => 'To',
            'sort' => 'Sort',
        ];
    }

    /**
     * Gets query for [[Directions]].
     *
     * @return ActiveQuery
     */
    public function getDirections(): ActiveQuery
    {
        return $this->hasMany(Direction::class, ['country_id' => 'country_id']);
    }

    /**
     * @throws Exception
     */
    public function save($runValidation = true, $attributeNames = null): bool
    {
        if ($runValidation) {
            if (!$this->validate()) {
                return false;
            }
        }

        return Yii::$app->getDb()->createCommand('
        insert into countries (`name`, name_to, `to`, sort, country_id)
        values (:name, :name_to, :to, :sort, :country_id)
        on duplicate key update 
                             `name` = :name,
                             name_to = :name_to,
                             `to` = :to,
                             sort = :sort
        ')->bindValues($this->getAttributes())->execute() !== 0;
    }

    /**
     * @throws Exception
     */
    public function list(): array {
        return Yii::$app->getDb()->createCommand('
                select
                    countries.country_id,
                    `name`,
                    name_to as nameTo,
                    sort,
                    IF(COUNT(directions.city_id) = 0, JSON_ARRAY(), JSON_ARRAYAGG(directions.city_id)) as departs
                from
                    countries
                        left outer join directions on countries.country_id = directions.country_id
                group by countries.country_id;
                    ')->queryAll();
    }
}
