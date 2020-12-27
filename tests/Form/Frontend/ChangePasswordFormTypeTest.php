<?php

declare(strict_types=1);

namespace App\Tests\Form\Frontend;

use App\Form\Frontend\ChangePasswordFormType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

final class ChangePasswordFormTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData)
    {
        $form = $this->factory->create(ChangePasswordFormType::class);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
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
                    'oldPassword' => 'test123',
                    'plainPassword' => 'test123456',
                ],
            ],
        ];
    }
}
