<?php

namespace app\controllers;

class StationsController extends BaseRestController
{
    use OpenHoursTrait;

    public $modelClass = 'app\models\Stations';

    public function actions()
    {
        $actions = parent::actions();

        $actions['index']['dataFilter'] = [
            'class' => \yii\data\ActiveDataFilter::class,
            'searchModel' => function () {
                return (new \yii\base\DynamicModel(['store_id' => null]))
                    ->addRule('store_id', 'integer');
            },
        ];

        return $actions;
    }

    public function actionIsOpenAt($id)
    {
        return 'is open';
    }


    public function actionNextStateChange($id)
    {
        return 'next state change';
    }
}
