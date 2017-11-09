<?php
/**
 * Created by PhpStorm.
 * User: fabrice
 * Date: 09/11/17
 * Time: 10:48
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Authors;
use AppBundle\Entity\BlogPost;
use AppBundle\Form\BlogPostType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CreateNewPostController extends Controller
{
    /**
     * @Route("/newMessage", name="new_message")
     */
    public function newMessageAction(Request $request)
    {
        /** @var Authors $user */
        $user = $this->getUser();
        if ($user == null || !$user->hasRole('ROLE_USER')) {
            return $this->redirectToRoute('fos_user_security_login');
        }
        $blogPost = new BlogPost();
        $formBlogPost = $this->formNewPost($blogPost);
        $formBlogPost->handleRequest($request);
        if ($formBlogPost->isSubmitted() && $formBlogPost->isValid()) {
            try {
                /** @var BlogPost $data */
                $data = $formBlogPost->getData();
                $data->setDraft(false);
                $data->setAuthor($user);
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