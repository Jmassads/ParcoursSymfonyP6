<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Trick;
use App\Form\CommentType;
use App\Form\TrickType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trick', name: 'trick_')]
class TrickController extends AbstractController
{
    #[Route('/add', name: 'form')]
    #[IsGranted('ROLE_USER')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $trick = new Trick();
        $formTrick = $this->createForm(TrickType::class, $trick);
        $formTrick->handleRequest($request);

        if ($formTrick->isSubmitted() && $formTrick->isValid()) {
            $trick->setCreatedAt(new \DateTimeImmutable());
            $trick->setUser($user);
            $em->persist($trick);
            $em->flush();
            $this->addFlash('success', 'Votre trick a été ajouté');
            return $this->redirectToRoute('home');
        }
        return $this->render('trick/index.html.twig', [
            'form' => $formTrick->createView(),
        ]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(Request $request, Trick $trick, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setCreatedAt(new \DateTimeImmutable());
            $comment->setTrick($trick);
            $comment->setUser($user);
            $em->persist($comment);
            $em->flush();
            $this->addFlash('success', 'Votre commentraire a bien été ajouté');
            return $this->redirect($request->getUri());
        }
        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'form' => $commentForm->createView()
        ]);
    }
}
