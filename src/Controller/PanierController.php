<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="app_panier")
     */
    public function index(SessionInterface $session, ArticleRepository $articleRepository): Response
    {
        $panier = $session->get('panier',[]);
        $panierWithData=[];

        foreach($panier as $id =>$quantite){
            $panierWithData[] =[
                'article' =>$articleRepository->find($id),
                'quantite' =>$quantite
            ];
        }
            $total = 0;

            foreach($panierWithData as $list){
                $totalList = $list['article']->getPrix() * $list['quantite'];
                $total +=$totalList;
            }

        

        return $this->render('panier/index.html.twig', [
            'lists' => $panierWithData,
            'total'=> $total
        ]);
    }


    /**
     * @Route("/panier/add/{id}", name="panier_add")
     */
    public function add($id, SessionInterface $session)
    {
    
        $panier = $session->get('panier',[]);

        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] =1;
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }

    /**
     * @Route("/panier/remove/{id}", name="remove")
     */
    public function remove($id, SessionInterface $session)
    {
    
        $panier = $session->get('panier',[]);

        if(!empty($panier[$id])){
            unset($panier[$id]);
        }

        $session->set('panier', $panier);

        return $this->redirectToRoute('app_panier');
    }
}
