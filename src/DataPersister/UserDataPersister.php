<?php

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\User;

class UserDataPersister implements DataPersisterInterface
{
    private UserPasswordEncoderInterface $userPasswordEncoder;

    public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }
    public function supports($data): bool
    {
        return $data instanceof User;
    }

    public function persist($data)
    {
        if ($data->getPlainPassword()) {
            $data->setPassword(
                $this->userPasswordEncoder->encodePassword($data, $data->getPlainPassword())
            );
            $data->eraseCredentials();
        }
    }
    public function remove($data)
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}