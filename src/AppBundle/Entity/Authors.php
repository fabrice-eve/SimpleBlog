<?php
/**
 * Created by PhpStorm.
 * User: fabrice
 * Date: 09/11/17
 * Time: 09:46
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="Authors")
 */
class Authors extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        $this->blogPost = new ArrayCollection();
        $this->addRole('ROLE_USER');
    }

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\BlogPost", mappedBy="author", cascade={"persist", "merge", "remove"})
     */
    private $blogPost;

}