<?php

namespace app\models;

interface HasOpeningHoursInterface
{
    public function hasParent();
    public function getParentType();
    public function getParentId();
    public function getWeekDayOpeningHours();
    public function getDateTimeExceptions();
}
