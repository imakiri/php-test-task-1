<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Exception;

/**
 * This is the model class for table "directions".
 *
 * @property int $city_id
 * @property int $country_id
 * @property int $price
 * @property string $cur
 * @property string $days
 * @property string $default_date
 *
 * @property City $city
 * @property Country $country
 */
class Direction extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return 'directions';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['city_id', 'country_id', 'price', 'cur', 'days', 'default_date'], 'required'],
            [['city_id', 'country_id', 'price'], 'integer'],
            [['cur'], 'string', 'max' => 50],
            [['days', 'default_date'], 'string', 'max' => 100],
            [['city_id'], 'exist', 'skipOnError' => false, 'targetClass' => City::class, 'targetAttribute' => ['city_id' => 'city_id']],
            [['country_id'], 'exist', 'skipOnError' => false, 'targetClass' => Country::class, 'targetAttribute' => ['country_id' => 'country_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'city_id' => 'City ID',
            'country_id' => 'Country ID',
            'price' => 'Price',
            'cur' => 'Cur',
            'days' => 'Days',
            'default_date' => 'Default Date',
        ];
    }

    /**
     * Gets query for [[City]].
     *
     * @return ActiveQuery
     */
    public function getCity(): ActiveQuery
    {
        return $this->hasOne(City::class, ['city_id' => 'country_id']);
    }

    /**
     * Gets query for [[Country]].
     *
     * @return ActiveQuery
     */
    public function getCountry(): ActiveQuery
    {
        return $this->hasOne(Country::class, ['country_id' => 'country_id']);
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
        insert into directions (city_id, country_id, price, cur, days, default_date)
        values (:city_id, :country_id, :price, :cur, :days, :default_date)
        on duplicate key update 
                             price = :price,
                             cur = :cur,
                             days = :days,
                             default_date = :default_date
        ')->bindValues($this->getAttributes())->execute() !== 0;
    }
}
