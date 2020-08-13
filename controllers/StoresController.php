<?php

namespace app\controllers;

class StoresController extends BaseController
{
    public $modelClass = 'app\models\Stores';

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
