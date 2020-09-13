<?php
/**
 * Wallet Controller.
 */

namespace App\Controller;

use App\Entity\Wallet;
use App\Form\WalletType;
use App\Repository\WalletRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wallet")
 */
class WalletController extends AbstractController
{
    /**
     * Index action.
     *
     * @param Request            $request          HTTP request
     * @param WalletRepository   $walletRepository Wallet repository
     * @param PaginatorInterface $paginator        Paginator
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="wallet_index",
     * )
     */
    public function index(Request $request, WalletRepository $walletRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $walletRepository->queryAll(),
            $request->query->getInt('page', 1),
            WalletRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'wallet/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * New wallet.
     *
     * @param Request          $request          HTTP request
     * @param WalletRepository $walletRepository Wallet repository
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="wallet_new",
     * )
     */
    public function create(Request $request, WalletRepository $walletRepository): Response
    {
        $wallet = new Wallet();
        $form = $this->createForm(WalletType::class, $wallet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $walletRepository->save($wallet);

            return $this->redirectToRoute('wallet_index');
        }

        return $this->render(
            'wallet/new.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * @Route("/{id}", name="wallet_show", methods={"GET"})
     */
    public function show(Wallet $wallet): Response
    {
        return $this->render('wallet/show.html.twig', [
            'wallet' => $wallet,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="wallet_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Wallet $wallet): Response
    {
        $form = $this->createForm(WalletType::class, $wallet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('wallet_index');
        }

        return $this->render('wallet/edit.html.twig', [
            'wallet' => $wallet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="wallet_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Wallet $wallet): Response
    {
        if ($this->isCsrfTokenValid('delete'.$wallet->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($wallet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('wallet_index');
    }
}
