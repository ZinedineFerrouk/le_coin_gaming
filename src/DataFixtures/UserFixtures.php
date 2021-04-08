<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordEncoderInterface $passwordEncoder){
        $this->passwordEncoder = $passwordEncoder;
    }
    public function load(ObjectManager $manager)
    {
        $admin = new User();
        $admin->setPseudo('said27');
        $admin->setNom('adraou');
        $admin->setPrenom('said');
        $admin->setAge('18');
        $admin->setEmail('said27@gmail.com');
        $admin->setPassword($this->passwordEncoder->encodePassword($admin,'testadmin'));
        $admin->setRoles(['ROLE_USER','ROLE_ADMIN','ROLE_SUPER_ADMIN']);
        $manager->persist($admin);

        $abonne = new User();
        $abonne->setPseudo('zizou');
        $abonne->setNom('Ferrouk');
        $abonne->setPrenom('Zinedine');
        $abonne->setAge('22');
        $abonne->setEmail('zinedine@gmail.com');
        $abonne->setPassword($this->passwordEncoder->encodePassword($abonne,'testabonne'));
        $abonne->setRoles(['ROLE_USER']);
        $manager->persist($abonne);

        $manager->flush();
    }
}
