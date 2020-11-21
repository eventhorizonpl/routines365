<?php

declare(strict_types=1);

namespace App\Tests\Form\Admin;

use App\Entity\User;
use App\Form\Admin\UserLeadType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class UserLeadTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData)
    {
        $model = new User();
        $form = $this->factory->create(UserLeadType::class, $model);
        $expected = new User();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView()
    {
        $formData = new User();
        $view = $this->factory->create(UserLeadType::class, $formData)
            ->createView();
        $this->assertSame($formData, $view->vars['data']);
        $this->assertSame($formData, $view->vars['value']);
    }

    protected function getExtensions()
    {
        $validator = Validation::createValidator();

        return [
            new ValidatorExtension($validator),
        ];
    }

    public function getValidTestData(): array
    {
        return [
            [
                'data' => [
                    'email' => 'test email',
                    'plainPassword' => 'test plainPassword',
                    'emailNotifications' => 10,
                    'smsNotifications' => 10,
                    'profile' => [
                        'showMotivationalMessages' => true,
                    ],
                ],
            ],
        ];
    }
}
