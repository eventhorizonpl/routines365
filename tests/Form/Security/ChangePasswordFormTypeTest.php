<?php

declare(strict_types=1);

namespace App\Tests\Form\Security;

use App\Form\Security\ChangePasswordFormType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

final class ChangePasswordFormTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $form = $this->factory->create(ChangePasswordFormType::class);
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    /**
     * @return ValidatorExtension[]
     *
     * @psalm-return array{0: ValidatorExtension}
     */
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
                    'plainPassword' => 'test123456',
                ],
            ],
        ];
    }
}
