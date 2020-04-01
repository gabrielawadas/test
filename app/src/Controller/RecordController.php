<?php
/**
 * Record controller.
 */

namespace App\Controller;

use App\Repository\RecordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class RecordController.
 *
 * @Route("/record")
 */
class RecordController extends AbstractController
{
    /**
     * Index action.
     *
     * @param \App\Repository\RecordRepository $repository Record repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="record_index",
     * )
     */
    public function index(RecordRepository $repository): Response
    {
        return $this->render(
            'record/index.html.twig',
            ['data' => $repository->findAll()]
        );
    }

    /**
     * Show action.
     *
     * @param \App\Repository\RecordRepository $repository Record repository
     * @param int                              $id         Record id
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="record_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     */
    public function show(RecordRepository $repository, int $id): Response
    {
        return $this->render(
            'record/show.html.twig',
            ['item' => $repository->findById($id)]
        );
    }
}


