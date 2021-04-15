<?php

declare(strict_types=1);

namespace App\Tests\Form\Frontend;

use App\Entity\Project;
use App\Faker\UserFaker;
use App\Form\Frontend\ProjectType;
use App\Tests\AbstractTypeDoctrineTestCase;

/**
 * @internal
 */
final class ProjectTypeTest extends AbstractTypeDoctrineTestCase
{
    /**
     * @inject
     */
    private ?UserFaker $userFaker;

    protected function tearDown(): void
    {
        $this->userFaker = null;

        parent::tearDown();
    }

    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData(array $formData): void
    {
        $model = new Project();
        $form = $this->factory->create(ProjectType::class, $model);
        $expected = new Project();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    /**
     * @dataProvider getValidTestData
     */
    public function testSubmitValidData2(array $formData): void
    {
        $this->purge();
        $user = $this->userFaker->createRichUserPersisted();

        $model = $user->getProjects()->first();
        $form = $this->factory->create(ProjectType::class, $model);
        $expected = new Project();
        $form->submit($formData);
        $this->assertTrue($form->isSynchronized());
    }

    public function testCustomFormView(): void
    {
        $formData = new Project();
        $view = $this->factory->create(ProjectType::class, $formData)
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
                    'description' => 'test description',
                    'name' => 'test name',
                    'isCompleted' => true,
                ],
            ],
        ];
    }
}
