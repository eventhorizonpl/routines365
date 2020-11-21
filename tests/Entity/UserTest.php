<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use App\Entity\Account;
use App\Entity\CompletedRoutine;
use App\Entity\Contact;
use App\Entity\Goal;
use App\Entity\Note;
use App\Entity\Profile;
use App\Entity\Project;
use App\Entity\Reminder;
use App\Entity\Reward;
use App\Entity\Routine;
use App\Entity\SavedEmail;
use App\Entity\User;
use App\Tests\AbstractTestCase;
use DateTimeImmutable;
use Symfony\Component\Uid\Uuid;

class UserTest extends AbstractTestCase
{
    public function testConstruct()
    {
        $user = new User();
        $this->assertInstanceOf(User::class, $user);
    }

    public function testToString()
    {
        $uuid = (string) Uuid::v4();
        $user = new User();
        $user->setUuid($uuid);
        $this->assertEquals($uuid, $user->__toString());
    }

    public function testSerialize()
    {
        $email = 'test email';
        $password = 'test password';
        $user = new User();
        $user->setEmail($email);
        $user->setPassword($password);
        $this->assertIsArray($user->__serialize());
    }

    public function testUnserialize()
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
        $this->assertEquals($email, $user->getEmail());
        $this->assertEquals($id, $user->getId());
        $this->assertEquals($password, $user->getPassword());
    }

    public function testGetId()
    {
        $user = new User();
        $this->assertEquals(null, $user->getId());
    }

    public function testGetUuid()
    {
        $uuid = (string) Uuid::v4();
        $user = new User();
        $this->assertEquals(null, $user->getUuid());
        $user->setUuid($uuid);
        $this->assertEquals($uuid, $user->getUuid());
        $this->assertIsString($user->getUuid());
    }

    public function testSetUuid()
    {
        $uuid = (string) Uuid::v4();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setUuid($uuid));
        $this->assertEquals($uuid, $user->getUuid());
    }

    public function testGetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $user = new User();
        $this->assertEquals(null, $user->getCreatedBy());
        $user->setCreatedBy($createdBy);
        $this->assertEquals($createdBy, $user->getCreatedBy());
        $this->assertIsString($user->getCreatedBy());
    }

    public function testSetCreatedBy()
    {
        $createdBy = (string) Uuid::v4();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setCreatedBy($createdBy));
        $this->assertEquals($createdBy, $user->getCreatedBy());
    }

    public function testGetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $user = new User();
        $this->assertEquals(null, $user->getDeletedBy());
        $user->setDeletedBy($deletedBy);
        $this->assertEquals($deletedBy, $user->getDeletedBy());
        $this->assertIsString($user->getDeletedBy());
    }

    public function testSetDeletedBy()
    {
        $deletedBy = (string) Uuid::v4();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setDeletedBy($deletedBy));
        $this->assertEquals($deletedBy, $user->getDeletedBy());
    }

    public function testGetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $user = new User();
        $this->assertEquals(null, $user->getUpdatedBy());
        $user->setUpdatedBy($updatedBy);
        $this->assertEquals($updatedBy, $user->getUpdatedBy());
        $this->assertIsString($user->getUpdatedBy());
    }

    public function testSetUpdatedBy()
    {
        $updatedBy = (string) Uuid::v4();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setUpdatedBy($updatedBy));
        $this->assertEquals($updatedBy, $user->getUpdatedBy());
    }

    public function testGetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $user = new User();
        $this->assertEquals(null, $user->getCreatedAt());
        $user->setCreatedAt($createdAt);
        $this->assertEquals($createdAt, $user->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $createdAt = new DateTimeImmutable();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setCreatedAt($createdAt));
        $this->assertEquals($createdAt, $user->getCreatedAt());
    }

    public function testGetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $user = new User();
        $this->assertEquals(null, $user->getDeletedAt());
        $user->setDeletedAt($deletedAt);
        $this->assertEquals($deletedAt, $user->getDeletedAt());
    }

    public function testSetDeletedAt()
    {
        $deletedAt = new DateTimeImmutable();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setDeletedAt($deletedAt));
        $this->assertEquals($deletedAt, $user->getDeletedAt());
    }

    public function testGetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $user = new User();
        $this->assertEquals(null, $user->getUpdatedAt());
        $user->setUpdatedAt($updatedAt);
        $this->assertEquals($updatedAt, $user->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $updatedAt = new DateTimeImmutable();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setUpdatedAt($updatedAt));
        $this->assertEquals($updatedAt, $user->getUpdatedAt());
    }

    public function testGetIsEnabled()
    {
        $isEnabled = true;
        $user = new User();
        $this->assertEquals(false, $user->getIsEnabled());
        $user->setIsEnabled($isEnabled);
        $this->assertEquals($isEnabled, $user->getIsEnabled());
        $this->assertIsBool($user->getIsEnabled());
    }

    public function testSetIsEnabled()
    {
        $isEnabled = true;
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setIsEnabled($isEnabled));
        $this->assertEquals($isEnabled, $user->getIsEnabled());
    }

    public function testGetIsVerified()
    {
        $isVerified = true;
        $user = new User();
        $this->assertEquals(false, $user->getIsVerified());
        $user->setIsVerified($isVerified);
        $this->assertEquals($isVerified, $user->getIsVerified());
        $this->assertIsBool($user->getIsVerified());
    }

    public function testSetIsVerified()
    {
        $isVerified = true;
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setIsVerified($isVerified));
        $this->assertEquals($isVerified, $user->getIsVerified());
    }

    public function testGetAccount()
    {
        $account = new Account();
        $user = new User();
        $user->setAccount($account);
        $this->assertEquals($account, $user->getAccount());
    }

    public function testSetAccount()
    {
        $account = new Account();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setAccount($account));
        $this->assertEquals($account, $user->getAccount());
    }

    public function testAddCompletedRoutine()
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

    public function testGetCompletedRoutines()
    {
        $user = new User();
        $this->assertCount(0, $user->getCompletedRoutines());
        $completedRoutine = new CompletedRoutine();
        $this->assertInstanceOf(User::class, $user->addCompletedRoutine($completedRoutine));
        $this->assertCount(1, $user->getCompletedRoutines());
    }

    public function testGetCompletedRoutinesAll()
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

    public function testRemoveCompletedRoutine()
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

    public function testAddContact()
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

    public function testGetContacts()
    {
        $user = new User();
        $this->assertCount(0, $user->getContacts());
        $contact = new Contact();
        $this->assertInstanceOf(User::class, $user->addContact($contact));
        $this->assertCount(1, $user->getContacts());
    }

    public function testGetContactsAll()
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

    public function testRemoveContact()
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

    public function testEraseCredentials()
    {
        $user = new User();
        $this->assertEquals(null, $user->eraseCredentials());
    }

    public function testGetEmail()
    {
        $email = 'test email';
        $user = new User();
        $this->assertEquals(null, $user->getEmail());
        $user->setEmail($email);
        $this->assertEquals($email, $user->getEmail());
        $this->assertIsString($user->getEmail());
    }

    public function testSetEmail()
    {
        $email = 'test email';
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setEmail($email));
        $this->assertEquals($email, $user->getEmail());
    }

    public function testAddGoal()
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

    public function testGetGoals()
    {
        $user = new User();
        $this->assertCount(0, $user->getGoals());
        $goal = new Goal();
        $this->assertInstanceOf(User::class, $user->addGoal($goal));
        $this->assertCount(1, $user->getGoals());
    }

    public function testGetGoalsAll()
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

    public function testRemoveGoal()
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

    public function testGetLastLoginAt()
    {
        $lastLoginAt = new DateTimeImmutable();
        $user = new User();
        $this->assertEquals(null, $user->getLastLoginAt());
        $user->setLastLoginAt($lastLoginAt);
        $this->assertEquals($lastLoginAt, $user->getLastLoginAt());
    }

    public function testSetLastLoginAt()
    {
        $lastLoginAt = new DateTimeImmutable();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setLastLoginAt($lastLoginAt));
        $this->assertEquals($lastLoginAt, $user->getLastLoginAt());
    }

    public function testAddNote()
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

    public function testGetNotes()
    {
        $user = new User();
        $this->assertCount(0, $user->getNotes());
        $note = new Note();
        $this->assertInstanceOf(User::class, $user->addNote($note));
        $this->assertCount(1, $user->getNotes());
    }

    public function testGetNotesAll()
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

    public function testRemoveNote()
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

    public function testGetPassword()
    {
        $password = 'test password';
        $user = new User();
        $user->setPassword($password);
        $this->assertEquals($password, $user->getPassword());
        $this->assertIsString($user->getPassword());
    }

    public function testSetPassword()
    {
        $password = 'test password';
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setPassword($password));
        $this->assertEquals($password, $user->getPassword());
    }

    public function testGetProfile()
    {
        $profile = new Profile();
        $user = new User();
        $user->setProfile($profile);
        $this->assertEquals($profile, $user->getProfile());
    }

    public function testSetProfile()
    {
        $profile = new Profile();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setProfile($profile));
        $this->assertEquals($profile, $user->getProfile());
    }

    public function testAddProject()
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

    public function testGetProjects()
    {
        $user = new User();
        $this->assertCount(0, $user->getProjects());
        $project = new Project();
        $this->assertInstanceOf(User::class, $user->addProject($project));
        $this->assertCount(1, $user->getProjects());
    }

    public function testGetProjectsAll()
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

    public function testRemoveProject()
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

    public function testAddRecommendation()
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

    public function testGetRecommendations()
    {
        $user = new User();
        $this->assertCount(0, $user->getRecommendations());
        $recommendation = new User();
        $this->assertInstanceOf(User::class, $user->addRecommendation($recommendation));
        $this->assertCount(1, $user->getRecommendations());
    }

    public function testGetRecommendationsAll()
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

    public function testRemoveRecommendation()
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

    public function testGetReferrer()
    {
        $referrer = new User();
        $user = new User();
        $user->setReferrer($referrer);
        $this->assertEquals($referrer, $user->getReferrer());
    }

    public function testSetReferrer()
    {
        $referrer = new User();
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setReferrer($referrer));
        $this->assertEquals($referrer, $user->getReferrer());
    }

    public function testGetReferrerCode()
    {
        $referrerCode = 'test referrer code';
        $user = new User();
        $user->setReferrerCode($referrerCode);
        $this->assertEquals($referrerCode, $user->getReferrerCode());
        $this->assertIsString($user->getReferrerCode());
    }

    public function testSetReferrerCode()
    {
        $referrerCode = 'test referrer code';
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setReferrerCode($referrerCode));
        $this->assertEquals($referrerCode, $user->getReferrerCode());
    }

    public function testAddReminder()
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

    public function testGetReminders()
    {
        $user = new User();
        $this->assertCount(0, $user->getReminders());
        $reminder = new Reminder();
        $this->assertInstanceOf(User::class, $user->addReminder($reminder));
        $this->assertCount(1, $user->getReminders());
    }

    public function testGetRemindersAll()
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

    public function testRemoveReminder()
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

    public function testAddReward()
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

    public function testGetRewards()
    {
        $user = new User();
        $this->assertCount(0, $user->getRewards());
        $reward = new Reward();
        $this->assertInstanceOf(User::class, $user->addReward($reward));
        $this->assertCount(1, $user->getRewards());
    }

    public function testGetRewardsAll()
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

    public function testRemoveReward()
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

    public function testGetRoles()
    {
        $roles = [User::ROLE_USER];
        $user = new User();
        $user->setRoles($roles);
        $this->assertEquals($roles, $user->getRoles());
        $this->assertIsArray($user->getRoles());
    }

    public function testGetRolesFormChoices()
    {
        $this->assertCount(3, User::getRolesFormChoices());
        $this->assertIsArray(User::getRolesFormChoices());
    }

    public function testGetRolesValidationChoices()
    {
        $this->assertCount(3, User::getRolesValidationChoices());
        $this->assertIsArray(User::getRolesValidationChoices());
    }

    public function testSetRoles()
    {
        $roles = [User::ROLE_USER];
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setRoles($roles));
        $this->assertEquals($roles, $user->getRoles());
    }

    public function testAddRoutine()
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

    public function testGetRoutines()
    {
        $user = new User();
        $this->assertCount(0, $user->getRoutines());
        $routine = new Routine();
        $this->assertInstanceOf(User::class, $user->addRoutine($routine));
        $this->assertCount(1, $user->getRoutines());
    }

    public function testGetRoutinesAll()
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

    public function testRemoveRoutine()
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

    public function testGetSalt()
    {
        $user = new User();
        $this->assertEquals(null, $user->getSalt());
    }

    public function testAddSavedEmail()
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

    public function testGetSavedEmails()
    {
        $user = new User();
        $this->assertCount(0, $user->getSavedEmails());
        $savedEmail = new SavedEmail();
        $this->assertInstanceOf(User::class, $user->addSavedEmail($savedEmail));
        $this->assertCount(1, $user->getSavedEmails());
    }

    public function testGetSavedEmailsAll()
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

    public function testRemoveSavedEmail()
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

    public function testGetType()
    {
        $type = User::TYPE_CUSTOMER;
        $user = new User();
        $user->setType($type);
        $this->assertEquals($type, $user->getType());
        $this->assertIsString($user->getType());
    }

    public function testGetTypeFormChoices()
    {
        $this->assertCount(4, User::getTypeFormChoices());
        $this->assertIsArray(User::getTypeFormChoices());
    }

    public function testGetTypeValidationChoices()
    {
        $this->assertCount(4, User::getTypeValidationChoices());
        $this->assertIsArray(User::getTypeValidationChoices());
    }

    public function testSetType()
    {
        $type = User::TYPE_CUSTOMER;
        $user = new User();
        $this->assertInstanceOf(User::class, $user->setType($type));
        $this->assertEquals($type, $user->getType());
    }

    public function testGetUsername()
    {
        $email = 'test email';
        $user = new User();
        $this->assertEquals(null, $user->getUsername());
        $user->setEmail($email);
        $this->assertEquals($email, $user->getUsername());
        $this->assertIsString($user->getUsername());
    }
}
