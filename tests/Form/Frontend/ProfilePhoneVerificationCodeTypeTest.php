<?php

declare(strict_types=1);

namespace App\Tests\Form\Frontend;

use App\Form\Frontend\ProfilePhoneVerificationCodeType;
use App\Form\Model\ProfilePhoneVerificationCodeFormModel;
use Symfony\Component\Form\Test\TypeTestCase;

class ProfilePhoneVerificationCodeTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData)
    {
        $model = new ProfilePhoneVerificationCodeFormModel();
        $form = $this->factory->create(ProfilePhoneVerificationCodeType::class, $model);
        $expected = new ProfilePhoneVerificationCodeFormModel();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView()
    {
        $formData = new ProfilePhoneVerificationCodeFormModel();
        $view = $this->factory->create(ProfilePhoneVerificationCodeType::class, $formData)
            ->createView();
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
