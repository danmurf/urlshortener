<?php
namespace App\Tests\Integration;

use App\Tests\TestCase;
use App\Models\Url;

class UrlTest extends TestCase
{
    /**
     * @test
     */
    public function can_check_if_a_url_is_valid() {
        $url = new Url;

        //Test a valid url
        $this->assertTrue($url->isValid('http://example-domain.com?q=hello#world'));

        //Test an invalid url
        $this->assertFalse($url->isValid('http://bad_example.com'));
    }
}
