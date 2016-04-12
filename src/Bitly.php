<?php
namespace GabrielKaputa\Bitly;

use Httpful\Http;
use Httpful\Mime;
use Httpful\Request;

class Bitly
{
    private $client_id;
    private $client_secret;
    private $username;
    private $password;
    private $auth_header;

    const API_HOST = "https://api-ssl.bitly.com";

    private function sendRequest($endpoint, $method = Http::GET, $payload = null)
    {
        $template = Request::init()
            ->addHeader('Authorization', 'Basic ' . $this->auth_header)
            ->method($method)
            ->sendsType(Mime::JSON);
        Request::ini($template);
        $r = null;
        switch ($method) {
            case Http::GET:
                $r = Request::get(self::API_HOST . $endpoint . '?' . http_build_query($payload))->send();
                break;
            case
            Http::POST:
                $r = Request::post(self::API_HOST . $endpoint)->body(json_encode($payload))->send();
                break;
            default:
                throw new \Exception("Method not implemented.");
                break;
        }
        if ($r->hasErrors() || isset($r->body->status_code) && $r->body->status_code != 200) {
            throw new \Exception($r);
        }
        return $r;
    }

    public function __construct($client_id, $client_secret, $username, $password)
    {
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
        $this->username = $username;
        $this->password = $password;
        $this->auth_header = base64_encode($this->username . ":" . $this->password);
    }

    public function getAccessToken()
    {
        $params = [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret
        ];
        return $this->sendRequest("/oauth/access_token", Http::POST, $params)->body;
    }

    public function shortenUrl($url)
    {
        $params = [
            'access_token' => $this->getAccessToken(),
            'longUrl' => $url
        ];
        $response = $this->sendRequest("/v3/shorten", Http::GET, $params);
        if (isset($response->body->data->url)) {
            return $response->body->data->url;
        }
        return false;
    }
}