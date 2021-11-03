<?php

declare(strict_types=1);

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Dto\{QuoteCollectionOutput, QuoteItemOutput};
use App\Repository\QuoteRepository;
use App\Security\Voter\QuoteVoter;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ApiResource(
    collectionOperations: [
        'get' => [
            'output' => QuoteCollectionOutput::class,
        ],
    ],
    itemOperations: [
        'get' => [
            'output' => QuoteItemOutput::class,
            'security' => 'is_granted("'.QuoteVoter::VIEW.'", object)',
        ],
    ]
)]
#[ORM\Entity(repositoryClass: QuoteRepository::class)]
#[ORM\Index(name: 'string_length_idx', columns: ['string_length'])]
class Quote
{
    use Traits\BlameableTrait;
    use Traits\IdTrait;
    use Traits\IsVisibleTrait;
    use Traits\TimestampableTrait;
    use Traits\UuidTrait;

    #[Assert\Length(groups: ['form', 'system'], max: 64)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[ORM\Column(length: 64, type: Types::STRING)]
    private ?string $author;

    #[Assert\Length(groups: ['form', 'system'], max: 255)]
    #[Assert\NotBlank(groups: ['form', 'system'])]
    #[Assert\Type('string', groups: ['form', 'system'])]
    #[ORM\Column(type: Types::STRING)]
    private ?string $content;

    #[Assert\Length(groups: ['system'], max: 32)]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('string', groups: ['system'])]
    #[ORM\Column(length: 32, type: Types::STRING, unique: true)]
    private string $contentMd5;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $popularity;

    #[Assert\GreaterThanOrEqual(0, groups: ['system'])]
    #[Assert\LessThanOrEqual(336, groups: ['system'])]
    #[Assert\NotBlank(groups: ['system'])]
    #[Assert\Type('int', groups: ['system'])]
    #[ORM\Column(type: Types::INTEGER)]
    private int $stringLength;

    public function __construct()
    {
        $this->author = '';
        $this->content = '';
        $this->isVisible = false;
        $this->popularity = 0;
    }

    public function __toString(): string
    {
        return sprintf('"%s" - %s', $this->getContent(), $this->getAuthor());
    }

    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(?string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getContentMd5(): ?string
    {
        return $this->contentMd5;
    }

    public function setContentMd5(string $contentMd5): self
    {
        $contentMd5 = md5(preg_replace('/[^a-z0-9]/i', '', strtolower($contentMd5)));
        $this->contentMd5 = $contentMd5;

        return $this;
    }

    public function getPopularity(): int
    {
        return $this->popularity;
    }

    public function incrementPopularity(): self
    {
        $this->setPopularity($this->getPopularity() + 1);

        return $this;
    }

    public function setPopularity(int $popularity): self
    {
        $this->popularity = $popularity;

        return $this;
    }

    public function getStringLength(): ?int
    {
        return $this->stringLength;
    }

    public function setStringLength(int $stringLength): self
    {
        $this->stringLength = $stringLength;

        return $this;
    }
}
