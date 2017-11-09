<?php
/**
 * Created by PhpStorm.
 * User: fabrice
 * Date: 09/11/17
 * Time: 11:27
 */

namespace Tests\Tools;

use AppBundle\Entity\Authors;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\HttpFoundation\Response;

class AuthorUnitTestCase extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

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
    }

    /**
     * @param $username
     * @param null $password
     */
    public function createUser($username, $password = null)
    {
        if ($this->em === null) {
            $this->em = static::$kernel->getContainer()
                ->get('doctrine')
                ->getManager()
            ;
        }

        $this->removeUser($username);

        $password = ($password === null ? time() : $password);

        $user = new Authors();
        $user->setUsername($username);
        $user->setEmail($username);
        $user->setPlainPassword($password);
        $user->setEnabled(true);

        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param null $Username
     */
    public function removeUser($Username = null)
    {
        if ($Username!=null) {
            // external call need to setUp class
            $this->setUp();
            /** @var Authors $author */
            $author = $this->em->getRepository(Authors::class)->findOneBy(array('username' => $Username));
            if ($author != null) {
                $this->em->remove($author);
                $this->em->flush();
            }
        }
    }

    public function setRoleUSER($Username = null)
    {
        if ($Username!=null) {
            $this->setUp();
            $user = $this->em->getRepository(Authors::class)->findOneBy(array('username' => $Username));
            if ($user != null) {
                $user->setRoles(array('ROLE_USER'));
                $this->em->persist($user);
                $this->em->flush();
            }
        }
    }

    /**
     * @param Client $client
     * @param $username
     * @param $password
     */
    public function testLogin(Client $client, $username, $password)
    {
        $crawler = $client->request('GET', '/login');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());

        $form = $crawler->filter('form')->form(array(
            '_username'  => $username,
            '_password'  => $password,
            '_remember_me' => false
        ));

        $client->submit($form);

        $client->request('GET', '/newMessage');
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode(), "Unexpected HTTP status code after login /newMessage");
    }
}