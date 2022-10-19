<?php

namespace Pavenum\LaravelWpRest\Wordpress\WpApi;

use Pavenum\LaravelWpRest\Wordpress\WpApiBaseRequest;

abstract class WpModelAbstract extends WpApiBaseRequest
{
    protected string $endpoint;

    protected int $page = 1;

    protected int $count = 10;

    protected array $params = [];

    public function __construct(?string $base_api_url = null)
    {
        parent::__construct();

        if ($base_api_url) {
            $this->withBaseApiUrl($base_api_url);
        }
    }

    protected function endpointModel(int $id): string
    {
        return rtrim($this->endpoint, '/').'/'.$id;
    }

    public function withAuth(string $user_login, string $user_password): self
    {
        $this->http = $this->http->withBasicAuth($user_login, $user_password);

        return $this;
    }

    public function withBaseApiUrl(string $base_api_url): self
    {
        $this->http = $this->http->baseUrl($base_api_url);

        return $this;
    }

    public function count(int $count)
    {
        $this->count = $count;

        return $this;
    }

    public function page(int $page)
    {
        $this->page = $page;

        return $this;
    }

    public function get()
    {
        $params = array_merge_recursive([
            'query' => [
                'per_page' => $this->count,
                'page' => $this->page,
            ],
        ], $this->params);

        return $this->makeRequest(
            endpoint: $this->endpoint,
            params: $params
        );
    }

    public function all()
    {
        $models = collect();

        $this->page(1)
            ->count(100);

        do {
            $res = $this->get();
            $models = $models->merge($res->datas);
            $this->page($this->page + 1);
        } while ($this->page <= $res->totalPages);

        return $models;
    }

    public function find(int $model_id)
    {
        try {
            return $this->findOrFail($model_id);
        } catch (\Throwable $exception) {
            return null;
        }
    }

    public function findOrFail(int $model_id)
    {
        $endpoint = $this->endpointModel($model_id);

        try {
            return $this->makeRequest(
                endpoint: $endpoint,
                params: $this->params
            );
        } catch (\Throwable $exception) {
            abort(404, $exception->getMessage());
        }
    }
}
