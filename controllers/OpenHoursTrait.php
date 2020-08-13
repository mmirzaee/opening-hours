<?php

namespace app\controllers;

trait OpenHoursTrait{
    public function actionAddOpenHour($entity_id){
        return 'add open hour';
    }

    public function actionRemoveOpenHour($entity_id, $id){
        return 'remove open hour';
    }

    public function actionUpdateOpenHour($entity_id, $id){
        return 'update open hour';
    }

    public function actionGetOpenHours($entity_id){
        return 'get open hour';
    }

    public function actionAddException($entity_id){
        return 'add exception';
    }

    public function actionRemoveException($entity_id, $id){
        return 'remove exception';
    }

    public function actionUpdateException($entity_id, $id){
        return 'update exception';
    }

    public function actionGetExceptions($entity_id){
        return 'get exceptions';
    }
}
