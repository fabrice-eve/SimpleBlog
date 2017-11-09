<?php
/**
 * Created by PhpStorm.
 * User: fabrice
 * Date: 09/11/17
 * Time: 11:17
 */

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Tests\Tools\AuthorUnitTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;


class CreateNewPostControllerTest extends WebTestCase
{

    /** @var EntityManager */
    private $em;

    private $Username = "phpunitProductTestsUser";

    private $Password = "123phpuproductTest@";

    /** @var Client */
    private $client;


    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->em = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager()
        ;

        $authorUnitTestCase = new AuthorUnitTestCase();
        $authorUnitTestCase->createUser($this->Username, $this->Password);
        $authorUnitTestCase->setRoleUSER($this->Username);

        $this->client = static::createClient(array(), array('HTTPS' => false));

        $authorUnitTestCase->testLogin($this->client, $this->Username, $this->Password);
    }

    public function testNewMessage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/newMessage');
        // not logged 302
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());
    }


    public function testCreateNewMessage()
    {
        $authorUnitTestCase = new AuthorUnitTestCase();

        $authorUnitTestCase->testLogin($this->client, $this->Username, $this->Password);
        $crawler = $this->client->request('GET', '/newMessage');
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());

        $form = $crawler->filter('form')->form(array(
            'new_message_blog[title]'  => 'blatest',
            'new_message_blog[body]'  => 'blotst',
        ));

        $this->client->submit($form);
        $this->assertEquals(Response::HTTP_OK, $this->client->getResponse()->getStatusCode());
    }
}