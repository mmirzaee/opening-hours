<?php

namespace app\models;

interface HasOpenHoursInterface
{
    public function hasParent(): bool;

    public function getParentType(): ?string;

    public function getParentId(): ?int;

    public function getWeekDayOpenHours(string $dayOfTheWeek): array;

    public function getDateTimeOpenHours(\DateTime $dateTime): OpenHours;

    public function getDateTimeExceptions(\DateTime $dateTime): OpenHours;
}
