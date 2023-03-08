<?php
namespace App\DataFixtures;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface{

    private UserPasswordHasherInterface $encode;

    public function __construct(UserPasswordHasherInterface $encode)
    {
        $this->encode = $encode;
    }

    public function load(ObjectManager $manager)
    {
        $admin= new User() ;
        $admin->setUsername("767678789");
        $admin->setPassword($this->encode->hashPassword($admin,"passer123"));
        $admin->setPrenom("Admin Admin");
        $admin->setAdress('Dakar Gnary Tally');
        $admin->setNom("Admin");
        $admin->setProfil($this->getReference("ADMIN"));
        $manager->persist($admin);
        $manager->flush();
    }

    public function getDependencies()
    {
        return array (ProfileFixtures::class);
    }
    
}