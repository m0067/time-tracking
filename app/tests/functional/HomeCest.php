<?php

declare(strict_types=1);

namespace App\Tests\Functional;

use App\Tests\FunctionalTester;

class HomeCest
{
    // tests
    public function frontpageWorks(FunctionalTester $I)
    {
        $I->amOnPage('/');
        $I->see('Home');
    }
}
