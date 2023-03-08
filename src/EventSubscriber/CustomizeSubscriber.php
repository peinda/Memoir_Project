<?php

namespace App\EventSubscriber;

use ApiPlatform\Symfony\EventListener\EventPriorities;
use App\Entity\Categorie;
use App\Entity\Commentaire;
use App\Entity\Produit;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Serializer\SerializerInterface;

class CustomizeSubscriber implements \Symfony\Component\EventDispatcher\EventSubscriberInterface
{

    public function __construct(
        private  readonly UserPasswordHasherInterface $passwordHasher,
        private readonly ManagerRegistry $managerRegistry,
        private readonly Security $security
    )
    {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setCustomize', EventPriorities::PRE_WRITE]
        ];
    }

    public function setCustomize(ViewEvent $event)
    {

        $item = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();
        $data = json_decode($event->getRequest()->getContent(), true);

        if($item instanceof User && in_array($method, [ Request::METHOD_POST,  Request::METHOD_PUT])){
            if(isset($data['password'])){
                $item->setPassword($this->passwordHasher->hashPassword($item, $data['password']));
            }
        }
        if($item instanceof Produit && in_array($method, [ Request::METHOD_POST,  Request::METHOD_PUT])){
            $categorie = $this->managerRegistry->getRepository(Categorie::class)->find((int)$data['categori']);
            $item->setCategorie($categorie);
        }

        if($item instanceof Commentaire && in_array($method, [ Request::METHOD_POST,  Request::METHOD_PUT])){
            $produit = $this->managerRegistry->getRepository(Produit::class)->find((int)$data['produits']);
            $item->setProduit($produit);
            $item->setUser($this->security->getUser());
        }
    }
}