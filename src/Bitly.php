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
    private $access_token;

    const API_HOST = "https://api-ssl.bitly.com";

    private function sendRequest($endpoint, $method = Http::GET, $payload = null)
    {
        $template = Request::init()
            ->method($method)
            ->sendsType(Mime::JSON);
        if (isset($this->auth_header)) {
            $template->addHeader('Authorization', 'Basic ' . $this->auth_header);
        }
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

    public static function withCredentials($client_id, $client_secret, $username, $password)
    {
        $bitly = new Bitly();
        $bitly->client_id = $client_id;
        $bitly->client_secret = $client_secret;
        $bitly->username = $username;
        $bitly->password = $password;
        $bitly->auth_header = base64_encode($bitly->username . ":" . $bitly->password);
        return $bitly;
    }

    public static function withGenericAccessToken($access_token)
    {
        $bitly = new Bitly();
        $bitly->access_token = $access_token;
        return $bitly;
    }

    public function getAccessToken()
    {
        if (isset($this->access_token)) return $this->access_token;
        $params = [
            'client_id' => $this->client_id,
            'client_secret' => $this->client_secret
        ];
        $this->access_token = $this->sendRequest("/oauth/access_token", Http::POST, $params)->body;
        return $this->access_token;
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