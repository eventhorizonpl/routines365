<?php

namespace App\Service\Sms;

use AsyncAws\Sns\Input\PublishInput;
use AsyncAws\Sns\SnsClient;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AmazonSnsService implements SmsServiceInterface
{
    private ParameterBagInterface $parameterBag;
    private SnsClient $snsClient;

    public function __construct(
        ParameterBagInterface $parameterBag
    ) {
        $this->snsClient = new SnsClient([
            'region' => $parameterBag->get('sns_region'),
            'accessKeyId' => $parameterBag->get('sns_access_key_id'),
            'accessKeySecret' => $parameterBag->get('sns_secret_access_key'),
        ]);
    }

    public function send(string $message, string $phone): string
    {
        $result = $this->snsClient->publish(new PublishInput([
            'Message' => $message,
            'PhoneNumber' => $phone,
        ]));

        return $result->getMessageId();
    }
}
