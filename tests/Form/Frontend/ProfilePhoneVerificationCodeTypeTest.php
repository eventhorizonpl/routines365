<?php

declare(strict_types=1);

namespace App\Tests\Form\Frontend;

use App\Form\Frontend\ProfilePhoneVerificationCodeType;
use App\Form\Model\ProfilePhoneVerificationCodeFormModel;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @internal
 */
final class ProfilePhoneVerificationCodeTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $model = new ProfilePhoneVerificationCodeFormModel();
        $form = $this->factory->create(ProfilePhoneVerificationCodeType::class, $model);
        $expected = new ProfilePhoneVerificationCodeFormModel();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView(): void
    {
        $formData = new ProfilePhoneVerificationCodeFormModel();
        $view = $this->factory->create(ProfilePhoneVerificationCodeType::class, $formData)
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
                    'phoneVerificationCode' => 123456,
                ],
            ],
        ];
    }
}
