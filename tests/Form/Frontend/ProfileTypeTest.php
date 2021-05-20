<?php

declare(strict_types=1);

namespace App\Tests\Form\Frontend;

use App\Entity\Profile;
use App\Enum\ProfileThemeEnum;
use App\Form\Frontend\ProfileType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @internal
 */
final class ProfileTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $model = new Profile();
        $form = $this->factory->create(ProfileType::class, $model);
        $expected = new Profile();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView(): void
    {
        $formData = new Profile();
        $view = $this->factory->create(ProfileType::class, $formData)
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
                    'sendWeeklyMonthlyStatistics' => true,
                    'showMotivationalMessages' => true,
                    'theme' => ProfileThemeEnum::DARK,
                ],
            ],
        ];
    }
}
