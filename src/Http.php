<?php

namespace Coderjerk\Cupsets;

use GuzzleHttp;
use GuzzleHttp\Exception\GuzzleException;
use Coderjerk\Cupsets\Cache;

class Http
{
    protected static string $base_uri = "https://api.football-data.org/v4/";

    public static function client(): GuzzleHttp\Client
    {
        return new GuzzleHttp\Client([
            'base_uri' => static::$base_uri,
            'timeout' => 15,
            'connect_timeout' => 15,
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public static function getCompetitionData(Competition $competition, string $source)
    {
        $id = $competition->id;

        if (!$id) {
            Log::error("Competition id not set");
            return false;
        }

        $endpoint = match ($source) {
            'standings' => "competitions/$id/standings",
            'matches' => "competitions/$id/matches",
            'teams' => "competitions/$id/teams",
            default => "",
        };

        if (Cache::get($endpoint)) {
            return Cache::get($endpoint);
        } else {
            return self::getRemoteData($endpoint);
        }
    }

    /**
     * @throws GuzzleException
     */
    public static function getRemoteData(string $endpoint)
    {
        try {
            $results = self::client()->request('GET', "{$endpoint}", [
                'headers' => [
                    'X-Auth-Token' => $_ENV['FOOTBALL_DATA_API_TOKEN'],
                ],
                'query' => ['season' => 2026]
            ]);
            if ($results->getStatusCode() == 200) {
                $results = json_decode($results->getBody()->getContents());
                Cache::set($endpoint, $results);
                return $results;
            }
        } catch (GuzzleException $e) {
            return $e->getMessage();
        }
    }
}
