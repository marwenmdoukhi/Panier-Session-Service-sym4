<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use App\Service\Cart\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     * @param SessionInterface $session
     * @param ProductRepository $productRepository
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(SessionInterface $session,CartService $cartService )
    {

      $tab=  $cartService->getfullCarte();
      $total=$cartService->gettotal();
        return $this->render('cart/index.html.twig', [
            'items'=>$tab,
            'total'=>$total

        ]);
    }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     * @param $id
     * @param CartService $cartService
     */
    public function add ($id, CartService $cartService){

        $cartService->add($id);

        return $this->redirectToRoute('cart_index');
    }

    /**
     *  @Route("/panier/remove/{id}", name="carte_remove")
     * @param $id
     * @param SessionInterface $session
     * @return RedirectResponse
     */
    public function remove ($id,  CartService $cartService){

        $cartService->remove($id);

        return $this->redirectToRoute('cart_index');


    }


}
