<?php

declare(strict_types=1);

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\RoutineCollectionOutput;
use App\Entity\Routine;

final class RoutineCollectionOutputDataTransformer implements DataTransformerInterface
{
    public function transform($object, string $to, array $context = []): RoutineCollectionOutput
    {
        $output = new RoutineCollectionOutput();
        $output->uuid = $object->getUuid();
        $output->completedRoutinesCount = $object->getCompletedRoutinesCount();
        $output->completedRoutinesDevotedTime = $object->getCompletedRoutinesDevotedTime();
        $output->completedRoutinesPercent = $object->getCompletedRoutinesPercent();
        $output->description = $object->getDescription();
        $output->goalsCompletedCount = $object->getGoalsCompletedCount();
        $output->goalsCompletedPercent = $object->getGoalsCompletedPercent();
        $output->goalsCount = $object->getGoalsCount();
        $output->goalsNotCompletedCount = $object->getGoalsNotCompletedCount();
        $output->goalsNotCompletedPercent = $object->getGoalsNotCompletedPercent();
        $output->name = $object->getName();
        $output->notesCount = $object->getNotesCount();
        $output->remindersCount = $object->getRemindersCount();
        $output->rewardsCount = $object->getRewardsCount();
        $output->sentRemindersCount = $object->getSentRemindersCount();
        $output->sentRemindersPercent = $object->getSentRemindersPercent();

        return $output;
    }

    public function supportsTransformation($data, string $to, array $context = []): bool
    {
        return (RoutineCollectionOutput::class === $to) && ($data instanceof Routine);
    }
}
