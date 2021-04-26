<?php

declare(strict_types=1);

namespace App\Tests\Functional\Admin;

use App\DataFixtures\AppFixtures;
use App\Entity\Task;
use App\Entity\User;
use App\Tests\ApiTester;

class TaskCest
{
    public function createTask(ApiTester $I)
    {
        $passwordEncoder = $I->grabService('security.user_password_encoder.generic');
        $fixture = new AppFixtures($passwordEncoder);
        $I->loadFixtures($fixture);

        $user = $I->grabEntityFromRepository(
            User::class,
            [
                'email' => AppFixtures::EMAIL_TEST_USER,
            ]
        );
        $I->amLoggedInAs($user);
        $I->amOnPage('/admin/task/new');
        $I->fillField('Title', 'test task');
        $I->fillField('Comment', 'Comment');
        $I->fillField('Time spent (in minutes)', 240);
        $I->click('Save');
        $I->see('Dashboard');
        $I->seeNumRecords(1, Task::class, ['title' => 'test task']);
    }
}
