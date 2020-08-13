<?php

namespace app\controllers;

use yii\filters\Cors;
use yii\rest\ActiveController;


class BaseController extends ActiveController
{
    use OpenHoursTrait;

    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // add CORS filter
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
        ];

        return $behaviors;
    }
}