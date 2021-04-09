<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\PlateformeFixtures;
use App\Entity\Annonce;
use App\Entity\Jeu;

class GamesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $tableau = [
            [
                'titre' => 'The Witcher 3',
                'description' => 'The Witcher 3 : Wild Hunt est un Action-RPG se déroulant dans un monde ouvert. Troisième épisode de la série du même nom, inspirée des livres du polonais Andrzej Sapkowski, cet opus relate la fin de l\'histoire de Geralt de Riv.',
                'date_sortie' => '2015-05-19 00:00:00',
                'image' => 'assets/images/games/the_witcher_3.png',
            ],

            [
                'titre' => 'The Elder Scrolls V : Skyrim : Special Edition',
                'description' => 'The Elder Scrolls V : Skyrim : Special Edition sur PS4 est un jeu de rôle et le cinquième volet de la saga Elder Scrolls. L\'histoire se déroule dans la contrée de Skyrim, près de 200 ans après les événements narrés dans le précédent opus. L\'assassinat du Haut-Roi de Bordeciel a plongé le pays dans la guerre civile et pour couronner le tout, c\'est le moment que choisit Alduin pour réapparaître. Une seule personne peut rétablir l\'équilibre, le Dovahkiin, « fils de Dragons » et ça tombe bien : c\'est vous !',
                'date_sortie' => '2016-10-28 00:00:00',
                'image' => 'assets/images/games/skyrim.jpg',
            ],

            [
                'titre' => 'Cyberpunk 2077',
                'description' => "Cyberpunk 2077 est un jeu de rôle futuriste et dystopique inspiré du jeu de rôle papier du même nom. Dans un monde devenu indissociable de la cybernétique, l'indépendance des robots humanoïdes pose quelques problèmes...",
                'date_sortie' => '2020-12-10 00:00:00',
                'image' => 'assets/images/games/cyberpunk_2077.jpg',
            ],

            [
                'titre' => 'Outriders',
                'description' => "Outriders est un jeu de shoot cryptique très sombre dévoilé par People Can Fly pour Square Enix. Il oppose le joueur à des humanoïdes, mais aussi à d'étranges créatures, aussi effrayantes que grandes. Le jeu propose 3 classes au gameplay différent.",
                'date_sortie' => '2021-04-01 00:00:00',
                'image' => 'assets/images/games/outriders.jpg',
            ],

            [
                'titre' => "Assassin's Creed Valhalla",
                'description' => "Assassin's Creed Valhalla est un RPG en monde ouvert se déroulant pendant l'âge des vikings. Vous incarnez Eivor, un viking du sexe de votre choix qui a quitté la Norvège pour trouver la fortune et la gloire en Angleterre. Raids, construction et croissance de votre colonie, mais aussi personnalisation du héros ou de l'héroïne sont au programme de cet épisode.",
                'date_sortie' => '2020-11-10 00:00:00',
                'image' => 'assets/images/games/assassin\'s_creed_valhalla.webp',
            ],

            [
                'titre' => "Hitman 3",
                'description' => "Hitman 3 est un jeu d'infiltration dans lequel vous incarnez l'agent 47. Dans ce troisième épisode de la nouvelle trilogie lancée en 2017, six lieux sont disponibles au lancement, mais il est possible de transférer les anciennes missions des deux premiers volets.",
                'date_sortie' => '2021-01-20 00:00:00',
                'image' => 'assets/images/games/hitman_3.webp',
            ],

            [
                'titre' => "Watch Dogs Legion",
                'description' => "Watch Dogs Legion, troisième épisode de la série d'Ubisoft, vous plonge dans le Londres post-Brexit ultra-connecté et surveillé. Vous aurez la possibilité d'hacker n'importe qui, mais aussi d'en prendre possession. Chaque mort est permanente, d'où l'utilité de prendre possession des PNJ.",
                'date_sortie' => '2020-10-29 00:00:00',
                'image' => 'assets/images/games/watch_dogs_legion.webp',
            ],

            [
                'titre' => "Mafia : Definitive Edition",
                'description' => "Mafia : Definitive Edition est un remake du premier épisode de la série. Se déroulant dans le milieu de la pègre des années 30, vous incarnez un jeune truand décidé à se faire une place et un nom dans le milieu. Devenez un homme envié et redouté de tous, en vous forgeant une réputation de redoutable homme de main dans votre quête pour le respect et le pouvoir au sein de la famille Salieri.",
                'date_sortie' => '2020-09-25 00:00:00',
                'image' => 'assets/images/games/mafia_definitive_edition.webp',
            ],

            [
                'titre' => "Troy",
                'description' => "Troy est le dernier opus de la licence Total War Saga. Il s'inspire de l'Iliade d'Homère, et traite du point de départ historique qui a provoqué la guerre de Troie, ajoutant à la série de nouvelles fonctionnalités inspirées par l'Histoire.",
                'date_sortie' => '2020-08-13 00:00:00',
                'image' => 'assets/images/games/troy.webp',
            ],

            [
                'titre' => "Werewolf The Apocalypse",
                'description' => "Werewolf The Apocalypse est un jeu développé par Cyanide Studio et édité par Nacon. Le joueur incarne un loup-garou au cœur d'un univers gothique-punk particulièrement sombre et se retrouve confronté à une lutte de pouvoir au sein d'une société surnaturelle corrompue.",
                'date_sortie' => '2021-02-04 00:00:00',
                'image' => 'assets/images/games/werewolf_the_apocalypse.webp',
            ],
        ];

        foreach ($tableau as $key => $value) {
            $jeu = new Jeu();
            $jeu->setTitre($value['titre']);
            $jeu->setDescription($value['description']);
            $jeu->setDateSortie(new \DateTime());
            $jeu->setImage($value['image']);

            $manager->persist($jeu);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            PlateformeFixtures::class
        ];
    }
}
