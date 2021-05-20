<?php

declare(strict_types=1);

namespace App\Tests\Form\Frontend;

use App\Entity\Contact;
use App\Enum\{ContactStatusEnum, ContactTypeEnum};
use App\Form\Frontend\ContactType;
use Symfony\Component\Form\Test\TypeTestCase;

/**
 * @internal
 */
final class ContactTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $model = new Contact();
        $form = $this->factory->create(ContactType::class, $model);
        $expected = new Contact();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView(): void
    {
        $formData = new Contact();
        $view = $this->factory->create(ContactType::class, $formData)
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
                    'content' => 'test content',
                    'title' => 'test title',
                    'type' => ContactTypeEnum::QUESTION,
                ],
            ],
        ];
    }
}
