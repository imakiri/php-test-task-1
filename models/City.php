<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table "cities".
 *
 * @property int $city_id
 * @property string $name
 * @property string $name_from
 * @property int $sort
 *
 * @property Direction[] $directions
 */
class City extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'cities';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['city_id', 'name', 'name_from', 'sort'], 'required'],
            [['city_id'], 'integer'],
            [['sort'], 'integer'],
            [['name'], 'string', 'max' => 170],
            [['name_from'], 'string', 'max' => 180],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'city_id' => 'City ID',
            'name' => 'Name',
            'name_from' => 'Name From',
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
        return $this->hasMany(Direction::class, ['country_id' => 'city_id']);
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
        insert into cities (`name`, name_from, sort, city_id) 
        values (:name, :name_from, :sort, :city_id)
        on duplicate key update 
                             `name` = :name,
                             name_from = :name_from,
                             sort = :sort
        ')->bindValues($this->getAttributes())->execute() !== 0;
    }
}
