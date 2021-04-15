<?php

declare(strict_types=1);

namespace App\Dto;

final class RoutineCollectionOutput extends BaseRoutine
{
    /**
     * A routine uuid.
     */
    public string $uuid;

    /**
     * A routine completed routines count.
     */
    public int $completedRoutinesCount;

    /**
     * A routine completed devoted time.
     */
    public string $completedRoutinesDevotedTime;

    /**
     * A routine completed routines percent.
     */
    public int $completedRoutinesPercent;

    /**
     * A routine completed goals percent.
     */
    public int $goalsCompletedPercent;

    /**
     * A routine goals count.
     */
    public int $goalsCount;

    /**
     * A routine not completed goals percent.
     */
    public int $goalsNotCompletedPercent;

    /**
     * A routine notes count.
     */
    public int $notesCount;

    /**
     * A routine reminders count.
     */
    public int $remindersCount;

    /**
     * A routine rewards count.
     */
    public int $rewardsCount;

    /**
     * A routine sent reminders count.
     */
    public int $sentRemindersCount;

    /**
     * A routine sent reminders percent.
     */
    public int $sentRemindersPercent;
}
