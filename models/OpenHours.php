<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "open_hours".
 *
 * @property int $id
 * @property int $entity_id
 * @property string $entity_type
 * @property string $week_day
 * @property string $from
 * @property string $to
 */
class OpenHours extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'open_hours';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['entity_id', 'entity_type', 'week_day', 'from', 'to'], 'required'],
            [['entity_id'], 'integer'],
            [['from', 'to'], 'safe'],
            [['entity_type'], 'string', 'max' => 16],
            [['week_day'], 'string', 'max' => 4],
            [['entity_id', 'entity_type', 'week_day', 'from', 'to'], 'unique', 'targetAttribute' => ['entity_id', 'entity_type', 'week_day', 'from', 'to']],
            [['entity_id', 'entity_type', 'from', 'to'], 'unique', 'targetAttribute' => ['entity_id', 'entity_type', 'from', 'to']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity_id' => 'Entity ID',
            'entity_type' => 'Entity Type',
            'week_day' => 'Week Day',
            'from' => 'From',
            'to' => 'To',
        ];
    }
}
