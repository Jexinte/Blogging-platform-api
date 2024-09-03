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
    /**
     * Summary of create
     * @param \Entity\Post $post
     * @return bool
     */
    public function create(Post $post): bool;

    /**
     * Summary of findAll
     * @return array<string>|bool
     */
    public function findAll(): array|bool;

    /**
     * Summary of findBy
     * @param int $id
     * @return array<string>|bool
     */
    public function findBy(int $id): array|bool;

    /**
     * Summary of delete
     * @param int $id
     * @return void
     */
    public function delete(int $id): void;
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
     * Summary of update
     * @param \Entity\Post $post
     * @param int $id
     * @return void
     */
    public function update(Post $post, int $id): void
    {
        $dbConnect = $this->db->connect();

        $title = $post->getTitle();
        $content = $post->getContent();
        $category = $post->getCategory();
        $tags = implode(',', $post->getTags());
        $updatedAt = $post->getUpdatedAt()->format(Format::ISO_8601);
        $req = $dbConnect->prepare('UPDATE post SET title = :title, content = :content, category=:category, tags = :tags,updated_at = :updatedAt WHERE id = :id');
        $req->bindParam(':id', $id);
        $req->bindParam(':title', $title);
        $req->bindParam(':content', $content);
        $req->bindParam(':category', $category);
        $req->bindParam(':tags', $tags);
        $req->bindParam(':updatedAt', $updatedAt);
        $req->execute();

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


    /**
     * Summary of findAll
     * @return array<string>|bool
     */
    public function findAll(): array|bool
    {
        $dbConnect = $this->db->connect();
        $req = $dbConnect->prepare('SELECT * FROM post');
        $req->execute();
        $posts = $req->fetchAll(PDO::FETCH_ASSOC);
        return $posts;
    }
    /**
     * Summary of findBy
     * @param int $id
     * @return array<string>|bool
     */
    public function findBy(int $id): array|bool
    {
        $dbConnect = $this->db->connect();
        $req = $dbConnect->prepare('SELECT * From post WHERE id = :id');
        $req->bindParam(':id', $id);
        $req->execute();

        $post = $req->fetch(PDO::FETCH_ASSOC);

        return $post;
    }

    /**
     * Summary of delete
     * @param int $id
     * @return void
     */
    public function delete(int $id): void
    {
        $dbConnect = $this->db->connect();
        $req = $dbConnect->prepare('DELETE FROM post WHERE id = :id');
        $req->bindParam(':id', $id);
        $req->execute();
    }

    /**
     * Summary of findByParameter
     * @param string $parameterFromUri
     * @return array<string>
     */
    public function findByParameter(string $parameterFromUri): array
    {
        $dbConnect = $this->db->connect();
        $req = $dbConnect->prepare("SELECT * FROM post WHERE title = '$parameterFromUri' OR content ='$parameterFromUri' OR category = '$parameterFromUri'");
        $req->execute();

        return $req->fetchAll(PDO::FETCH_ASSOC);
    }
}
