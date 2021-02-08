<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Entity\Routine;
use App\Entity\User;
use App\Tests\AbstractUiTestCase;

final class CompletedRoutineControllerTest extends AbstractUiTestCase
{
    public function createRoutine(User $user): Routine
    {
        $routine = $user->getRoutines()->first();

        return $routine;
    }

    public function testEdit(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $routine = $this->createRoutine($user);

        $crawler = $this->client->request('GET', '/completed-routines/'.$routine->getUuid().'/new');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Complete a routine")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Minutes devoted")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Comment")')->count() > 0
        );

        $minutesDevoted = 123;
        $comment = 'test comment';
        $crawler = $this->client->submitForm('Save', [
            'completed_routine[minutesDevoted]' => $minutesDevoted,
            'completed_routine[comment]' => $comment,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('span:contains("'.$minutesDevoted.'")')->count() > 0
        );
    }
}
