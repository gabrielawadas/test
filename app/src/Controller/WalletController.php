<?php
/**
 * Wallet Controller.
 */
namespace App\Controller;

use App\Entity\Wallet;
use App\Form\WalletType;
use App\Repository\WalletRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;



/**
 * @Route("/wallet")
 */
class WalletController extends AbstractController
{
    /**
     * @Route("/", name="wallet_index", methods={"GET"})
     */
    public function index(Request $request, WalletRepository $walletRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $walletRepository->findAll(),
            $request->query->getInt('page', 1),
            WalletRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'wallet/index.html.twig',
            ['pagination' => $pagination]
        );





    }


    /**
     * @Route("/new", name="wallet_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $wallet = new Wallet();
        $form = $this->createForm(WalletType::class, $wallet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($wallet);
            $entityManager->flush();

            return $this->redirectToRoute('wallet_index');
        }

        return $this->render('wallet/new.html.twig', [
            'wallet' => $wallet,
            'form' => $form->createView(),
        ]);
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
