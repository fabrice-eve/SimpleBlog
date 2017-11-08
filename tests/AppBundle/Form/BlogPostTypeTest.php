<?php
/**
 * Created by PhpStorm.
 * User: fabrice
 * Date: 08/11/17
 * Time: 12:03
 */

namespace Tests\AppBundle\Form;

use AppBundle\Entity\BlogPost;
use AppBundle\Form\BlogPostType;
use Symfony\Component\Form\Test\TypeTestCase;

class BlogPostTypeTest extends TypeTestCase
{
    public function testSubmitValidData()
    {
        $formData = array(
            'title' => 'testtile',
            'author' => 'testauthor',
            'body' =>  'testbody',
        );
        $object = $this->ObjectBlogPost($formData);
        $form = $this->factory->create(BlogPostType::class);

        // submit the data to the form directly
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($object, $form->getData());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }
    }

    private function ObjectBlogPost($formData)
    {
        $object = new BlogPost();
        $object->setAuthor($formData['author']);
        $object->setTitle($formData['title']);
        $object->setBody($formData['body']);
        return $object;
    }
}