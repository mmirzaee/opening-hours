<?php

namespace app\models;

trait HasOpenHoursTrait
{
    public function getWeekDayOpenHours(string $dayOfTheWeek): array
    {
        // TODO
    }

    public function getDateTimeOpenHours(\DateTime $dateTime): OpenHours
    {
        // TODO
    }

    public function getDateTimeExceptions(\DateTime $dateTime): OpenHours
    {
        // TODO
    }
}
