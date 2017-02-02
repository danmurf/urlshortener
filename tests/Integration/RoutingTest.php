<?php
namespace App\Tests\Integration;

use App\Tests\SeleniumTestCase;

class RoutingTest extends SeleniumTestCase
{
    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl(APP_URL);
    }

    /**
     * @test
     */
    public function can_visit_the_home_page()
    {
        $this->url(APP_URL);
        $this->assertEquals(APP_NAME, $this->title());
    }
}
