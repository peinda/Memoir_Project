<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\DetailCommande;
use App\Entity\EtatCommande;
use App\Repository\CommandeRepository;
use App\Repository\UserRepository;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Validator\ValidatorInterface;


class CommandeController extends AbstractController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function __invoke(Request $request,SerializerInterface $serializer, EntityManagerInterface $em,
                             ValidatorInterface $validator, UserRepository $userRepository,
                             ProduitRepository $produitRepo, CommandeRepository $comRepo ,Security $security)
    {
        if($request->getMethod() == 'POST'){
            //dd($request->getContent());
            $commandeJson= $request->getContent();

            $commandeTab= $serializer->decode($commandeJson, 'json')["produits"];
           // dd($commandeTab);
            $commande = new Commande();
            $prixTotal = 0;
            $user= $security->getUser();

            $commande-> setUser($user);
            $commande-> setAdresseLivraison($user->getAdress());
            //dd($commande);

            foreach($commandeTab as $produitItem){
            //dd($commandeTab);
                $produit=$produitRepo->find($produitItem["id"]);
                //dd($produit);
                $detail = new DetailCommande();
                $detail-> setMontant($produit->getPrix());
                $detail->setQuantiteProduit($produitItem["qtite"]);
                $detail->setTotal($produit->getPrix()*$produitItem["qtite"]);
                $detail->setCommande($commande);
                $detail->setProduit($produit);
                $prixTotal += $detail->getTotal();
            }
            $commande->setPrixTotal($prixTotal);
            $etat = new EtatCommande();
            $etat->setLibelle("En_Cours");
            $commande->setEtat($etat);

            $dataCom=$comRepo->findAll();
            if($dataCom){
                $lastCom = $dataCom[count($dataCom)-1]->getNumCommande();
                $numActu = (substr($lastCom, -1)+1);
                $lastCom[strlen($lastCom)-1]= $numActu;
            }
            else{
                $lastCom = "N000001";
            }
            $commande->setNumCommande($lastCom) ;
            $em->persist($detail);
            $em->persist($etat);
            $em->persist($commande);
            $em->flush();
            return $this->json($commande, Response::HTTP_OK);
        }

}

}
