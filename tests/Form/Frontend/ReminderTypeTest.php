<?php

declare(strict_types=1);

namespace App\Tests\Form\Frontend;

use App\Entity\Reminder;
use App\Faker\UserFaker;
use App\Form\Frontend\ReminderType;
use App\Tests\AbstractTypeDoctrineTestCase;
use DateTimeImmutable;

/**
 * @internal
 */
final class ReminderTypeTest extends AbstractTypeDoctrineTestCase
{
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->userFaker = null;

        parent::tearDown();
    }

    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $model = $user->getReminders()->first();
        $form = $this->factory->create(ReminderType::class, $model);
        $expected = new Reminder();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView(): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $formData = $user->getReminders()->first();
        $view = $this->factory->create(ReminderType::class, $formData)
            ->createView()
        ;
        $this->assertSame($formData, $view->vars['data']);
        $this->assertSame($formData, $view->vars['value']);
    }

    public function getValidTestData(): array
    {
        return [
            [
                'data' => [
                    'hour' => new DateTimeImmutable(),
                    'isEnabled' => true,
                    'minutesBefore' => 5,
                    'sendEmail' => true,
                    'sendMotivationalMessage' => true,
                    'sendSms' => true,
                    'sendToBrowser' => true,
                    'type' => Reminder::TYPE_DAILY,
                ],
            ],
        ];
    }
}
