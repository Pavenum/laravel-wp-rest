<?php

namespace Pavenum\LaravelWpRest\Wordpress;

use Exception;
use GuzzleHttp\Psr7\Header;
use Pavenum\LaravelWpRest\Exceptions\WordpressRequestException;
use Throwable;

class WpApiGuest extends WpApiBaseRequest
{
    /**
     * @throws WordpressRequestException
     * @throws Exception
     */
    public function findApiBaseUrl(string $website_home_url): string|false
    {
        $response = $this->makeRequest(endpoint: $website_home_url, method: 'HEAD');

        if ($response->header('Link')) {
            $links = Header::parse($response->header('Link'));
            foreach ($links as $link) {
                if (isset($link["rel"]) && $link["rel"] === "https://api.w.org/") {
                    return trim($link[0], '<>');
                }
            }
        }

        $default_base_api_url = rtrim($website_home_url, '/') . '/wp-json';

        foreach(['HEAD', 'GET'] as $method) {
            $check = $this->makeRequest($default_base_api_url, $method);

            if ($check->successful()) {
                return $default_base_api_url;
            }
        }

        throw new Exception('Could not find the base API URL', 404);
    }

    /**
     * @throws WordpressRequestException
     * @throws Exception
     */
    public function findBaseAppPasswordsAuthUrl(string $base_api_url): string|false
    {
        $response = $this->makeRequest(endpoint:  $base_api_url);
        $app_passwords = object_get($response, 'authentication.application-passwords.endpoints.authorization', false);

        if (!$app_passwords) {
            throw new Exception('Application Passwords not enabled on this website', 400);
        }

        return $app_passwords;
    }

    /**
     * @throws Throwable
     */
    public function createAppPasswordsAuthUrl($base_api_url, $app_name, $success_url, $reject_url, $app_id = null): string|false
    {
        // success and reject url should be secure
        $scheme_success_url = parse_url($success_url, PHP_URL_SCHEME);
        $scheme_reject_url = parse_url($reject_url, PHP_URL_SCHEME);

        throw_unless($scheme_success_url === 'https', Exception::class, "Success url have to be secured (https)", 400);
        throw_unless($scheme_reject_url === 'https', Exception::class, "Reject url have to be secured (https)", 400);

        $query = http_build_query([
            'app_name' => $app_name,
            'success_url' => $success_url,
            'reject_url' => $reject_url,
            'app_id' => $app_id,
        ]);

        $auth_app_url = $this->findBaseAppPasswordsAuthUrl($base_api_url);

        return $auth_app_url . '?' . $query;
    }
}
