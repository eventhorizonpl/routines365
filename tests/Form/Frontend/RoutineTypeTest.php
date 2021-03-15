<?php

declare(strict_types=1);

namespace App\Tests\Form\Frontend;

use App\Entity\Routine;
use App\Form\Frontend\RoutineType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @internal
 * @coversNothing
 */
final class RoutineTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $model = new Routine();
        $form = $this->factory->create(RoutineType::class, $model);
        $expected = new Routine();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView(): void
    {
        $formData = new Routine();
        $view = $this->factory->create(RoutineType::class, $formData)
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
                    'description' => 'test description',
                    'isEnabled' => true,
                    'name' => 'test name',
                    'type' => Routine::TYPE_HOBBY,
                ],
            ],
        ];
    }
}
