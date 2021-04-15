<?php

declare(strict_types=1);

namespace App\Tests\Form\Admin;

use App\Entity\Achievement;
use App\Form\Admin\AchievementType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @internal
 */
final class AchievementTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $model = new Achievement();
        $form = $this->factory->create(AchievementType::class, $model);
        $expected = new Achievement();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView(): void
    {
        $formData = new Achievement();
        $view = $this->factory->create(AchievementType::class, $formData)
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
                    'name' => 'test name',
                    'description' => 'test description',
                    'isEnabled' => true,
                    'level' => 1,
                    'requirement' => 2,
                    'type' => Achievement::TYPE_COMPLETED_ROUTINE,
                ],
            ],
        ];
    }
}
