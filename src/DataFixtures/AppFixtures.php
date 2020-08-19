<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Comment;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\User;
use App\Entity\Video;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $faker->addProvider(new Faker\Provider\Youtube($faker));

        // create 10 categories! Bam!
        for ($i = 1; $i <= 10; ++$i) {
            $category = new Category();
            $category->setName('category n° '.$faker->randomDigitNotNull);
            $category->setCreated(new DateTime());
            $category->setLastUpdate(new DateTime());

            // create 2 tricks, images and video per category
            for ($j = 1; $j <= 2; ++$j) {
                $trick = new Trick();
                $trick->setTitle($faker->words(2, true));
                $trick->setDescription($faker->paragraph(5, false));
                $trick->setCreated(new DateTime());
                $trick->setLastUpdate(new DateTime());
                $trick->setCategory($category);
                $manager->persist($trick);

                // create Image for trick
                $image = new Image();
                $image->setContent($faker->image('public/img/trick/', 860, 580, null, false));
                $image->setTrick($trick);
                $image->setCreated(new DateTime());
                $image->setLastUpdate(new DateTime());
                $manager->persist($image);

                // create video for trick
                $video = new Video();
                $video->setAddress($faker->youtubeEmbedUri());
                $video->setTrick($trick);
                $video->setCreated(new DateTime());
                $video->setLastUpdate(new DateTime());
                $manager->persist($video);
            }
            $manager->persist($category);
        }

        // create 10 users
        for ($i = 1; $i <= 10; ++$i) {
            $user = new User();
            $user->setLogin($faker->userName);
            $user->setPassword($faker->password);
            $user->setEmail($faker->email);
            $user->setPhoto($faker->image('public/img/avatar/', 128, 128, 'people', false));
            $user->setActivated('1');
            $user->setCreated(new DateTime());
            $user->setLastUpdate(new DateTime());

            // create 3 comments per user
            for ($j = 1; $j <= 3; ++$j) {
                $comment = new Comment();
                $comment->setContent($faker->sentence);
                $comment->setUser($user);
                $comment->setTrick($trick);
                $comment->setCreated(new DateTime());
                $comment->setLastUpdate(new DateTime());
                $manager->persist($comment);
            }
            $manager->persist($user);
        }

        $manager->flush();
    }
}
