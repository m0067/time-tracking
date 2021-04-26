<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\DataFixtures\AppFixtures;
use App\Tests\FunctionalTester;

class SecurityCest
{
    public function loginWorks(FunctionalTester $I)
    {
        $this->loadFixtures($I);

        $I->amOnPage('/');
        $I->click('Login');
        $I->fillField('Email', AppFixtures::EMAIL_TEST_USER);
        $I->fillField('Password', AppFixtures::PASSWORD_TEST_USER);
        $I->click('Sign in');
        $I->see('Dashboard');
    }

    public function userDoesNotExist(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->click('Login');
        $I->fillField('Email', AppFixtures::EMAIL_TEST_USER);
        $I->fillField('Password', AppFixtures::PASSWORD_TEST_USER);
        $I->click('Sign in');
        $I->see('Email could not be found.');
    }

    public function wrongCredentials(FunctionalTester $I)
    {
        $this->loadFixtures($I);

        $I->amOnPage('/');
        $I->click('Login');
        $I->fillField('Email', AppFixtures::EMAIL_TEST_USER);
        $I->fillField('Password', 1);
        $I->click('Sign in');
        $I->see('Invalid credentials.');
    }

    private function loadFixtures(FunctionalTester $I)
    {
        $passwordEncoder = $I->grabService('security.user_password_encoder.generic');
        $fixture = new AppFixtures($passwordEncoder);
        $I->loadFixtures($fixture);
    }
}
