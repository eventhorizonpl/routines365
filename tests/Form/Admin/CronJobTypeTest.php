<?php

declare(strict_types=1);

namespace App\Tests\Form\Admin;

use App\Form\Admin\CronJobType;
use Cron\CronBundle\Entity\CronJob;
use Symfony\Component\Form\Test\TypeTestCase;

final class CronJobTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $model = new CronJob();
        $form = $this->factory->create(CronJobType::class, $model);
        $expected = new CronJob();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView(): void
    {
        $formData = new CronJob();
        $view = $this->factory->create(CronJobType::class, $formData)
            ->createView();

        $this->assertSame($formData, $view->vars['data']);
        $this->assertSame($formData, $view->vars['value']);
    }

    public function getValidTestData(): array
    {
        return [
            [
                'data' => [
                    'command' => 'test command',
                    'description' => 'test description',
                    'name' => 'test name',
                    'schedule' => 'test schedule',
                    'enabled' => true,
                ],
            ],
        ];
    }
}
