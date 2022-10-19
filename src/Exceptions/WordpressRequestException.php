<?php

namespace Pavenum\LaravelWpRest\Exceptions;

use Exception;
use Throwable;

class WordpressRequestException extends Exception
{
    protected ?string $url;
    protected ?string $wp_code;

    public function __construct(string $message = "", int $code = 0, ?string $wp_code = null, ?string $url = null, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->url = $url;
        $this->wp_code = $wp_code;
    }

    public static function make($request_url, $wp_code, $message, $http_status)
    {
        return new self($message, $http_status, $wp_code, $request_url);
    }

    public function context()
    {
        return [
            'request_url' => $this->url,
            'wp_code' => $this->wp_code,
        ];
    }
}
