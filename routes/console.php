<?php

use App\Models\ServerStats;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Symfony\Component\DomCrawler\Crawler;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('stormforge:crawl', function () {
    // Log::info("Grab stormforge site and log online people.");
    $client = new \GuzzleHttp\Client();
    $response = $client->get('https://stormforge.gg/en');
    $html = $response->getBody();
    $crawler = new Crawler($html->getContents());

    $crawler->filter('.home-welcome-realms > div')->each(function (Crawler $node, $i) {
        $stats = [
            "server_name" => "",
            "players_online" => 0,
            "horde_count" => 0,
            "alliance_count" => 0,
        ];
        // Log::info($node->text());
        $serverStatusNode = $node->filter("div:nth-child(1)")->first();
        Log::info("Server Name and Status");
        Log::info($serverStatusNode->text());
        $stats['server_name'] = $serverStatusNode->filter('span')->first()->text();

        $serverOnlineNode = $node->filter("div:nth-child(2)")->first();
        Log::info("Server Online info");
        $countOnline = intval($serverOnlineNode->filter("span:nth-child(1)")->first()->text(), 10);
        Log::info("Online: $countOnline");
        $stats['players_online'] = $countOnline;

        $playersStatsNode = $node->filter("div:nth-child(3)")->first();
        Log::info("Alliance vs Horde");
        $countAlliance = $playersStatsNode->filter("span:nth-child(2)")->first()->text();
        $countHorde = $playersStatsNode->filter("span:nth-child(4)")->first()->text();
        $stats['alliance_count'] = intval($countAlliance);
        $stats['horde_count'] = intval($countHorde);
        Log::info("$countAlliance vs $countHorde");

        ServerStats::create($stats);
    });
})->everyFifteenMinutes();
