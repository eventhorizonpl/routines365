<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\{Account, Achievement, CompletedRoutine, Contact, Goal, Note, Profile, Project, Promotion, Reminder, Reward, Routine, SavedEmail, Testimonial, User, UserKpi, UserKyt, UserQuestionnaire};
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use InvalidArgumentException;
use Symfony\Component\Uid\Uuid;

/**
 * @internal
 * @coversNothing
 */
final class UserTest extends AbstractTestCase
{
    public function testConstruct(): void
    {
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
    }

    public function testToString(): void
    {
        $uuid = (string) Uuid::v4();
        $user = new User();
        $user->setUuid($uuid);
        $this->assertSame($uuid, $user->__toString());
    }

    public function testSerialize(): void
    {
        $email = 'test email';
        $password = 'test password';
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);
        $this->assertIsArray($user->__serialize());
    }

    public function testUnserialize(): void
    {
        $id = 1;
        $email = 'test email';
        $password = 'test password';
        $data = [
            'id' => $id,
            'email' => $email,
            'password' => $password,
        ];
        $user = new User();
        $user->__unserialize($data);
        $this->assertSame($email, $user->getEmail());
        $this->assertSame($id, $user->getId());
        $this->assertSame($password, $user->getPassword());
    }

    public function testGetId(): void
    {
        $user = new User();
        $this->assertNull($user->getId());
    }

    public function testGetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $user = new User();
        $this->assertNull($user->getUuid());
        $user->setUuid($uuid);
        $this->assertSame($uuid, $user->getUuid());
        $this->assertIsString($user->getUuid());
    }

    public function testSetUuid(): void
    {
        $uuid = (string) Uuid::v4();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setUuid($uuid));
        $this->assertSame($uuid, $user->getUuid());
    }

    public function testGetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $user = new User();
        $this->assertNull($user->getCreatedBy());
        $user->setCreatedBy($createdBy);
        $this->assertSame($createdBy, $user->getCreatedBy());
        $this->assertIsString($user->getCreatedBy());
    }

    public function testSetCreatedBy(): void
    {
        $createdBy = (string) Uuid::v4();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setCreatedBy($createdBy));
        $this->assertSame($createdBy, $user->getCreatedBy());
    }

    public function testGetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $user = new User();
        $this->assertNull($user->getDeletedBy());
        $user->setDeletedBy($deletedBy);
        $this->assertSame($deletedBy, $user->getDeletedBy());
        $this->assertIsString($user->getDeletedBy());
    }

    public function testSetDeletedBy(): void
    {
        $deletedBy = (string) Uuid::v4();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setDeletedBy($deletedBy));
        $this->assertSame($deletedBy, $user->getDeletedBy());
    }

    public function testGetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $user = new User();
        $this->assertNull($user->getUpdatedBy());
        $user->setUpdatedBy($updatedBy);
        $this->assertSame($updatedBy, $user->getUpdatedBy());
        $this->assertIsString($user->getUpdatedBy());
    }

    public function testSetUpdatedBy(): void
    {
        $updatedBy = (string) Uuid::v4();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setUpdatedBy($updatedBy));
        $this->assertSame($updatedBy, $user->getUpdatedBy());
    }

    public function testGetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $user = new User();
        $this->assertNull($user->getCreatedAt());
        $user->setCreatedAt($createdAt);
        $this->assertSame($createdAt, $user->getCreatedAt());
    }

    public function testSetCreatedAt(): void
    {
        $createdAt = new DateTimeImmutable();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setCreatedAt($createdAt));
        $this->assertSame($createdAt, $user->getCreatedAt());
    }

    public function testGetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $user = new User();
        $this->assertNull($user->getDeletedAt());
        $user->setDeletedAt($deletedAt);
        $this->assertSame($deletedAt, $user->getDeletedAt());
    }

    public function testSetDeletedAt(): void
    {
        $deletedAt = new DateTimeImmutable();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setDeletedAt($deletedAt));
        $this->assertSame($deletedAt, $user->getDeletedAt());
    }

    public function testGetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $user = new User();
        $this->assertNull($user->getUpdatedAt());
        $user->setUpdatedAt($updatedAt);
        $this->assertSame($updatedAt, $user->getUpdatedAt());
    }

    public function testSetUpdatedAt(): void
    {
        $updatedAt = new DateTimeImmutable();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setUpdatedAt($updatedAt));
        $this->assertSame($updatedAt, $user->getUpdatedAt());
    }

    public function testGetIsEnabled(): void
    {
        $isEnabled = true;
        $user = new User();
        $this->assertFalse($user->getIsEnabled());
        $user->setIsEnabled($isEnabled);
        $this->assertSame($isEnabled, $user->getIsEnabled());
        $this->assertIsBool($user->getIsEnabled());
    }

    public function testSetIsEnabled(): void
    {
        $isEnabled = true;
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setIsEnabled($isEnabled));
        $this->assertSame($isEnabled, $user->getIsEnabled());
    }

    public function testGetIsVerified(): void
    {
        $isVerified = true;
        $user = new User();
        $this->assertFalse($user->getIsVerified());
        $user->setIsVerified($isVerified);
        $this->assertSame($isVerified, $user->getIsVerified());
        $this->assertIsBool($user->getIsVerified());
    }

    public function testSetIsVerified(): void
    {
        $isVerified = true;
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setIsVerified($isVerified));
        $this->assertSame($isVerified, $user->getIsVerified());
    }

    public function testGetAccount(): void
    {
        $account = new Account();
        $user = new User();
        $user->setAccount($account);
        $this->assertSame($account, $user->getAccount());
    }

    public function testSetAccount(): void
    {
        $account = new Account();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setAccount($account));
        $this->assertSame($account, $user->getAccount());
    }

    public function testAddAchievement(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getAchievements());
        $achievement1 = new Achievement();
        $this->assertInstanceOf(User::class, $user->addAchievement($achievement1));
        $this->assertCount(1, $user->getAchievements());
        $achievement2 = new Achievement();
        $this->assertInstanceOf(User::class, $user->addAchievement($achievement2));
        $this->assertCount(2, $user->getAchievements());
    }

    public function testGetAchievements(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getAchievements());
        $achievement = new Achievement();
        $this->assertInstanceOf(User::class, $user->addAchievement($achievement));
        $this->assertCount(1, $user->getAchievements());
    }

    public function testHasAchievement(): void
    {
        $user = new User();
        $achievement = new Achievement();
        $this->assertFalse($user->hasAchievement($achievement));
        $this->assertInstanceOf(User::class, $user->addAchievement($achievement));
        $this->assertTrue($user->hasAchievement($achievement));
        $this->assertIsBool($user->hasAchievement($achievement));
    }

    public function testRemoveAchievement(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getAchievements());
        $achievement1 = new Achievement();
        $this->assertInstanceOf(User::class, $user->addAchievement($achievement1));
        $this->assertCount(1, $user->getAchievements());
        $achievement2 = new Achievement();
        $this->assertInstanceOf(User::class, $user->addAchievement($achievement2));
        $this->assertCount(2, $user->getAchievements());
        $this->assertInstanceOf(User::class, $user->removeAchievement($achievement1));
    }

    public function testGetApiToken(): void
    {
        $apiToken = 'test apiToken';
        $user = new User();
        $this->assertNull($user->getApiToken());
        $user->setApiToken($apiToken);
        $this->assertSame($apiToken, $user->getApiToken());
        $this->assertIsString($user->getApiToken());
    }

    public function testSetApiToken(): void
    {
        $apiToken = 'test apiToken';
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setApiToken($apiToken));
        $this->assertSame($apiToken, $user->getApiToken());
    }

    public function testAddCompletedRoutine(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getCompletedRoutines());
        $completedRoutine1 = new CompletedRoutine();
        $this->assertInstanceOf(User::class, $user->addCompletedRoutine($completedRoutine1));
        $this->assertCount(1, $user->getCompletedRoutines());
        $completedRoutine2 = new CompletedRoutine();
        $this->assertInstanceOf(User::class, $user->addCompletedRoutine($completedRoutine2));
        $this->assertCount(2, $user->getCompletedRoutines());
        $deletedAt = new DateTimeImmutable();
        $completedRoutine2->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getCompletedRoutines());
    }

    public function testGetCompletedRoutines(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getCompletedRoutines());
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(User::class, $user->addCompletedRoutine($completedRoutine));
        $this->assertCount(1, $user->getCompletedRoutines());
    }

    public function testGetCompletedRoutinesAll(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getCompletedRoutinesAll());
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(User::class, $user->addCompletedRoutine($completedRoutine));
        $this->assertCount(1, $user->getCompletedRoutinesAll());
        $deletedAt = new DateTimeImmutable();
        $completedRoutine->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getCompletedRoutinesAll());
    }

    public function testRemoveCompletedRoutine(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getCompletedRoutines());
        $completedRoutine1 = new CompletedRoutine();
        $this->assertInstanceOf(User::class, $user->addCompletedRoutine($completedRoutine1));
        $this->assertCount(1, $user->getCompletedRoutines());
        $completedRoutine2 = new CompletedRoutine();
        $this->assertInstanceOf(User::class, $user->addCompletedRoutine($completedRoutine2));
        $this->assertCount(2, $user->getCompletedRoutines());
        $this->assertInstanceOf(User::class, $user->removeCompletedRoutine($completedRoutine1));
    }

    public function testAddContact(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getContacts());
        $contact1 = new Contact();
        $this->assertInstanceOf(User::class, $user->addContact($contact1));
        $this->assertCount(1, $user->getContacts());
        $contact2 = new Contact();
        $this->assertInstanceOf(User::class, $user->addContact($contact2));
        $this->assertCount(2, $user->getContacts());
        $deletedAt = new DateTimeImmutable();
        $contact2->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getContacts());
    }

    public function testGetContacts(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getContacts());
        $contact = new Contact();
        $this->assertInstanceOf(User::class, $user->addContact($contact));
        $this->assertCount(1, $user->getContacts());
    }

    public function testGetContactsAll(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getContactsAll());
        $contact = new Contact();
        $this->assertInstanceOf(User::class, $user->addContact($contact));
        $this->assertCount(1, $user->getContactsAll());
        $deletedAt = new DateTimeImmutable();
        $contact->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getContactsAll());
    }

    public function testRemoveContact(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getContacts());
        $contact1 = new Contact();
        $this->assertInstanceOf(User::class, $user->addContact($contact1));
        $this->assertCount(1, $user->getContacts());
        $contact2 = new Contact();
        $this->assertInstanceOf(User::class, $user->addContact($contact2));
        $this->assertCount(2, $user->getContacts());
        $this->assertInstanceOf(User::class, $user->removeContact($contact1));
    }

    public function testEraseCredentials(): void
    {
        $user = new User();
        $this->assertNull($user->eraseCredentials());
    }

    public function testGetEmail(): void
    {
        $email = 'test email';
        $user = new User();
        $this->assertSame('', $user->getEmail());
        $user->setEmail($email);
        $this->assertSame($email, $user->getEmail());
        $this->assertIsString($user->getEmail());
    }

    public function testSetEmail(): void
    {
        $email = 'test email';
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setEmail($email));
        $this->assertSame($email, $user->getEmail());
    }

    public function testAddGoal(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getGoals());
        $goal1 = new Goal();
        $this->assertInstanceOf(User::class, $user->addGoal($goal1));
        $this->assertCount(1, $user->getGoals());
        $goal2 = new Goal();
        $this->assertInstanceOf(User::class, $user->addGoal($goal2));
        $this->assertCount(2, $user->getGoals());
        $deletedAt = new DateTimeImmutable();
        $goal2->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getGoals());
    }

    public function testGetGoals(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getGoals());
        $goal = new Goal();
        $this->assertInstanceOf(User::class, $user->addGoal($goal));
        $this->assertCount(1, $user->getGoals());
    }

    public function testGetGoalsAll(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getGoalsAll());
        $goal = new Goal();
        $this->assertInstanceOf(User::class, $user->addGoal($goal));
        $this->assertCount(1, $user->getGoalsAll());
        $deletedAt = new DateTimeImmutable();
        $goal->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getGoalsAll());
    }

    public function testGetGoalsCompleted(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getGoalsCompleted());
        $goal = new Goal();
        $this->assertInstanceOf(User::class, $user->addGoal($goal));
        $this->assertCount(0, $user->getGoalsCompleted());
        $completedAt = new DateTimeImmutable();
        $goal->setCompletedAt($completedAt);
        $goal->setIsCompleted(true);
        $this->assertCount(1, $user->getGoalsCompleted());
    }

    public function testRemoveGoal(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getGoals());
        $goal1 = new Goal();
        $this->assertInstanceOf(User::class, $user->addGoal($goal1));
        $this->assertCount(1, $user->getGoals());
        $goal2 = new Goal();
        $this->assertInstanceOf(User::class, $user->addGoal($goal2));
        $this->assertCount(2, $user->getGoals());
        $this->assertInstanceOf(User::class, $user->removeGoal($goal1));
    }

    public function testIsGoogleAuthenticatorEnabled(): void
    {
        $googleAuthenticatorSecret = 'test googleAuthenticatorSecret';
        $user = new User();
        $this->assertFalse($user->isGoogleAuthenticatorEnabled());
        $user->setGoogleAuthenticatorSecret($googleAuthenticatorSecret);
        $this->assertTrue($user->isGoogleAuthenticatorEnabled());
        $this->assertIsBool($user->isGoogleAuthenticatorEnabled());
    }

    public function testGetGoogleAuthenticatorUsername(): void
    {
        $email = 'test email';
        $user = new User();
        $user->setEmail($email);
        $this->assertSame($email, $user->getGoogleAuthenticatorUsername());
        $this->assertIsString($user->getGoogleAuthenticatorUsername());
    }

    public function testGetGoogleAuthenticatorSecret(): void
    {
        $googleAuthenticatorSecret = 'test googleAuthenticatorSecret';
        $user = new User();
        $this->assertNull($user->getGoogleAuthenticatorSecret());
        $user->setGoogleAuthenticatorSecret($googleAuthenticatorSecret);
        $this->assertSame($googleAuthenticatorSecret, $user->getGoogleAuthenticatorSecret());
        $this->assertIsString($user->getGoogleAuthenticatorSecret());
    }

    public function testSetGoogleAuthenticatorSecret(): void
    {
        $googleAuthenticatorSecret = 'test googleAuthenticatorSecret';
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setGoogleAuthenticatorSecret($googleAuthenticatorSecret));
        $this->assertSame($googleAuthenticatorSecret, $user->getGoogleAuthenticatorSecret());
    }

    public function testGetLastLoginAt(): void
    {
        $lastLoginAt = new DateTimeImmutable();
        $user = new User();
        $this->assertNull($user->getLastLoginAt());
        $user->setLastLoginAt($lastLoginAt);
        $this->assertSame($lastLoginAt, $user->getLastLoginAt());
    }

    public function testSetLastLoginAt(): void
    {
        $lastLoginAt = new DateTimeImmutable();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setLastLoginAt($lastLoginAt));
        $this->assertSame($lastLoginAt, $user->getLastLoginAt());
    }

    public function testAddNote(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getNotes());
        $note1 = new Note();
        $this->assertInstanceOf(User::class, $user->addNote($note1));
        $this->assertCount(1, $user->getNotes());
        $note2 = new Note();
        $this->assertInstanceOf(User::class, $user->addNote($note2));
        $this->assertCount(2, $user->getNotes());
        $deletedAt = new DateTimeImmutable();
        $note2->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getNotes());
    }

    public function testGetNotes(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getNotes());
        $note = new Note();
        $this->assertInstanceOf(User::class, $user->addNote($note));
        $this->assertCount(1, $user->getNotes());
    }

    public function testGetNotesAll(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getNotesAll());
        $note = new Note();
        $this->assertInstanceOf(User::class, $user->addNote($note));
        $this->assertCount(1, $user->getNotesAll());
        $deletedAt = new DateTimeImmutable();
        $note->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getNotesAll());
    }

    public function testRemoveNote(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getNotes());
        $note1 = new Note();
        $this->assertInstanceOf(User::class, $user->addNote($note1));
        $this->assertCount(1, $user->getNotes());
        $note2 = new Note();
        $this->assertInstanceOf(User::class, $user->addNote($note2));
        $this->assertCount(2, $user->getNotes());
        $this->assertInstanceOf(User::class, $user->removeNote($note1));
    }

    public function testGetPassword(): void
    {
        $password = 'test password';
        $user = new User();
        $user->setPassword($password);
        $this->assertSame($password, $user->getPassword());
        $this->assertIsString($user->getPassword());
    }

    public function testSetPassword(): void
    {
        $password = 'test password';
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setPassword($password));
        $this->assertSame($password, $user->getPassword());
    }

    public function testGetProfile(): void
    {
        $profile = new Profile();
        $user = new User();
        $user->setProfile($profile);
        $this->assertSame($profile, $user->getProfile());
    }

    public function testSetProfile(): void
    {
        $profile = new Profile();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setProfile($profile));
        $this->assertSame($profile, $user->getProfile());
    }

    public function testAddProject(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getProjects());
        $project1 = new Project();
        $this->assertInstanceOf(User::class, $user->addProject($project1));
        $this->assertCount(1, $user->getProjects());
        $project2 = new Project();
        $this->assertInstanceOf(User::class, $user->addProject($project2));
        $this->assertCount(2, $user->getProjects());
        $deletedAt = new DateTimeImmutable();
        $project2->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getProjects());
    }

    public function testGetProjects(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getProjects());
        $project = new Project();
        $this->assertInstanceOf(User::class, $user->addProject($project));
        $this->assertCount(1, $user->getProjects());
    }

    public function testGetProjectsAll(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getProjectsAll());
        $project = new Project();
        $this->assertInstanceOf(User::class, $user->addProject($project));
        $this->assertCount(1, $user->getProjectsAll());
        $deletedAt = new DateTimeImmutable();
        $project->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getProjectsAll());
    }

    public function testGetProjectsCompleted(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getProjectsCompleted());
        $project = new Project();
        $this->assertInstanceOf(User::class, $user->addProject($project));
        $this->assertCount(0, $user->getProjectsCompleted());
        $completedAt = new DateTimeImmutable();
        $project->setCompletedAt($completedAt);
        $project->setIsCompleted(true);
        $this->assertCount(1, $user->getProjectsCompleted());
    }

    public function testRemoveProject(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getProjects());
        $project1 = new Project();
        $this->assertInstanceOf(User::class, $user->addProject($project1));
        $this->assertCount(1, $user->getProjects());
        $project2 = new Project();
        $this->assertInstanceOf(User::class, $user->addProject($project2));
        $this->assertCount(2, $user->getProjects());
        $this->assertInstanceOf(User::class, $user->removeProject($project1));
    }

    public function testAddPromotion(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getPromotions());
        $promotion1 = new Promotion();
        $this->assertInstanceOf(User::class, $user->addPromotion($promotion1));
        $this->assertCount(1, $user->getPromotions());
        $promotion2 = new Promotion();
        $this->assertInstanceOf(User::class, $user->addPromotion($promotion2));
        $this->assertCount(2, $user->getPromotions());
    }

    public function testGetPromotions(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getPromotions());
        $promotion = new Promotion();
        $this->assertInstanceOf(User::class, $user->addPromotion($promotion));
        $this->assertCount(1, $user->getPromotions());
    }

    public function testHasPromotion(): void
    {
        $user = new User();
        $promotion = new Promotion();
        $this->assertFalse($user->hasPromotion($promotion));
        $this->assertInstanceOf(User::class, $user->addPromotion($promotion));
        $this->assertTrue($user->hasPromotion($promotion));
        $this->assertIsBool($user->hasPromotion($promotion));
    }

    public function testRemovePromotion(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getPromotions());
        $promotion1 = new Promotion();
        $this->assertInstanceOf(User::class, $user->addPromotion($promotion1));
        $this->assertCount(1, $user->getPromotions());
        $promotion2 = new Promotion();
        $this->assertInstanceOf(User::class, $user->addPromotion($promotion2));
        $this->assertCount(2, $user->getPromotions());
        $this->assertInstanceOf(User::class, $user->removePromotion($promotion1));
    }

    public function testAddRecommendation(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getRecommendations());
        $recommendation1 = new User();
        $this->assertInstanceOf(User::class, $user->addRecommendation($recommendation1));
        $this->assertCount(1, $user->getRecommendations());
        $recommendation2 = new User();
        $this->assertInstanceOf(User::class, $user->addRecommendation($recommendation2));
        $this->assertCount(2, $user->getRecommendations());
        $deletedAt = new DateTimeImmutable();
        $recommendation2->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getRecommendations());
    }

    public function testGetRecommendations(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getRecommendations());
        $recommendation = new User();
        $this->assertInstanceOf(User::class, $user->addRecommendation($recommendation));
        $this->assertCount(1, $user->getRecommendations());
    }

    public function testGetRecommendationsAll(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getRecommendationsAll());
        $recommendation = new User();
        $this->assertInstanceOf(User::class, $user->addRecommendation($recommendation));
        $this->assertCount(1, $user->getRecommendationsAll());
        $deletedAt = new DateTimeImmutable();
        $recommendation->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getRecommendationsAll());
    }

    public function testRemoveRecommendation(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getRecommendations());
        $recommendation1 = new User();
        $this->assertInstanceOf(User::class, $user->addRecommendation($recommendation1));
        $this->assertCount(1, $user->getRecommendations());
        $recommendation2 = new User();
        $this->assertInstanceOf(User::class, $user->addRecommendation($recommendation2));
        $this->assertCount(2, $user->getRecommendations());
        $this->assertInstanceOf(User::class, $user->removeRecommendation($recommendation1));
    }

    public function testGetReferrer(): void
    {
        $referrer = new User();
        $user = new User();
        $user->setReferrer($referrer);
        $this->assertSame($referrer, $user->getReferrer());
    }

    public function testSetReferrer(): void
    {
        $referrer = new User();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setReferrer($referrer));
        $this->assertSame($referrer, $user->getReferrer());
    }

    public function testGetReferrerCode(): void
    {
        $referrerCode = 'test referrer code';
        $user = new User();
        $user->setReferrerCode($referrerCode);
        $this->assertSame($referrerCode, $user->getReferrerCode());
        $this->assertIsString($user->getReferrerCode());
    }

    public function testSetReferrerCode(): void
    {
        $referrerCode = 'test referrer code';
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setReferrerCode($referrerCode));
        $this->assertSame($referrerCode, $user->getReferrerCode());
    }

    public function testAddReminder(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getReminders());
        $reminder1 = new Reminder();
        $this->assertInstanceOf(User::class, $user->addReminder($reminder1));
        $this->assertCount(1, $user->getReminders());
        $reminder2 = new Reminder();
        $this->assertInstanceOf(User::class, $user->addReminder($reminder2));
        $this->assertCount(2, $user->getReminders());
        $deletedAt = new DateTimeImmutable();
        $reminder2->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getReminders());
    }

    public function testGetReminders(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getReminders());
        $reminder = new Reminder();
        $this->assertInstanceOf(User::class, $user->addReminder($reminder));
        $this->assertCount(1, $user->getReminders());
    }

    public function testGetRemindersAll(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getRemindersAll());
        $reminder = new Reminder();
        $this->assertInstanceOf(User::class, $user->addReminder($reminder));
        $this->assertCount(1, $user->getRemindersAll());
        $deletedAt = new DateTimeImmutable();
        $reminder->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getRemindersAll());
    }

    public function testRemoveReminder(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getReminders());
        $reminder1 = new Reminder();
        $this->assertInstanceOf(User::class, $user->addReminder($reminder1));
        $this->assertCount(1, $user->getReminders());
        $reminder2 = new Reminder();
        $this->assertInstanceOf(User::class, $user->addReminder($reminder2));
        $this->assertCount(2, $user->getReminders());
        $this->assertInstanceOf(User::class, $user->removeReminder($reminder1));
    }

    public function testAddReward(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getRewards());
        $reward1 = new Reward();
        $this->assertInstanceOf(User::class, $user->addReward($reward1));
        $this->assertCount(1, $user->getRewards());
        $reward2 = new Reward();
        $this->assertInstanceOf(User::class, $user->addReward($reward2));
        $this->assertCount(2, $user->getRewards());
        $deletedAt = new DateTimeImmutable();
        $reward2->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getRewards());
    }

    public function testGetRewards(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getRewards());
        $reward = new Reward();
        $this->assertInstanceOf(User::class, $user->addReward($reward));
        $this->assertCount(1, $user->getRewards());
    }

    public function testGetRewardsAll(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getRewardsAll());
        $reward = new Reward();
        $this->assertInstanceOf(User::class, $user->addReward($reward));
        $this->assertCount(1, $user->getRewardsAll());
        $deletedAt = new DateTimeImmutable();
        $reward->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getRewardsAll());
    }

    public function testGetRewardsAwarded(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getRewardsAwarded());
        $reward = new Reward();
        $this->assertInstanceOf(User::class, $user->addReward($reward));
        $this->assertCount(0, $user->getRewardsAwarded());
        $reward->setIsAwarded(true);
        $this->assertCount(1, $user->getRewardsAwarded());
    }

    public function testRemoveReward(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getRewards());
        $reward1 = new Reward();
        $this->assertInstanceOf(User::class, $user->addReward($reward1));
        $this->assertCount(1, $user->getRewards());
        $reward2 = new Reward();
        $this->assertInstanceOf(User::class, $user->addReward($reward2));
        $this->assertCount(2, $user->getRewards());
        $this->assertInstanceOf(User::class, $user->removeReward($reward1));
    }

    public function testGetRoles(): void
    {
        $roles = [User::ROLE_USER];
        $user = new User();
        $user->setRoles($roles);
        $this->assertSame($roles, $user->getRoles());
        $this->assertIsArray($user->getRoles());
    }

    public function testGetRolesFormChoices(): void
    {
        $this->assertCount(3, User::getRolesFormChoices());
        $this->assertIsArray(User::getRolesFormChoices());
    }

    public function testGetRolesValidationChoices(): void
    {
        $this->assertCount(3, User::getRolesValidationChoices());
        $this->assertIsArray(User::getRolesValidationChoices());
    }

    public function testSetRoles(): void
    {
        $roles = [User::ROLE_USER];
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setRoles($roles));
        $this->assertSame($roles, $user->getRoles());
    }

    public function testAddRoutine(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getRoutines());
        $routine1 = new Routine();
        $this->assertInstanceOf(User::class, $user->addRoutine($routine1));
        $this->assertCount(1, $user->getRoutines());
        $routine2 = new Routine();
        $this->assertInstanceOf(User::class, $user->addRoutine($routine2));
        $this->assertCount(2, $user->getRoutines());
        $deletedAt = new DateTimeImmutable();
        $routine2->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getRoutines());
    }

    public function testGetRoutines(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getRoutines());
        $routine = new Routine();
        $this->assertInstanceOf(User::class, $user->addRoutine($routine));
        $this->assertCount(1, $user->getRoutines());
    }

    public function testGetRoutinesAll(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getRoutinesAll());
        $routine = new Routine();
        $this->assertInstanceOf(User::class, $user->addRoutine($routine));
        $this->assertCount(1, $user->getRoutinesAll());
        $deletedAt = new DateTimeImmutable();
        $routine->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getRoutinesAll());
    }

    public function testRemoveRoutine(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getRoutines());
        $routine1 = new Routine();
        $this->assertInstanceOf(User::class, $user->addRoutine($routine1));
        $this->assertCount(1, $user->getRoutines());
        $routine2 = new Routine();
        $this->assertInstanceOf(User::class, $user->addRoutine($routine2));
        $this->assertCount(2, $user->getRoutines());
        $this->assertInstanceOf(User::class, $user->removeRoutine($routine1));
    }

    public function testGetSalt(): void
    {
        $user = new User();
        $this->assertNull($user->getSalt());
    }

    public function testAddSavedEmail(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getSavedEmails());
        $savedEmail1 = new SavedEmail();
        $this->assertInstanceOf(User::class, $user->addSavedEmail($savedEmail1));
        $this->assertCount(1, $user->getSavedEmails());
        $savedEmail2 = new SavedEmail();
        $this->assertInstanceOf(User::class, $user->addSavedEmail($savedEmail2));
        $this->assertCount(2, $user->getSavedEmails());
        $deletedAt = new DateTimeImmutable();
        $savedEmail2->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getSavedEmails());
    }

    public function testGetSavedEmails(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getSavedEmails());
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(User::class, $user->addSavedEmail($savedEmail));
        $this->assertCount(1, $user->getSavedEmails());
    }

    public function testGetSavedEmailsAll(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getSavedEmailsAll());
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(User::class, $user->addSavedEmail($savedEmail));
        $this->assertCount(1, $user->getSavedEmailsAll());
        $deletedAt = new DateTimeImmutable();
        $savedEmail->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getSavedEmailsAll());
    }

    public function testRemoveSavedEmail(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getSavedEmails());
        $savedEmail1 = new SavedEmail();
        $this->assertInstanceOf(User::class, $user->addSavedEmail($savedEmail1));
        $this->assertCount(1, $user->getSavedEmails());
        $savedEmail2 = new SavedEmail();
        $this->assertInstanceOf(User::class, $user->addSavedEmail($savedEmail2));
        $this->assertCount(2, $user->getSavedEmails());
        $this->assertInstanceOf(User::class, $user->removeSavedEmail($savedEmail1));
    }

    public function testGetTestimonial(): void
    {
        $testimonial = new Testimonial();
        $user = new User();
        $user->setTestimonial($testimonial);
        $this->assertSame($testimonial, $user->getTestimonial());
    }

    public function testSetTestimonial(): void
    {
        $testimonial = new Testimonial();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setTestimonial($testimonial));
        $this->assertSame($testimonial, $user->getTestimonial());
    }

    public function testGetType(): void
    {
        $type = User::TYPE_CUSTOMER;
        $user = new User();
        $user->setType($type);
        $this->assertSame($type, $user->getType());
        $this->assertIsString($user->getType());
    }

    public function testGetTypeFormChoices(): void
    {
        $this->assertCount(4, User::getTypeFormChoices());
        $this->assertIsArray(User::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices(): void
    {
        $this->assertCount(4, User::getTypeValidationChoices());
        $this->assertIsArray(User::getTypeValidationChoices());
    }

    public function testSetType(): void
    {
        $type = User::TYPE_CUSTOMER;
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setType($type));
        $this->assertSame($type, $user->getType());
    }

    public function testSetTypeException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $type = 'wrong type';
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setType($type));
    }

    public function testAddUserKpi(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getUserKpis());
        $userKpi1 = new UserKpi();
        $this->assertInstanceOf(User::class, $user->addUserKpi($userKpi1));
        $this->assertCount(1, $user->getUserKpis());
        $userKpi2 = new UserKpi();
        $this->assertInstanceOf(User::class, $user->addUserKpi($userKpi2));
        $this->assertCount(2, $user->getUserKpis());
        $deletedAt = new DateTimeImmutable();
        $userKpi2->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getUserKpis());
    }

    public function testGetUserKpis(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getUserKpis());
        $userKpi = new UserKpi();
        $this->assertInstanceOf(User::class, $user->addUserKpi($userKpi));
        $this->assertCount(1, $user->getUserKpis());
    }

    public function testGetUserKpisAll(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getUserKpisAll());
        $userKpi = new UserKpi();
        $this->assertInstanceOf(User::class, $user->addUserKpi($userKpi));
        $this->assertCount(1, $user->getUserKpisAll());
        $deletedAt = new DateTimeImmutable();
        $userKpi->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getUserKpisAll());
    }

    public function testRemoveUserKpi(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getUserKpis());
        $userKpi1 = new UserKpi();
        $this->assertInstanceOf(User::class, $user->addUserKpi($userKpi1));
        $this->assertCount(1, $user->getUserKpis());
        $userKpi2 = new UserKpi();
        $this->assertInstanceOf(User::class, $user->addUserKpi($userKpi2));
        $this->assertCount(2, $user->getUserKpis());
        $this->assertInstanceOf(User::class, $user->removeUserKpi($userKpi1));
    }

    public function testGetUserKyt(): void
    {
        $userKyt = new UserKyt();
        $user = new User();
        $user->setUserKyt($userKyt);
        $this->assertSame($userKyt, $user->getUserKyt());
    }

    public function testSetUserKyt(): void
    {
        $userKyt = new UserKyt();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setUserKyt($userKyt));
        $this->assertSame($userKyt, $user->getUserKyt());
    }

    public function testGetUsername(): void
    {
        $email = 'test email';
        $user = new User();
        $this->assertSame('', $user->getUsername());
        $user->setEmail($email);
        $this->assertSame($email, $user->getUsername());
        $this->assertIsString($user->getUsername());
    }

    public function testAddUserQuestionnaire(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getUserQuestionnaires());
        $userQuestionnaire1 = new UserQuestionnaire();
        $this->assertInstanceOf(User::class, $user->addUserQuestionnaire($userQuestionnaire1));
        $this->assertCount(1, $user->getUserQuestionnaires());
        $userQuestionnaire2 = new UserQuestionnaire();
        $this->assertInstanceOf(User::class, $user->addUserQuestionnaire($userQuestionnaire2));
        $this->assertCount(2, $user->getUserQuestionnaires());
        $deletedAt = new DateTimeImmutable();
        $userQuestionnaire2->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getUserQuestionnaires());
    }

    public function testGetUserQuestionnaires(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getUserQuestionnaires());
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(User::class, $user->addUserQuestionnaire($userQuestionnaire));
        $this->assertCount(1, $user->getUserQuestionnaires());
    }

    public function testGetUserQuestionnairesAll(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getUserQuestionnairesAll());
        $userQuestionnaire = new UserQuestionnaire();
        $this->assertInstanceOf(User::class, $user->addUserQuestionnaire($userQuestionnaire));
        $this->assertCount(1, $user->getUserQuestionnairesAll());
        $deletedAt = new DateTimeImmutable();
        $userQuestionnaire->setDeletedAt($deletedAt);
        $this->assertCount(1, $user->getUserQuestionnairesAll());
    }

    public function testRemoveUserQuestionnaire(): void
    {
        $user = new User();
        $this->assertCount(0, $user->getUserQuestionnaires());
        $userQuestionnaire1 = new UserQuestionnaire();
        $this->assertInstanceOf(User::class, $user->addUserQuestionnaire($userQuestionnaire1));
        $this->assertCount(1, $user->getUserQuestionnaires());
        $userQuestionnaire2 = new UserQuestionnaire();
        $this->assertInstanceOf(User::class, $user->addUserQuestionnaire($userQuestionnaire2));
        $this->assertCount(2, $user->getUserQuestionnaires());
        $this->assertInstanceOf(User::class, $user->removeUserQuestionnaire($userQuestionnaire1));
    }
}
