<?php

namespace Pavenum\LaravelWpRest\Wordpress;

class WpApi extends WpApiBaseRequest
{
    public function __construct(?string $base_api_url = null)
    {
        parent::__construct();

        if ($base_api_url) {
            $this->setBaseApiUrl($base_api_url);
        }
    }

    public function setBaseApiUrl(string $base_api_url): self
    {
        $this->http = $this->http->baseUrl($base_api_url);

        return $this;
    }

    public function setAuth(string $user_login, string $user_password): self
    {
        $this->http = $this->http->withBasicAuth($user_login, $user_password);

        return $this;
    }

    public function getCurrentUser(): object
    {
        $endpoint = '/wp/v2/users/me';

        return $this->makeRequest(endpoint: $endpoint);
    }

    public function getUsers($page = 1, $per_page = 10): object
    {
        $endpoint = '/wp/v2/users';
        $params = [
            'query' => [
                'per_page' => $per_page,
                'page' => $page,
            ],
        ];

        return $this->makeRequest(endpoint: $endpoint, params: $params);
    }

    public function getPosts($page = 1, $per_page = 10): object
    {
        $endpoint = '/wp/v2/posts';

        $params = [
            'query' => [
                'per_page' => $per_page,
                'page' => $page,
            ],
        ];

        return $this->makeRequest(endpoint: $endpoint, params: $params);
    }

    public function getPlugins(?string $search = null, ?string $status = null): object
    {
        $endpoint = '/wp/v2/plugins';

        $params = [
            'query' => [
                'status' => $status,
                'search' => $search,
            ],
        ];

        return $this->makeRequest(endpoint: $endpoint, params: $params);
    }
}
