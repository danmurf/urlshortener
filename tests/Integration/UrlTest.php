<?php
namespace App\Tests\Integration;

use App\Tests\TestCase;
use App\Models\Url;
use App\Library\Database;

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

    /**
     * @test
     */
    public function can_shorten_url() {
        $originalUrl = 'http://example.com/section/subsection/excellent-article.php?autoplay=true#bestbit';

        $url = new Url;
        $shortenedUrl = $url->shorten($originalUrl);

        //Check that it is not the same URL anymore
        $this->assertNotEquals($originalUrl, $shortenedUrl);

        //Check that the returned URL is short (defined by the domain + specified shortened path length)
        $expectedShortenedUrlLength = strlen(APP_URL . '/') + SHORTENED_URL_PATH_LENGTH;
        $this->assertEquals($expectedShortenedUrlLength, strlen($shortenedUrl));
    }

    /**
     * @test
     */
    public function can_translate_shortened_url_back_into_original_url() {
        //Store a URL
        $url = new Url;
        $originalUrl = "http://example.com/first-stored-url";
        $shortenedUrl = $url->shorten($originalUrl);

        //Now fetch the original URL based on the shortened URL
        $translatedUrl = $url->fetchFullUrl($shortenedUrl);

        $this->assertEquals($originalUrl, $translatedUrl);
    }

    /**
     * @test
     */
    public function can_save_url_to_the_database() {
        $originalUrl = 'http://example.com/section/subsection/excellent-article.php?autoplay=true#bestbit2';

        $url = new Url;
        $shortenedUrl = $url->shorten($originalUrl);

        $database = new Database;
        $database->query("SELECT * FROM urls WHERE url = ?", [$originalUrl]);

        $this->assertEquals(1, $database->affectedRows());
    }

    /**
     * @test
     */
    public function returns_same_path_for_urls_which_already_exist_in_the_database() {
        $originalUrl = 'http://example.com/section/subsection/excellent-article.php?autoplay=true#bestbit3';

        $url = new Url;
        $firstShortenedUrl = $url->shorten($originalUrl);

        //Clear and run again
        $url = new Url;
        $secondShortenedUrl = $url->shorten($originalUrl);

        $this->assertEquals($firstShortenedUrl, $secondShortenedUrl);
    }
}
