<?php

declare(strict_types=1);

namespace App\Tests\Form\Frontend;

use App\Entity\CompletedRoutine;
use App\Form\Frontend\CompletedRoutineType;
use DateTimeImmutable;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @internal
 */
final class CompletedRoutineTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $model = new CompletedRoutine();
        $form = $this->factory->create(CompletedRoutineType::class, $model);
        $expected = new CompletedRoutine();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView(): void
    {
        $formData = new CompletedRoutine();
        $view = $this->factory->create(CompletedRoutineType::class, $formData)
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
                    'comment' => 'test comment',
                    'date' => new DateTimeImmutable(),
                    'minutesDevoted' => 10,
                ],
            ],
        ];
    }
}
