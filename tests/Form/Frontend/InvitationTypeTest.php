<?php

declare(strict_types=1);

namespace App\Tests\Form\Frontend;

use App\Form\Frontend\InvitationType;
use App\Form\Model\InvitationEmailFormModel;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @internal
 */
final class InvitationTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $model = new InvitationEmailFormModel();
        $form = $this->factory->create(InvitationType::class, $model);
        $expected = new InvitationEmailFormModel();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView(): void
    {
        $formData = new InvitationEmailFormModel();
        $view = $this->factory->create(InvitationType::class, $formData)
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
                    'email' => 'a@b.com',
                ],
            ],
        ];
    }
}
