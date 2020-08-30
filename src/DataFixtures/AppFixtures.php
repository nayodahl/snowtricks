<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Video;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create categories
        $grab = (new Category())->setName('grab');
        $manager->persist($grab);
        $rotation = (new Category())->setName('rotation');
        $manager->persist($rotation);
        $flip = (new Category())->setName('flip');
        $manager->persist($flip);
        $slide = (new Category())->setName('slide');
        $manager->persist($slide);
        $category = (new Category())->setName('one foot');
        $manager->persist($category);
        $category = (new Category())->setName('old school');
        $manager->persist($category);
        $category = (new Category())->setName('rotation désaxée');
        $manager->persist($category);

        // create 10 tricks
        $methodAir = (new Trick())->setTitle('method air')
            ->setDescription('Cette figure – qui consiste à attraper sa planche d\'une main et le tourner perpendiculairement au sol – est un classique "old school". Il n\'empêche qu\'il est indémodable, avec de vrais ambassadeurs comme Jamie Lynn ou la star Terje Haakonsen. En 2007, ce dernier a même battu le record du monde du "air" le plus haut en s\'élevant à 9,8 mètres au-dessus du kick (sommet d\'un mur d\'une rampe ou autre structure de saut). ')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime())
            ->setCategory($grab);
        $image = (new Image())
            ->setContent('method-air1.jpg')
            ->setTrick($methodAir)
            ->setFeatured('0')
            ->setCreated(new DateTime());
        $manager->persist($image);
        $image = (new Image())
        ->setContent('method-air2.jpeg')
        ->setTrick($methodAir)
        ->setFeatured('1')
        ->setCreated(new DateTime());
        $manager->persist($image);
        $image = (new Image())
        ->setContent('method-air3.jpg')
        ->setTrick($methodAir)
        ->setFeatured('0')
        ->setCreated(new DateTime());
        $manager->persist($image);
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/_hxLS2ErMiY')
            ->setTrick($methodAir)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->persist($methodAir);

        $noseGrab = (new Trick())->setTitle('nose grab')
            ->setDescription('saisie de la partie avant de la planche, avec la main avant')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime())
            ->setCategory($grab);
        $image = (new Image())
            ->setContent('nose-grab1.jpg')
            ->setTrick($noseGrab)
            ->setFeatured('1')
            ->setCreated(new DateTime());
        $manager->persist($image);
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/_Qq-YoXwNQY')
            ->setTrick($noseGrab)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->persist($noseGrab);

        $doubleBackFlip = (new Trick())->setTitle('double back flip')
        ->setDescription('Le backflip figure parmi les sauts les plus spectaculaires de cette discipline. Il nécessite la maîtrise des fondamentaux et d’une bonne perception du corps. En effet, avoir la tête en bas, même pendant quelques secondes seulement, est très difficile pour les non-initiés. Heureusement, il est possible de s’entrainer sur un trampoline avant de transposer les mouvements sur les pistes. ')
        ->setCreated(new DateTime())
        ->setLastUpdate(new DateTime())
        ->setCategory($flip);
        $image = (new Image())
            ->setContent('double-back-flip1.jpg')
            ->setTrick($doubleBackFlip)
            ->setFeatured('0')
            ->setCreated(new DateTime());
        $manager->persist($image);
        $image = (new Image())
        ->setContent('double-back-flip2.jpg')
        ->setTrick($doubleBackFlip)
        ->setFeatured('1')
        ->setCreated(new DateTime());
        $manager->persist($image);
        $image = (new Image())
        ->setContent('double-back-flip3.jpg')
        ->setTrick($doubleBackFlip)
        ->setFeatured('0')
        ->setCreated(new DateTime());
        $manager->persist($image);
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/ZlNmeM1XdM4')
            ->setTrick($doubleBackFlip)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->persist($doubleBackFlip);

        $japanAir = (new Trick())->setTitle('japan air')
        ->setDescription('saisie de l\'avant de la planche, avec la main avant, du côté de la carre frontside.')
        ->setCreated(new DateTime())
        ->setLastUpdate(new DateTime())
        ->setCategory($grab);
        $image = (new Image())
            ->setContent('japan-air1.jpg')
            ->setTrick($japanAir)
            ->setFeatured('0')
            ->setCreated(new DateTime());
        $manager->persist($image);
        $image = (new Image())
        ->setContent('japan-air2.jpg')
        ->setTrick($japanAir)
        ->setFeatured('1')
        ->setCreated(new DateTime());
        $manager->persist($image);
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/CzDjM7h_Fwo')
            ->setTrick($japanAir)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->persist($japanAir);

        $frontsite360 = (new Trick())->setTitle('frontsite 360')
        ->setDescription('Le 3.6 front ou frontside 3 est un tricks intéressant car on peut y mettre facilement beaucoup de style. C’est une rotation de 360 degrés du côté frontside ( à gauche pour les regular et à droite pour les goofy). Comme le 3.6 back, la vitesse de rotation est assez facile à gérer, mais si l’impulsion parait plus évidente en lançant les épaules de face, l’atterrissage l\'est beaucoup moins car on est de dos le dernier quart du saut. On appelle ça une reception blind side…')
        ->setCreated(new DateTime())
        ->setLastUpdate(new DateTime())
        ->setCategory($rotation);
        $image = (new Image())
            ->setContent('frontsite360-1.jpg')
            ->setTrick($frontsite360)
            ->setFeatured('0')
            ->setCreated(new DateTime());
        $manager->persist($image);
        $image = (new Image())
        ->setContent('frontsite360-2.jpg')
        ->setTrick($frontsite360)
        ->setFeatured('1')
        ->setCreated(new DateTime());
        $manager->persist($image);
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/9T5AWWDxYM4')
            ->setTrick($frontsite360)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/SLncsNaU6es')
            ->setTrick($frontsite360)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->persist($frontsite360);

        $backsideAir = (new Trick())->setTitle('backside air')
        ->setDescription('Mais en fait, pourquoi le Backside air est-il aussi emblématique? C’est vrai quoi, il existe des tricks bien plus compliqués que ça dans le snowboard moderne, d’autres aussi avec des noms bien plus amusants… Mais rappelle-toi: le backside air est le seul trick que tu ne peux pas faire en ski – déjà ça pose. Ensuite, c’est sans doute le trick qui marque le plus ta personnalité, car il y a 10.000 manières de le faire. Enfin, pour un trick “simple”, il est tout de même assez technique. Il faut l’envoyer en avançant le buste au pop, et vraiment s’engager dans les airs pour pouvoir bien grabber comme il se doit. Voilà à notre avis trois raisons majeures à ce succès du backside air, toutes générations et tous pratiquants confondus')
        ->setCreated(new DateTime())
        ->setLastUpdate(new DateTime())
        ->setCategory($grab);
        $image = (new Image())
            ->setContent('backside-air1.jpg')
            ->setTrick($backsideAir)
            ->setFeatured('0')
            ->setCreated(new DateTime());
        $manager->persist($image);
        $image = (new Image())
        ->setContent('backside-air2.jpg')
        ->setTrick($backsideAir)
        ->setFeatured('1')
        ->setCreated(new DateTime());
        $manager->persist($image);
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/_CN_yyEn78M')
            ->setTrick($backsideAir)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->persist($backsideAir);

        $frontsideBoardslide = (new Trick())->setTitle('frontsite boardslide')
        ->setDescription('Un slide est dit «board slide » lorsque le rider slide littéralement sur la board. Cela est simple à comprendre lorsque l’on connait le slide 50-50. En skateboard, le 50-50 signifie 50% sur le trucks arrière et 50% sur le trucks avant. Il en est de même en snowboard malgré l’absence de trucks.
        Le board slide est alors un slide sur le milieu de la board. Cela impose d’avoir la board à 90° par rapport au module (rail ou boxe), tout comme cela serait en skateboard.')
        ->setCreated(new DateTime())
        ->setLastUpdate(new DateTime())
        ->setCategory($slide);
        $image = (new Image())
            ->setContent('frontside-boardslide1.jpg')
            ->setTrick($frontsideBoardslide)
            ->setFeatured('0')
            ->setCreated(new DateTime());
        $manager->persist($image);
        $image = (new Image())
        ->setContent('frontside-boardslide2.jpg')
        ->setTrick($frontsideBoardslide)
        ->setFeatured('1')
        ->setCreated(new DateTime());
        $manager->persist($image);
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/12OHPNTeoRs')
            ->setTrick($frontsideBoardslide)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->persist($frontsideBoardslide);

        $fiftyfifty = (new Trick())->setTitle('50-50')
        ->setDescription('Un 50-50 consiste simplement à glisser le long d\'un élement, le contact entre la board et la cible s\'effectuant -en l\'occurrence- au niveau des deux axes (en même temps).')
        ->setCreated(new DateTime())
        ->setLastUpdate(new DateTime())
        ->setCategory($slide);
        $image = (new Image())
            ->setContent('50-50-1.jpg')
            ->setTrick($fiftyfifty)
            ->setFeatured('1')
            ->setCreated(new DateTime());
        $manager->persist($image);
        $image = (new Image())
        ->setContent('50-50-2.jpg')
        ->setTrick($fiftyfifty)
        ->setFeatured('0')
        ->setCreated(new DateTime());
        $manager->persist($image);
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/kxZbQGjSg4w')
            ->setTrick($fiftyfifty)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->persist($fiftyfifty);

        $bluntslide270 = (new Trick())->setTitle('Front Bluntslide 270')
        ->setDescription('Un slide où il faut faire passer le pied avant au-dessus du rail en arrivant, avec la board perpendiculaire au rail, et faire 3/4 d\'un tour sur le rail.')
        ->setCreated(new DateTime())
        ->setLastUpdate(new DateTime())
        ->setCategory($slide);
        $image = (new Image())
            ->setContent('front-bluntslide-270-1.jpg')
            ->setTrick($bluntslide270)
            ->setFeatured('1')
            ->setCreated(new DateTime());
        $manager->persist($image);
        $image = (new Image())
        ->setContent('front-bluntslide-270-2.jpg')
        ->setTrick($bluntslide270)
        ->setFeatured('0')
        ->setCreated(new DateTime());
        $manager->persist($image);
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/O5DpwZjCsgA')
            ->setTrick($bluntslide270)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->persist($bluntslide270);

        $tailGrab = (new Trick())->setTitle('Tail grab')
        ->setDescription('Si vous voulez faire un tail grab, cela est possible en snowboard par un mouvement d’assiette de la planche obtenu par une dysmétrie dans la montée des jambes.
        Le bras qui n’attrape pas sert de contre-balancier et il se place généralement à l’opposé de celui qui attrape.')
        ->setCreated(new DateTime())
        ->setLastUpdate(new DateTime())
        ->setCategory($grab);
        $image = (new Image())
            ->setContent('tail-grab-1.jpg')
            ->setTrick($tailGrab)
            ->setFeatured('1')
            ->setCreated(new DateTime());
        $manager->persist($image);
        $image = (new Image())
        ->setContent('tail-grab-2.jpg')
        ->setTrick($tailGrab)
        ->setFeatured('0')
        ->setCreated(new DateTime());
        $manager->persist($image);
        $video = (new Video())
            ->setAddress('https://www.youtube.com/embed/id8VKl9RVQw')
            ->setTrick($tailGrab)
            ->setCreated(new DateTime());
        $manager->persist($video);
        $manager->persist($tailGrab);

        // create user Jimmy
        $user = (new User())
            ->setLogin('jimmy')
            ->setPassword('jimmy')
            ->setEmail('jimmy@snowtricks.fr')
            ->setPhoto('jimmy-avatar.jpg')
            ->setActivated('1')
            ->setCreated(new DateTime())
            ->setLastUpdate(new DateTime());
        $manager->persist($user);

        $manager->flush();
    }
}
