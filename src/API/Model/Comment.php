<?php

declare(strict_types=1);

namespace Ivolosevich\ExampleApiClient\API\Model;

/**
 * Class Comment
 * @package Ivolosevich\ExampleApiClient\API\Model
 */
class Comment
{
    private int $id;

    private string $name;

    private string $text;

    /**
     * @param int $id
     * @param string $name
     * @param string $text
     */
    public function __construct(int $id, string $name, string $text)
    {
        $this->id = $id;
        $this->name = $name;
        $this->text = $text;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }
}