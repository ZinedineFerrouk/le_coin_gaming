<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\PlateformeFixtures;
use App\DataFixtures\GamesFixtures;
use App\DataFixtures\UserFixtures;
use App\Entity\Annonce;
use App\Entity\Jeu;

class AnnoncesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i < 10; $i++) {
            $user = $this->getReference('user_' . $i);
            $jeu = $this->getReference('jeu_' . $i);
            $plateforme = $this->getReference('plateforme_1');

            $annonce = new Annonce;
            $annonce->setUser($user);
            $annonce->setJeu($jeu);
            $annonce->setPlateforme($plateforme);

            $annonce->setPrix(59.99);
            $annonce->setCreatedAt(new \DateTime());
            $annonce->setBoite(true);

            $manager->persist($annonce);
        }


        for ($i = 1; $i < 10; $i++) {
            $user = $this->getReference('user_' . $i);
            $jeu = $this->getReference('jeu_' . $i);
            $plateforme = $this->getReference('plateforme_2');

            $annonce = new Annonce;
            $annonce->setUser($user);
            $annonce->setJeu($jeu);
            $annonce->setPlateforme($plateforme);

            $annonce->setPrix(49.99);
            $annonce->setCreatedAt(new \DateTime());
            $annonce->setBoite(false);

            $manager->persist($annonce);
        }

        for ($i = 1; $i < 10; $i++) {
            $user = $this->getReference('user_' . $i);
            $jeu = $this->getReference('jeu_' . $i);
            $plateforme = $this->getReference('plateforme_3');

            $annonce = new Annonce;
            $annonce->setUser($user);
            $annonce->setJeu($jeu);
            $annonce->setPlateforme($plateforme);

            $annonce->setPrix(39.99);
            $annonce->setCreatedAt(new \DateTime());
            $annonce->setBoite(false);

            $manager->persist($annonce);
        }

        for ($i = 1; $i < 10; $i++) {
            $user = $this->getReference('user_' . $i);
            $jeu = $this->getReference('jeu_' . $i);
            $plateforme = $this->getReference('plateforme_4');

            $annonce = new Annonce;
            $annonce->setUser($user);
            $annonce->setJeu($jeu);
            $annonce->setPlateforme($plateforme);

            $annonce->setPrix(29.99);
            $annonce->setCreatedAt(new \DateTime());
            $annonce->setBoite(true);

            $manager->persist($annonce);
        }


        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
            GamesFixtures::class,
            PlateformeFixtures::class
        ];
    }
}
