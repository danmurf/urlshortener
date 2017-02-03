<?php
namespace App\Tests\Integration;

use App\Tests\SeleniumTestCase;
use App\Models\Url;

class RedirectionTest extends SeleniumTestCase
{
    protected function setUp()
    {
        $this->setBrowser('firefox');
        $this->setBrowserUrl(APP_URL);
    }

    /**
     * @test
     */
    public function user_is_redirected_when_visiting_shortened_url() {
        $originalUrl = 'http://example.com';

        $url = new Url;
        $shortenedUrl = $url->shorten($originalUrl);

        $this->url($shortenedUrl);
        $this->assertEquals($originalUrl, $this->url());
    }
}
