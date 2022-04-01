<?php

namespace App\Controller;

use App\Entity\Trick;
use App\Form\TrickType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trick', name: 'trick_')]
class TrickController extends AbstractController
{
    #[Route('/add', name: 'form')]
    public function index(Request $request, EntityManagerInterface $em): Response
    {
        $trick = new Trick();
        $formTrick = $this->createForm(TrickType::class, $trick);
        $formTrick->handleRequest($request);

        if ($formTrick->isSubmitted() && $formTrick->isValid()) {
            $trick->setCreatedAt(new \DateTimeImmutable());
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
    public function show(Trick $trick): Response
    {
        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
        ]);
    }
}
