<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Entity\User;
use App\Tests\FunctionalTester;

class RegistrationCest
{
    public function registerWorks(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->click('Register');
        $I->fillField('Email', 'test@app.com');
        $I->fillField('Password', '123456');
        $I->checkOption('Agree terms');
        $I->click('Sign up');
        $I->see('Dashboard!');
        $I->seeNumRecords(1, User::class, ['email' => 'test@app.com']);
    }

    public function registerDuplicate(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->click('Register');
        $I->fillField('Email', 'test1@app.com');
        $I->fillField('Password', '123456');
        $I->checkOption('Agree terms');
        $I->click('Sign up');
        $I->see('Dashboard');
        $I->seeNumRecords(1, User::class, ['email' => 'test1@app.com']);
        $I->logout();

        $I->amOnPage('/');
        $I->click('Register');
        $I->fillField('Email', 'test1@app.com');
        $I->fillField('Password', '123456');
        $I->checkOption('Agree terms');
        $I->click('Sign up');
        $I->see('There is already an account with this email');
    }

    public function wrongPassword(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->click('Register');
        $I->fillField('Email', 'test2@app.com');
        $I->fillField('Password', '12');
        $I->checkOption('Agree terms');
        $I->click('Sign up');
        $I->see('Your password should be at least 6 characters');
    }

    public function wrongEmail(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->click('Register');
        $I->fillField('Email', 'test2');
        $I->fillField('Password', '12');
        $I->checkOption('Agree terms');
        $I->click('Sign up');
        $I->see('This value is not a valid email address.');
    }
}
