<?php

namespace app\controllers;

use app\models\Exceptions;
use app\models\OpenHours;

trait OpenHoursTrait
{
    public function actionAddOpenHour($entity_id)
    {
        $model = new OpenHours();

        $post_data = \Yii::$app->request->post();

        foreach ($model->attributes() as $attr) {
            if (isset($post_data[$attr])) {
                $model->{$attr} = $post_data[$attr];
            }
        }

        $model->entity_id = $entity_id;
        $model->entity_type = $this->getEntityType();

        if ($model->validate() && $model->save()) {
            return $model;
        }

        \Yii::$app->response->setStatusCode(422);
        return $model->errors;
    }

    public function actionRemoveOpenHour($entity_id, $id)
    {
        if (!$model = OpenHours::findOne(['id' => $id, 'entity_id' => $entity_id])) {
            \Yii::$app->response->setStatusCode(404);
            return 'not found';
        }

        $model->delete();
        return 'ok';
    }

    public function actionUpdateOpenHour($entity_id, $id)
    {
        if (!$model = OpenHours::findOne(['id' => $id, 'entity_id' => $entity_id, 'entity_type' => $this->getEntityType()])) {
            \Yii::$app->response->setStatusCode(404);
            return 'not found';
        }

        $post_data = \Yii::$app->request->post();

        foreach (['week_day', 'from', 'to'] as $attr) {
            if (isset($post_data[$attr])) {
                $model->{$attr} = $post_data[$attr];
            }
        }

        if ($model->validate() && $model->save()) {
            return $model;
        }

        \Yii::$app->response->setStatusCode(422);
        return $model->errors;
    }

    public function actionGetOpenHours($entity_id)
    {
        return OpenHours::find()->where(['entity_id' => $entity_id])->select(['id', 'week_day', 'from', 'to'])->all();
    }

    public function actionAddException($entity_id)
    {
        $model = new Exceptions();

        $post_data = \Yii::$app->request->post();

        foreach ($model->attributes() as $attr) {
            if (isset($post_data[$attr])) {
                $model->{$attr} = $post_data[$attr];
            }
        }

        $model->entity_id = $entity_id;
        $model->entity_type = $this->getEntityType();

        if ($model->validate() && $model->save()) {
            return $model;
        }

        \Yii::$app->response->setStatusCode(422);
        return $model->errors;
    }

    public function actionRemoveException($entity_id, $id)
    {
        if (!$model = Exceptions::findOne(['id' => $id, 'entity_id' => $entity_id])) {
            \Yii::$app->response->setStatusCode(404);
            return 'not found';
        }

        $model->delete();
        return 'ok';
    }

    public function actionUpdateException($entity_id, $id)
    {

        if (!$model = Exceptions::findOne(['id' => $id, 'entity_id' => $entity_id, 'entity_type' => $this->getEntityType()])) {
            \Yii::$app->response->setStatusCode(404);
            return 'not found';
        }

        $post_data = \Yii::$app->request->post();

        foreach (['from', 'to', 'reason', 'is_open'] as $attr) {
            if (isset($post_data[$attr])) {
                $model->{$attr} = $post_data[$attr];
            }
        }

        if ($model->validate() && $model->save()) {
            return $model;
        }

        \Yii::$app->response->setStatusCode(422);
        return $model->errors;
    }

    public function actionGetExceptions($entity_id)
    {
        return Exceptions::find()->where(['entity_id' => $entity_id])->select(['id', 'from', 'to', 'reason', 'is_open'])->all();
    }

    private function getEntityType()
    {
        try {
            return (new \ReflectionClass($this->modelClass))->getShortName();
        } catch (\Exception $e) {
            return null;
        }
    }
}
