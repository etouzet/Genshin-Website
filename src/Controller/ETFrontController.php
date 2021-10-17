<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;


class ETFrontController extends AbstractController
{
    #[Route('/e/t/front', name: 'e_t_front')]
    public function index(): Response
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);

        $articles = $repo->findAll();

        return $this->render('et_front/index.html.twig', [
            'controller_name' => 'ETFrontController',
        ]);
    }

    #[Route('/', name: 'home')]
    public function home(ArticleRepository $articleRepository): Response
    {
        return $this->render('et_front/home.html.twig', [
            'controller_name' => 'ETFrontController',
            'titre' => 'Genshin Impact',
            'articles' => $articleRepository->findAll(),
        ]);
    }
}
