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
use App\Repository\ActionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/action")
 */
class ActionController extends AbstractController
{
    /**
     * @Route("/", name="action_index", methods={"GET"})
     */
    public function index(Request $request, ActionRepository $actionRepository, PaginatorInterface $paginator): Response
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

        return $this->render('action/index.html.twig',
            [
                'pagination' => $paginator->paginate(
                    $actionRepository->findAll(),$request->query->getInt('page', 1),10)
            ]
        );


    }

    /**
     * @Route("/new", name="action_new", methods={"GET","POST"})
     *
     */
    public function new(Request $request): Response
    {
        $actionRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:Action');

        $walletRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:Wallet');

        $action = new Action();
        $form = $this->createForm(ActionType::class, $action);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->getConnection()->beginTransaction();
            try {
                $entityManager->persist($action);
                $entityManager->flush();

                $actionRepository->save($action);
                $wallet = $action->getWallet();
                $balance = $actionRepository->getBalance($wallet);
                $wallet->setBalance($balance['balance']);
                $walletRepository->save($wallet);
                $entityManager->getConnection()->commit();
            } catch (Exception $e) {
                $entityManager->getConnection()->rollBack();
                throw $e;
            }


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

    /**
     * @Route("/search", name="action_search", methods={"POST"})
     */
    public function search(Request $request): Response
    {
        $actionRepository = $this->getDoctrine()
            ->getManager()
            ->getRepository('App:Action');

//        $wallet = $this->createQueryBuilder('wallet')
//            ->select('wallet.id')
//            ->andwhere('wallet.name = :name')
//            ->setParameter('name', $walletName)->getQuery()->getOneOrNullResult();

        $walletObject = $this->getDoctrine()
            ->getRepository('App:Wallet')
            ->findOneBy(array('name' => $request->request->get('wallet')));

        $results = $actionRepository->searchByDates(
            $request->request->get('date1'),
            $request->request->get('date2'),
            $walletObject->getId()
        );

        return $this->render('action/search.html.twig', [
//            'action' => $action,
            'date1' => $request->request->get('date1'),
            'date2' => $request->request->get('date2'),
            'results' => $results
        ]);
    }
}
