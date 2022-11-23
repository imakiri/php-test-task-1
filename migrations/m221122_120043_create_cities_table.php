<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cities}}`.
 */
class m221122_120043_create_cities_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cities}}', [
            'name' => $this->char(170)->notNull()->unique(),
            'name_from' => $this->char(180)->notNull()->unique(),
            'sort' => $this->integer()->notNull()->unique()->unsigned(),
        ]);
        $this->addColumn(
            '{{%cities}}',
            'city_id',
            'int unsigned not null primary key'
        );
        $this->createIndex(
            'idx-city_id',
            '{{%cities}}',
            'city_id',
            true
        );
        $this->createIndex(
            'idx-name',
            '{{%cities}}',
            'name',
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cities}}');
        $this->dropIndex('idx-city_id', '{{%cities}}');
        $this->dropIndex('idx-name', '{{%cities}}');
    }
}
