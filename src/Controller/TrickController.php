<?php

namespace App\Controller;

use App\Form\TrickType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trick', name: 'trick_')]
class TrickController extends AbstractController
{
    #[Route('/add', name: 'form')]
    public function index(Request $request): Response
    {
        $formTrick = $this->createForm(TrickType::class);
        $formTrick->handleRequest($request);

        if ($formTrick->isSubmitted() && $formTrick->isValid()) {
            dump($formTrick->getData());
        }
        return $this->render('trick/index.html.twig', [
            'form' => $formTrick->createView(),
        ]);
    }

    #[Route('/{id}', name: 'show')]
    public function show(Request $request, string $id): Response
    {
        $trick = [
            'title' => 'Je suis trick 1',
            'content' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Tempora, adipisci. Libero aperiam dolores excepturi, quidem maxime accusantium inventore. Illum, odio dolores! Ullam omnis veritatis laborum, animi inventore nostrum optio voluptates.',
            'author' => [
                'name' => 'Jean Dupont',
                'avatar' => 'https://randomuser.me/api/portraits/men/52.jpg'
            ],
            'nbrOfResponse' => 15
        ];
        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
        ]);
    }
}
