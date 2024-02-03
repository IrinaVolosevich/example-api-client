<?php

declare(strict_types=1);

namespace Ivolosevich\ExampleApiClient\API\Model;

/**
 * Class CommentCollection
 * @package Ivolosevich\ExampleApiClient\API\Model
 */
class CommentCollection
{
    /**
     * @var array<Comment>
     */
    private array $items = [];

    /**
     * @return $this
     */
    public function pushItem(Comment $comment): self
    {
        $this->items[] = $comment;

        return $this;
    }

    /**
     * @return Comment[]
     */
    public function toArray(): array
    {
        return $this->items;
    }

    public function count(): int
    {
        return count($this->items);
    }
}