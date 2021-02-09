<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/post", name="post.")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index(PostRepository $postRepository): Response
    {
    	$posts = $postRepository->findAll();
    	return $this->render('post/index.html.twig', [
    		'posts' => $posts,
    	]);
    }

	/**
     * @Route("/create", name="create")
     */
	public function create(Request $request): Response {
		$post = new Post();
		$form = $this->createForm(PostType::class, $post);

		// $em = $this->getDoctrine()->getManager();
		// $em->persist($post);
		// $em->flush();

		return $this->render('post/create.html.twig', ['form' => $form->createView()]);

	}
	/**
     * @Route("/show/{id}", name="show")
     */

	public function show(Post $post): Response {
		return $this->render('post/show.html.twig', ['post' => $post]);
	}
	/**
     * @Route("/delete/{id}", name="delete")
     */
	public function remove(Post $post, EntityManagerInterface $entityManager) {
		$entityManager->remove($post);

		$entityManager->flush();

		$this->addFlash('success', 'Post was removed');

		return $this->redirect($this->generateUrl('post.index'));
	}
}
