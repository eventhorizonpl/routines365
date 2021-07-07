<?php

declare(strict_types=1);

namespace App\Tests\OpenApi;

use ApiPlatform\Core\Metadata\Property\{PropertyMetadata, PropertyNameCollection};
use ApiPlatform\Core\Metadata\Resource\{ResourceMetadata, ResourceNameCollection};
use ApiPlatform\Core\OpenApi\OpenApi;
use App\Entity\{Note, User};
use App\OpenApi\JwtDecorator;
use App\Tests\AbstractDoctrineTestCase;

/**
 * @internal
 */
final class JwtDecoratorTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?JwtDecorator $jwtDecorator;

    protected function tearDown(): void
    {
        $this->jwtDecorator = null;

        parent::tearDown();
    }

    public function testInvoke(): void
    {
        $openApi = $this->jwtDecorator->__invoke();

        $this->assertInstanceOf(OpenApi::class, $openApi);
    }
}
