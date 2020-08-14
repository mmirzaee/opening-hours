<?php

namespace app\controllers;

use app\models\Exceptions;
use app\models\HasOpenHoursInterface;
use app\models\OpenHours;
use app\models\Stations;

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
        if (!$model = Stations::findOne(['id' => $id])) {
            \Yii::$app->response->setStatusCode(404);
            return ['msg' => 'station not found'];
        }

        if (!$time = \Yii::$app->request->get('time')) {
            \Yii::$app->response->setStatusCode(400);
            return ['msg' => 'time is not provided'];
        }

        try {
            $datetime = new \DateTime("@$time");
        } catch (\Exception $e) {
            \Yii::$app->response->setStatusCode(400);
            return ['msg' => $e];
        }

        if ($exception = $this->getExceptionRecursive($model, $datetime)) {
            return $exception->is_open ? ['is_open' => true] : ['is_open' => false];
        }

        if ($open_hour = $this->getOpenHourRecursive($model, $datetime)) {
            return ['is_open' => true];
        }

        return ['is_open' => false];
    }


    public function actionNextStateChange($id)
    {
        return 'next state change';
    }


    private function getExceptionRecursive(HasOpenHoursInterface $entity, \DateTime $datetime): ?Exceptions
    {
        if ($exception = $entity->getDateTimeException($datetime)) {
            return $exception;
        }

        if ($entity->hasParent()) {
            $parent_class = '\app\models\\' . $entity->getParentType();
            if ($parent = $parent_class::findOne(['id' => $entity->getParentId()])) {
                return $this->getExceptionRecursive($parent, $datetime);
            }
        }

        return null;
    }

    private function getOpenHourRecursive(HasOpenHoursInterface $entity, \DateTime $datetime): ?OpenHours
    {
        if ($open_hour = $entity->getDateTimeOpenHour($datetime)) {
            return $open_hour;
        }

        if ($entity->hasParent()) {
            $parent_class = '\app\models\\' . $entity->getParentType();
            if ($parent = $parent_class::findOne(['id' => $entity->getParentId()])) {
                return $this->getOpenHourRecursive($parent, $datetime);
            }
        }

        return null;
    }

}
