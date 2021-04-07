<?php

namespace App\DataFixtures;

use App\Entity\Plateforme;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PlateformeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $tableau = [
            [
                'titre' => 'Playstation',
                'image' => 'assets/images/plateforme/play.png',
            ],

            [
                'titre' => 'Xbox',
                'image' => 'assets/images/plateforme/xbox.png',
            ],

            [
                'titre' => 'Nintendo',
                'image' => 'assets/images/plateforme/nintendo.png',
            ],

            [
                'titre' => 'Windows',
                'image' => 'assets/images/plateforme/windows.png',
            ],
        ];

        foreach ($tableau as $key => $value) {
            $jeu = new Plateforme();
            $jeu->setTitre($value['titre']);
            $jeu->setLogo($value['image']);

            $manager->persist($jeu);
        }

        $manager->flush();
    }
}
