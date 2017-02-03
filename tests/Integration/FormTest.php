<?php
namespace App\Tests\Integration;

use App\Tests\SeleniumTestCase;

class FormTest extends SeleniumTestCase
{
    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl(APP_URL);
    }
    
    /**
     * @test
     */
    public function shorten_url_form_can_be_submitted() {
        $this->url(APP_URL);

        $this->byName('url')->value('example.com');
        $this->byName('submit')->submit();

        sleep(1);

        $content = $this->byTag('body')->text();
        $this->assertNotFalse(strpos($content, "Your shortened URL is"));
    }
}
