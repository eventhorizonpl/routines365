<?php

namespace App\Entity;

use App\Repository\QuoteRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=QuoteRepository::class)
 * @ORM\Table(indexes={@ORM\Index(name="string_length_idx", columns={"string_length"}), @ORM\Index(name="type_idx", columns={"type"})})
 */
class Quote
{
    use Traits\IdTrait;
    use Traits\UuidTrait;
    use Traits\IsVisibleTrait;
    use Traits\BlameableTrait;
    use Traits\TimestampableTrait;

    public const TYPE_ART = 'art';
    public const TYPE_BUSINESS = 'business';
    public const TYPE_POLITICS = 'politics';
    public const TYPE_SPORT = 'sport';
    public const TYPE_TECHNOLOGY = 'technology';
    public const TYPE_UNKNOWN = 'unknown';

    /**
     * @Assert\Length(
     *   max = 64
     * )
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @ORM\Column(length=64, type="string")
     */
    private string $author;

    /**
     * @Assert\Length(
     *   max = 255
     * )
     * @Assert\NotBlank
     * @Assert\Type("string")
     * @ORM\Column(type="string")
     */
    private string $content;

    /**
     * @Assert\Length(
     *   max = 32
     * )
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("string")
     * @ORM\Column(length=32, type="string", unique=true)
     */
    private string $contentMd5;

    /**
     * @Assert\GreaterThanOrEqual(0)
     * @Assert\LessThanOrEqual(336)
     * @Assert\NotBlank(groups={"system"})
     * @Assert\Type("int")
     * @ORM\Column(type="integer")
     */
    private int $stringLength;

    /**
     * @Assert\Choice(callback="getTypeValidationChoices")
     * @Assert\Length(
     *   max = 16
     * )
     * @Assert\NotBlank()
     * @Assert\Type("string")
     * @ORM\Column(length=16, type="string")
     */
    private string $type;

    public function __construct()
    {
        $this->author = '';
        $this->content = '';
        $this->isVisible = false;
        $this->type = self::TYPE_UNKNOWN;
    }

    public function __toString(): string
    {
        return '“'.$this->getContent().'” – '.$this->getAuthor();
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
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

    public function getStringLength(): ?int
    {
        return $this->stringLength;
    }

    public function setStringLength(int $stringLength): self
    {
        $this->stringLength = $stringLength;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public static function getTypeFormChoices(): array
    {
        return [
            self::TYPE_ART => self::TYPE_ART,
            self::TYPE_BUSINESS => self::TYPE_BUSINESS,
            self::TYPE_POLITICS => self::TYPE_POLITICS,
            self::TYPE_SPORT => self::TYPE_SPORT,
            self::TYPE_TECHNOLOGY => self::TYPE_TECHNOLOGY,
            self::TYPE_UNKNOWN => self::TYPE_UNKNOWN,
        ];
    }

    public function getTypeValidationChoices(): array
    {
        return array_keys(self::getTypeFormChoices());
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }
}
