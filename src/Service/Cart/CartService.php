<?php

namespace  App\Service\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService{

    protected  $session;
    protected  $productRepository;

    public function __construct(SessionInterface $session,ProductRepository $productRepository)
    {

        $this->session=$session;
        $this->productRepository=$productRepository;
    }

    public function add(int $id){

        $panier= $this->session->get('panier',[]);
        if(!empty($panier[$id])){
            $panier[$id]++;

        }else {
            $panier[$id]=1;

        }
        $this->session->set('panier',$panier);


    }

    public function remove(int  $id){

        $panier=$this->session->get('panier',[]);

        if(!empty($panier[$id])){

            unset($panier[$id]);
        }

        $this->session->set('panier',$panier);

    }

    public function getfullCarte():array {

        $painer=        $this->session->get('panier',[]);

        $tab=[];
        foreach ($painer as $id => $qte){

            $tab[]=[
                'product'=>$this->productRepository->find($id),
                'qte'=>$qte
            ];
        }
        return  $tab;

    }

   public function gettotal():float {

       $total=0;
       foreach ($this->getfullCarte() as $item){
           $total+= $item['product']->getPrice() * $item ['qte'];
       }

       return $total;

   }







}
