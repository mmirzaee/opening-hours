<?php

namespace app\models;

interface HasOpenHoursInterface
{
    public function hasParent(): bool;

    public function getParentType(): ?string;

    public function getParentId(): ?int;

    public function getParent(): ?HasOpenHoursInterface;

    public function getWeekDayOpenHours(string $week_day): ?array;

    public function getDateTimeOpenHour(\DateTime $datetime): ?OpenHours;

    public function getDateTimeException(\DateTime $datetime): ?Exceptions;
}
