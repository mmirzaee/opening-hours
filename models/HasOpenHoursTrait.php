<?php

namespace app\models;

trait HasOpenHoursTrait
{
    public function getWeekDayOpenHours(string $dayOfTheWeek): array
    {

    }

    public function getDateTimeOpenHours(\DateTime $dateTime): OpenHours
    {

    }

    public function getDateTimeExceptions(\DateTime $dateTime): OpenHours
    {

    }
}
