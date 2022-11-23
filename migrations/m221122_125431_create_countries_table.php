<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%countries}}`.
 */
class m221122_125431_create_countries_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%countries}}', [
            'name' => $this->char(100)->notNull()->unique(),
            'name_to' => $this->char(100)->notNull()->unique(),
            'to' => $this->char(10)->notNull(),
            'sort' => $this->integer()->notNull()->unique()
        ]);
        $this->addColumn(
            '{{%countries}}',
            'country_id',
            'int unsigned not null primary key'
        );
        $this->createIndex(
            'idx-country_id',
            '{{%countries}}',
            'country_id',
            true
        );
        $this->createIndex(
            'idx-name',
            '{{%countries}}',
            'name',
            true
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%countries}}');
        $this->dropIndex('idx-country_id', '{{%countries}}');
        $this->dropIndex('idx-name', '{{%countries}}');
    }
}
