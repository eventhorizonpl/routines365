<?php

declare(strict_types=1);

namespace App\Tests\Form\Admin;

use App\Entity\Contact;
use App\Form\Admin\ContactType;
use Symfony\Component\Form\Test\TypeTestCase;

final class ContactTypeTest extends TypeTestCase
{
    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData)
    {
        $model = new Contact();
        $form = $this->factory->create(ContactType::class, $model);
        $expected = new Contact();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView()
    {
        $formData = new Contact();
        $view = $this->factory->create(ContactType::class, $formData)
            ->createView();
        $this->assertSame($formData, $view->vars['data']);
        $this->assertSame($formData, $view->vars['value']);
    }

    public function getValidTestData(): array
    {
        return [
            [
                'data' => [
                    'comment' => 'test comment',
                    'content' => 'test content',
                    'status' => Contact::STATUS_CLOSED,
                    'title' => 'test title',
                    'type' => Contact::TYPE_QUESTION,
                ],
            ],
            [
                'data' => [
                    'content' => 'test content',
                    'status' => Contact::STATUS_CLOSED,
                    'title' => 'test title',
                    'type' => Contact::TYPE_QUESTION,
                ],
            ],
        ];
    }
}
