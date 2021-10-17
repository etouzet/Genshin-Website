<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;

class ETFunnyController extends AbstractController
{
    #[Route('/e/t/funny', name: 'e_t_funny')]
    public function index(VideoRepository $videoRepository): Response
    {
        return $this->render('et_funny/index.html.twig', [
            'controller_name' => 'ETFrontController',
            'titre' => 'Genshin Impact',
            'videos' => $videoRepository->findAll(),
        ]);
    }
}
