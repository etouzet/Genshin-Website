<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Video;
use App\Form\VideoType;
use App\Repository\VideoRepository;

class ETPlayController extends AbstractController
{
    #[Route('/e/t/play', name: 'e_t_play')]
    public function index(VideoRepository $videoRepository): Response
    {
        return $this->render('et_play/index.html.twig', [
            'controller_name' => 'ETPlayController',
            'titre' => 'Genshin Impact',
            'videos' => $videoRepository->findAll(),
        ]);
    }
}
