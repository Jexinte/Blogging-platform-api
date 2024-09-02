<?php

declare(strict_types=1);

namespace Repository;

use PDO;
use Entity\Post;
use Enumeration\Date\Format;
use Config\DatabaseConnection;

/**
 * Summary of PostCrud
 */
interface PostCrud
{
    public function create(Post $post): bool;
}

/**
 * PHP version 8.
 *
 * @category Repository
 * @package  PostRepository
 * @author   Yokke <mdembelepro@gmail.com>
 * @license  ISC License
 * @link     https://github.com/Jexinte/Blogging-platform-api
 */

class PostRepository
{
    /**
     * Summary of __construct
     * @param \Config\DatabaseConnection $db
     */
    public function __construct(private DatabaseConnection $db)
    {

    }


    /**
     * Summary of create
     * @param \Entity\Post $post
     * @return bool
     */
    public function create(Post $post): bool
    {
        $dbConnect = $this->db->connect();

        $title = $post->getTitle();
        $content = $post->getContent();
        $category = $post->getCategory();
        $tags = implode(',', $post->getTags());
        $createdAt = $post->getCreatedAt()->format(Format::ISO_8601);
        $updatedAt = $post->getUpdatedAt()->format(Format::ISO_8601);
        $req = $dbConnect->prepare('INSERT INTO post (title,content,category,tags,created_at,updated_at) VALUES(:title,:content,:category,:tags,:createdAt,:updatedAt)');
        $req->bindParam(':title', $title);
        $req->bindParam(':content', $content);
        $req->bindParam(':category', $category);
        $req->bindParam(':tags', $tags);
        $req->bindParam(':createdAt', $createdAt);
        $req->bindParam(':updatedAt', $updatedAt);
        $req->execute();

        return true;
    }

    /**
     * Summary of getTheLastPostCreated
     * @return array<string>
     */
    public function getTheLastPostCreated(): array
    {
        $dbConnect = $this->db->connect();
        $req = $dbConnect->prepare('SELECT * From post ORDER BY id DESC LIMIT 1');
        $req->execute();
        $posts = $req->fetchAll(PDO::FETCH_ASSOC);
        $post = end($posts);
        $post['tags'] = explode(' ', $post['tags']);
        return $post;
    }
}
