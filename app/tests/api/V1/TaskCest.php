<?php

declare(strict_types=1);

namespace App\Tests\Api\V1;

use App\DataFixtures\AppFixtures;
use App\Entity\User;
use App\Tests\ApiTester;
use Codeception\Util\HttpCode;

class TaskCest
{
    public function TaskList(ApiTester $I)
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
        $I->sendGet('/v1/tasks');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson(['data' => []]);
    }
}
