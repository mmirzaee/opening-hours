<?php

namespace app\controllers;

use app\models\HasOpenHoursInterface;
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
            return ['msg' => 'time is not valid'];
        }

        return ['time' => $time, 'datetime' => $datetime->format("Y-m-d H:i:s"), 'is_open' => $this->getOpenState($model, $datetime)["is_open"]];
    }


    public function actionNextStateChange($id)
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
            return ['msg' => 'time is not valid'];
        }


    }

    private function getOpenState(HasOpenHoursInterface $entity, \DateTime $datetime)
    {
        if ($exception = $this->callMethodInTreeBottomUp('getDateTimeException', $entity, [$datetime])) {
            return ['is_open' => !!$exception->is_open, 'type' => 'exception', 'object' => $exception];
        }

        if ($open_hour = $this->callMethodInTreeBottomUp('getDateTimeOpenHour', $entity, [$datetime])) {
            return ['is_open' => true, 'type' => 'open_hour', 'object' => $open_hour];
        }

        return ['is_open' => false, 'type' => 'open_hour', 'object' => null];
    }

    private function callMethodInTreeBottomUp(string $method, HasOpenHoursInterface $entity, array $args)
    {
        if (method_exists($entity, $method)) {
            if ($result = call_user_func_array(array($entity, $method), $args)) {
                return $result;
            }
            if ($parent = $entity->getParent()) {
                return $this->callMethodInTreeBottomUp($method, $parent, $args);
            }
        }
        return null;
    }

}
