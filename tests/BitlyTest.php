<?php


use GabrielKaputa\Bitly\Bitly;

class BitlyTest extends \PHPUnit_Framework_TestCase
{
    public function testConstructWithAccessToken()
    {
        $bitly = Bitly::withGenericAccessToken(GENERIC_ACCESS_TOKEN);
        $this->assertAttributeEquals(GENERIC_ACCESS_TOKEN, 'access_token', $bitly);
    }

    public function testConstructWithCredentials()
    {
        $bitly = Bitly::withCredentials(CLIENT_ID, CLIENT_SECRET, USERNAME, PASSWORD);
        $this->assertAttributeEquals(CLIENT_ID, 'client_id', $bitly);
        $this->assertAttributeEquals(CLIENT_SECRET, 'client_secret', $bitly);
        $this->assertAttributeEquals(USERNAME, 'username', $bitly);
        $this->assertAttributeEquals(PASSWORD, 'password', $bitly);
        $this->assertAttributeEquals(base64_encode(USERNAME . ":" . PASSWORD), 'auth_header', $bitly);
    }

    public function testGetAccessTokenWithAccessToken()
    {
        $bitly = Bitly::withGenericAccessToken(GENERIC_ACCESS_TOKEN);
        $this->assertEquals(GENERIC_ACCESS_TOKEN, $bitly->getAccessToken());
    }

    public function testGetAccessTokenWithCredentials()
    {
        $bitly = Bitly::withCredentials(CLIENT_ID, CLIENT_SECRET, USERNAME, PASSWORD);
        $this->assertNotFalse($bitly->getAccessToken());
    }

    public function testShortenUrlWithAccessToken()
    {
        $bitly = Bitly::withGenericAccessToken(GENERIC_ACCESS_TOKEN);
        $short_url = $bitly->shortenUrl("https://www.google.com");
        $this->assertNotFalse($short_url);
    }

    public function testShortenUrlWithCredentials()
    {
        $bitly = Bitly::withCredentials(CLIENT_ID, CLIENT_SECRET, USERNAME, PASSWORD);
        $short_url = $bitly->shortenUrl("https://www.google.com");
        $this->assertNotFalse($short_url);
    }

    public function testInvalidCredentials()
    {
        $this->expectException(\Exception::class);
        $bitly = Bitly::withCredentials(1, 1, 1, 1);
        $bitly->getAccessToken();
    }
}