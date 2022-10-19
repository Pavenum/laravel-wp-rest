<?php

namespace Pavenum\LaravelWpRest\Wordpress;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Pavenum\LaravelWpRest\Exceptions\WordpressRequestException;

class WpApiBaseRequest
{
    protected string $user_agent;

    protected PendingRequest $http;

    public function __construct()
    {
        $this->user_agent = config('app.name');
        $this->http = Http::withoutVerifying();
    }

    public function setUserAgent(string $ua): self
    {
        $this->user_agent = $ua;
        return $this;
    }

    /**
     * @throws WordpressRequestException
     */
    protected function makeRequest($endpoint, $method = 'GET', $params = []): object
    {
        $res = $this->http->withUserAgent($this->user_agent)
            ->send($method, $endpoint, $params)
            ->onError(function (Response $response) {
                throw WordpressRequestException::make(
                    $response->effectiveUri()->__toString(),
                    $response->json('code'),
                    $response->json('message'),
                    $response->status()
                );
            })
        ;

        $callerFunc = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 2)[1]['function'];
        if (str_contains($callerFunc, 'find')) {
            return $res->object();
        }

        return (object) [
            'datas' => collect($res->object()),
            'total' => $res->header('X-WP-Total'),
            'totalPages' => $res->header('X-WP-TotalPages'),
            'currentPage' => $params['query']['page'] ?? null,
        ];
    }
}
