<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\Video1Type;
use App\Repository\VideoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/e/t/video')]
class ETVideoController extends AbstractController
{
    #[Route('/', name: 'e_t_video_index', methods: ['GET'])]
    public function index(VideoRepository $videoRepository): Response
    {
        return $this->render('et_video/index.html.twig', [
            'videos' => $videoRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'e_t_video_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $video = new Video();
        $form = $this->createForm(Video1Type::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($video);
            $entityManager->flush();

            return $this->redirectToRoute('e_t_video_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('et_video/new.html.twig', [
            'video' => $video,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'e_t_video_show', methods: ['GET'])]
    public function show(Video $video): Response
    {
        return $this->render('et_video/show.html.twig', [
            'video' => $video,
        ]);
    }

    #[Route('/funny', name: 'e_t_video_funny', methods: ['GET'])]
    public function funny(Video $video): Response
    {
        return $this->render('et_video/funny.html.twig', [
            'video' => $video,
        ]);
    }

    #[Route('/{id}/edit', name: 'e_t_video_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Video $video): Response
    {
        $form = $this->createForm(Video1Type::class, $video);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('e_t_video_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('et_video/edit.html.twig', [
            'video' => $video,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'e_t_video_delete', methods: ['POST'])]
    public function delete(Request $request, Video $video): Response
    {
        if ($this->isCsrfTokenValid('delete'.$video->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($video);
            $entityManager->flush();
        }

        return $this->redirectToRoute('e_t_video_index', [], Response::HTTP_SEE_OTHER);
    }
}
