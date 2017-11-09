<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BlogPost;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $blogList = $em->getRepository(BlogPost::class)->findAll();

        // replace this example code with whatever you need
        return $this->render('@App/index.html.twig', array(
            'blogList' => $blogList,
        ));
    }

}
