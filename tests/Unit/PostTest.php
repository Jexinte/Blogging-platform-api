<?php

declare(strict_types=1);

use Entity\Post;
use PHPUnit\Framework\TestCase;

/**
 * PHP version 8.2
 *
 * @category tests\Unit
 * @package  PostTest
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */
class PostTest extends TestCase
{
    private Post $post;

    /**
    * Summary of setUp
    * @return void
    */
    public function setUp(): void
    {
        parent::setUp();
        $this->post = new Post("My title", "My content", "Test", ["a","b","c"]);
    }

    /**
     * Summary of testShouldReturnTheSameTitle
     * @return void
     */
    public function testShouldReturnTheSameTitle(): void
    {
        $this->assertSame("My title", $this->post->getTitle());
    }

    /**
     * Summary of testShouldReturnTheSameContent
     * @return void
     */
    public function testShouldReturnTheSameContent(): void
    {
        $this->assertSame("My content", $this->post->getContent());
    }

    /**
     * Summary of testShouldReturnTheSameCategory
     * @return void
     */
    public function testShouldReturnTheSameCategory(): void
    {
        $this->assertSame("Test", $this->post->getCategory());
    }

    /**
     * Summary of testShouldReturnTheSameTags
     * @return void
     */
    public function testShouldReturnTheSameTags(): void
    {
        $this->assertSame(["a","b","c"], $this->post->getTags());
    }

    /**
     * Summary of testShouldReturnTheSameCreatedAt
     * @return void
     */
    public function testShouldReturnTheSameCreatedAt(): void
    {
        $date = new DateTime('now');

        $this->assertSame($date->format('Y-m-d\TH:i:s\Z'), $this->post->getCreatedAt()->format('Y-m-d\TH:i:s\Z'));
    }

    /**
     * Summary of testShouldReturnTheSameUpdatedAt
     * @return void
     */
    public function testShouldReturnTheSameUpdatedAt(): void
    {
        $date = new DateTime('now');

        $this->assertSame($date->format('Y-m-d\TH:i:s\Z'), $this->post->getUpdatedAt()->format('Y-m-d\TH:i:s\Z'));
    }

}
