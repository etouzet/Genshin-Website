<?php

namespace App\Controller;

use App\Entity\Record;
use App\Form\RecordType;
use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/e/t/record')]
class ETRecordController extends AbstractController
{
    #[Route('/', name: 'e_t_record_index', methods: ['GET'])]
    public function index(RecordRepository $recordRepository): Response
    {
        return $this->render('et_record/index.html.twig', [
            'records' => $recordRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'e_t_record_new', methods: ['GET','POST'])]
    public function new(Request $request): Response
    {
        $record = new Record();
        $form = $this->createForm(RecordType::class, $record);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($record);
            $entityManager->flush();

            return $this->redirectToRoute('e_t_record_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('et_record/new.html.twig', [
            'record' => $record,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'e_t_record_show', methods: ['GET'])]
    public function show(Record $record): Response
    {
        return $this->render('et_record/show.html.twig', [
            'record' => $record,
        ]);
    }

    #[Route('/{id}/edit', name: 'e_t_record_edit', methods: ['GET','POST'])]
    public function edit(Request $request, Record $record): Response
    {
        $form = $this->createForm(RecordType::class, $record);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('e_t_record_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('et_record/edit.html.twig', [
            'record' => $record,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'e_t_record_delete', methods: ['POST'])]
    public function delete(Request $request, Record $record): Response
    {
        if ($this->isCsrfTokenValid('delete'.$record->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($record);
            $entityManager->flush();
        }

        return $this->redirectToRoute('e_t_record_index', [], Response::HTTP_SEE_OTHER);
    }
}
