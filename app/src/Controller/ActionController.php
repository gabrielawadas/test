<?php
/**
 * Action Controller.
 */

namespace App\Controller;

/*
 * Action Controller.
 */
use App\Entity\Action;
use App\Form\ActionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/action")
 */
class ActionController extends AbstractController
{
    /**
     * @Route("/", name="action_index", methods={"GET"})
     */
    public function index(Request $request)
    {
        $actionRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:Action');

        $FindAllByCategory = $request->query->get('q');

        if ($FindAllByCategory) {
            $actions = $actionRepository->FindAllByCategory($FindAllByCategory);
        } else {
            $actions = $actionRepository->findAllOrdered();
        }


        return $this->render('action/index.html.twig', [
            'actions' => $actions,
        ]);
    }

    /**
     * @Route("/new", name="action_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $actionRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:Action');

        $action = new Action();
        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($action);
            $entityManager->flush();

            return $this->redirectToRoute('wallet_index');
        }

        return $this->render('action/new.html.twig', [
            'action' => $action,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="action_show", methods={"GET"})
     */
    public function show(Action $action): Response
    {
        return $this->render('action/show.html.twig', [
            'action' => $action,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="action_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Action $action): Response
    {
        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('action_index');
        }

        return $this->render('action/edit.html.twig', [
            'action' => $action,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="action_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Action $action): Response
    {
        if ($this->isCsrfTokenValid('delete'.$action->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($action);
            $entityManager->flush();
        }

        return $this->redirectToRoute('action_index');
    }
}
