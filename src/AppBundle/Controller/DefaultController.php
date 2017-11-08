<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BlogPost;
use AppBundle\Form\BlogPostType;
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



    /**
     * @Route("/newMessage", name="new_message")
     */
    public function newMessageAction(Request $request)
    {
        $blogPost = new BlogPost();
        $formBlogPost = $this->formNewPost($blogPost);
        $formBlogPost->handleRequest($request);
        if ($formBlogPost->isSubmitted() && $formBlogPost->isValid()) {
            try {
                /** @var BlogPost $data */
                $data = $formBlogPost->getData();
                $data->setDraft(false);
                $em = $this->getDoctrine()->getManager();
                $em->persist($data);
                $em->flush();
                $this->addFlash("success", "message saved");
            } catch (\Exception $exception) {
                $this->addFlash("error", "error the message is not saved");
                $this->get('logger')->error('Error during insert message'. $exception->getMessage());
            }
        }

        return $this->render('@App/createNewMessage.html.twig', array(
            'formBlogPost' => $formBlogPost->createView()
        ));
    }

    private function formNewPost($blogPost)
    {
        return $this->createForm(BlogPostType::class,$blogPost);
    }
}
