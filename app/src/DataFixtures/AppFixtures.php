<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    public const EMAIL_TEST_USER = 'test@app.com';
    public const PASSWORD_TEST_USER = 123456;

    private UserPasswordEncoderInterface $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $task = new Task();
        $task->setTitle('Task 1');
        $task->setDate(new \DateTimeImmutable());
        $task->setComment('Comment');
        $task->setTimeSpent(240);

        $user = new User();
        $user->setEmail(self::EMAIL_TEST_USER);
        $user->setRoles([User::ROLE_ADMIN]);
        $user->setPassword(
            $this->passwordEncoder->encodePassword(
                $user,
                self::PASSWORD_TEST_USER
            )
        );
        $user->addTask($task);
        $manager->persist($task);
        $manager->persist($user);

        $manager->flush();
    }
}
