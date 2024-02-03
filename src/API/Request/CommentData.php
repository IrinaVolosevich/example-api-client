<?php

declare(strict_types=1);

namespace Ivolosevich\ExampleApiClient\API\Request;

/**
 * Class CommentData
 * @package Ivolosevich\ExampleApiClient\API\Request
 */
class CommentData
{
    private ?string $name;

    private ?string $text;

    /**
     * @param string $name
     * @param string $text
     */
    public function __construct(?string $name, ?string $text)
    {
        $this->name = $name;
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(?string $text): void
    {
        $this->text = $text;
    }

    /**
     * @return null[]|string[]
     */
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'text' => $this->getText(),
        ];
    }
}