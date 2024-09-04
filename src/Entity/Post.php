<?php

declare(strict_types=1);

namespace Entity;

use DateTime;

/**
 * PHP version 8.2
 *
 * @category Entity
 * @package  Post
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Naruto
 */

class Post
{
    public int $id;
    public Datetime $createdAt;
    public Datetime $updatedAt;

    /**
     * Summary of __construct
     * @param string $title
     * @param string $content
     * @param string $category
     * @param array<string> $tags
     */
    public function __construct(public string $title, public string $content, public string $category, public array $tags)
    {
        $this->createdAt = new DateTime('now');
        $this->updatedAt = new DateTime('now');
    }

    /**
     * Summary of setId
     * @param mixed $id
     * @return void
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * Summary of getId
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Summary of setCreatedAt
     * @param \DateTime $createdAt
     * @return void
     */
    public function setCreatedAt(Datetime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * Summary of setUpdatedAt
     * @param \DateTime $updatedAt
     * @return void
     */
    public function setUpdatedAt(Datetime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    /**
     * Summary of getTitle
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Summary of getContent
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * Summary of getCategory
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * Summary of getTags
     * @return array<string>
     */
    public function getTags(): array
    {
        return $this->tags;
    }

    /**
     * Summary of getCreatedAt
     * @return \DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * Summary of getUpdatedAt
     * @return DateTime
     */
    public function getUpdatedAt(): DateTime
    {
        return $this->createdAt;
    }
}
