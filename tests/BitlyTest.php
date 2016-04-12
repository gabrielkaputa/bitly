<?php


use GabrielKaputa\Bitly\Bitly;

class BitlyTest extends \PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $bitly = new Bitly(CLIENT_ID, CLIENT_SECRET, USERNAME, PASSWORD);
        $this->assertAttributeEquals(CLIENT_ID, 'client_id', $bitly);
        $this->assertAttributeEquals(CLIENT_SECRET, 'client_secret', $bitly);
        $this->assertAttributeEquals(USERNAME, 'username', $bitly);
        $this->assertAttributeEquals(PASSWORD, 'password', $bitly);
        $this->assertAttributeEquals(base64_encode(USERNAME . ":" . PASSWORD), 'auth_header', $bitly);
    }

    public function testGetAccessToken()
    {
        $bitly = new Bitly(CLIENT_ID, CLIENT_SECRET, USERNAME, PASSWORD);
        $this->assertNotFalse($bitly->getAccessToken());
    }

    public function testShortenUrl()
    {
        $bitly = new Bitly(CLIENT_ID, CLIENT_SECRET, USERNAME, PASSWORD);
        $short_url = $bitly->shortenUrl("https://www.google.com");
        $this->assertNotFalse($short_url);
    }

    public function testInvalidCredentials()
    {
        $this->expectException(\Exception::class);
        $bitly = new Bitly(1, 1, 1, 1);
        $bitly->getAccessToken();
    }
}