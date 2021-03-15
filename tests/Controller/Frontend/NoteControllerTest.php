<?php

declare(strict_types=1);

namespace App\Tests\Controller\Frontend;

use App\Entity\Note;
use App\Entity\Routine;
use App\Entity\User;
use App\Tests\AbstractUiTestCase;

/**
 * @internal
 * @coversNothing
 */
final class NoteControllerTest extends AbstractUiTestCase
{
    public function createNote(User $user): Note
    {
        return $user->getNotes()->first();
    }

    public function createRoutine(User $user): Routine
    {
        return $user->getRoutines()->first();
    }

    public function testIndex(): void
    {
        $this->purge();
        $user = $this->createAndLoginRegular();

        $crawler = $this->client->request('GET', '/notes/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('p:contains("You do not have any notes!")')->count() > 0
        );

        $this->purge();
        $user = $this->createAndLoginRich();
        $note = $this->createNote($user);

        $crawler = $this->client->request('GET', '/notes/');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("'.$note->getTitle().'")')->count() > 0
        );
    }

    public function testNew(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();

        $crawler = $this->client->request('GET', '/notes/new/default');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create a note")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Title")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Routine")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Content")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('span:contains("This value should not be blank.")')->count() > 0
        );

        $title = 'test title';
        $content = 'test content';
        $crawler = $this->client->submitForm('Save', [
            'note[title]' => $title,
            'note[content]' => $content,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("'.$title.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("'.$content.'")')->count() > 0
        );
    }

    public function testNewRoutine(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $routine = $this->createRoutine($user);

        $crawler = $this->client->request('GET', '/notes/new/routine/'.$routine->getUuid());

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Create a note")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Title")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Content")')->count() > 0
        );

        $crawler = $this->client->submitForm('Save');

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('span:contains("This value should not be blank.")')->count() > 0
        );

        $title = 'test title';
        $content = 'test content';
        $crawler = $this->client->submitForm('Save', [
            'note[title]' => $title,
            'note[content]' => $content,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$title.'")')->count() > 0
        );
    }

    public function testShow(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $note = $this->createNote($user);

        $crawler = $this->client->request(
            'GET',
            '/notes/'.$note->getUuid()
        );

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("'.$note->getTitle().'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("'.$note->getContent().'")')->count() > 0
        );
    }

    public function testEdit(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $note = $this->createNote($user);

        $crawler = $this->client->request('GET', '/notes/'.$note->getUuid().'/default/edit');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a note")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Title")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Content")')->count() > 0
        );

        $title = 'test title';
        $content = 'test content';
        $crawler = $this->client->submitForm('Update', [
            'note[title]' => $title,
            'note[content]' => $content,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('div:contains("'.$title.'")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('p:contains("'.$content.'")')->count() > 0
        );
    }

    public function testEditRoutine(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $note = $this->createNote($user);

        $crawler = $this->client->request('GET', '/notes/'.$note->getUuid().'/routine/edit');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            $crawler->filter('div:contains("Edit a note")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Title")')->count() > 0
        );
        $this->assertTrue(
            $crawler->filter('label:contains("Content")')->count() > 0
        );

        $title = 'test title';
        $content = 'test content';
        $crawler = $this->client->submitForm('Update', [
            'note[title]' => $title,
            'note[content]' => $content,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertTrue(
            $crawler->filter('td:contains("'.$title.'")')->count() > 0
        );
    }

    public function testDelete(): void
    {
        $this->purge();
        $user = $this->createAndLoginRich();
        $note = $this->createNote($user);

        $crawler = $this->client->request('GET', '/notes/'.$note->getUuid().'/default/edit');

        $this->assertResponseIsSuccessful();

        $crawler = $this->client->submitForm('Delete');

        $this->assertResponseIsSuccessful();

        $this->assertTrue(
            0 === $crawler->filter('div:contains("'.$note->getTitle().'")')->count()
        );
    }
}
