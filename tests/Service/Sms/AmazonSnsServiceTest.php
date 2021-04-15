<?php

declare(strict_types=1);

namespace App\Tests\Service\Sms;

use App\Service\Sms\AmazonSnsService;
use App\Tests\AbstractDoctrineTestCase;
use AsyncAws\Core\Exception\Http\NetworkException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * @internal
 */
final class AmazonSnsServiceTest extends AbstractDoctrineTestCase
{
    /**
     * @inject
     */
    private ?AmazonSnsService $amazonSnsService;

    protected function tearDown(): void
    {
        $this->amazonSnsService = null
        ;

        parent::tearDown();
    }

    public function testConstruct(): void
    {
        $parameterBag = new ParameterBag([
            'sns_region' => 'test sns_region',
            'sns_access_key_id' => 'test sns_access_key_id',
            'sns_secret_access_key' => 'test sns_secret_access_key',
        ]);

        $amazonSnsService = new AmazonSnsService($parameterBag);

        $this->assertInstanceOf(AmazonSnsService::class, $amazonSnsService);
    }

    public function testSend(): void
    {
        $this->expectException(NetworkException::class);
        $result = $this->amazonSnsService->send('test message', '+48881573056');
    }
}
