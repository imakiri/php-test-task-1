<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%directions}}`.
 */
class m221122_131244_create_directions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%directions}}', [
            'city_id' => $this->integer()->notNull()->unsigned(),
            'country_id' => $this->integer()->notNull()->unsigned(),
            'price' => $this->integer()->notNull(),
            'cur' => $this->char(50)->notNull(),
            'days' => $this->char(100)->notNull(),
            'default_date' => $this->char(100)->notNull()
        ]);
        $this->addPrimaryKey(
            'pk-city_id-country_id',
            '{{%directions}}',
            'city_id, country_id'
        );
        $this->createIndex(
            'idx-city_id',
            '{{%directions}}',
            'city_id'
        );
        $this->createIndex(
            'idx-country_id',
            '{{%directions}}',
            'country_id'
        );
        $this->addForeignKey(
            'fk-city_id',
            '{{%directions}}',
            'city_id',
            '{{%cities}}',
            'city_id',
            'CASCADE',
            'CASCADE'
        );
        $this->addForeignKey(
            'fk-country_id',
            '{{%directions}}',
            'country_id',
            '{{%countries}}',
            'country_id',
            'CASCADE',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%directions}}');
        $this->dropIndex('idx-city_id', '{{%directions}}');
        $this->dropIndex('idx-country_id', '{{%directions}}');
        $this->dropForeignKey('fk-city_id', '{{%directions}}');
        $this->dropForeignKey('fk-country_id', '{{%directions}}');
    }
}
