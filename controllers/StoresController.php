<?php

namespace app\controllers;

use yii\filters\Cors;
use yii\rest\ActiveController;


class StoresController extends ActiveController
{
    use OpenHoursTrait;

    public $modelClass = 'app\models\Stores';
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

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['dataFilter'] = [
            'class' => \yii\data\ActiveDataFilter::class,
            'searchModel' => function () {
                return (new \yii\base\DynamicModel(['tenant_id' => null]))
                    ->addRule('tenant_id', 'integer');
            },
        ];

        return $actions;
    }
}
