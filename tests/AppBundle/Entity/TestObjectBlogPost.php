<?php
/**
 * Created by PhpStorm.
 * User: fabrice
 * Date: 08/11/17
 * Time: 12:22
 */

namespace Tests\AppBundle\Entity;

class TestObjectBlogPost
{
    private $id;
    private $title;
    private $body;
    private $draft;
    private $author;

    public function __construct($data)
    {
        $this->author = $data['author'];
        $this->title =  $data['title'];
        $this->body = $data['body'];
    }

    public function __call($name, $arguments)
    {
        if ('getqux' === $name) {
            return $this->qux;
        }
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author)
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getDraft()
    {
        return $this->draft;
    }

    /**
     * @param mixed $draft
     */
    public function setDraft($draft)
    {
        $this->draft = $draft;
    }
}