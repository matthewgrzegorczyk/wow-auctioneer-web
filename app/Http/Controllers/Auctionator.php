<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class Auctionator extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // All of the dates found in Auctionator.
        $gTimeZero = new DateTime("2000-01-01");
        $gTimeTightZero = new DateTime('2008-08-01');
        $refTime = new DateTime('2010-12-01');
        $refTimeDec13 = new DateTime('2010-12-13');
        $refTimeLocal = new DateTime('2011-01-01');
        $realDayZero = new DateTime('2010-11-15'); // Not sure yet where it comes from.

        $today = new DateTime('now');
        // var_dump($gTimeZero->diff(
        //     $today
        // )->days);
        // var_dump($gTimeTightZero->diff(
        //     $today
        // )->days);
        // var_dump($refTime->diff(
        //     $today
        // )->days);
        // var_dump($refTimeDec13->diff(
        //     $today
        // )->days);


        $auctionatorPriceDatabase = [
            "Netherwing_Horde" => [
                "Silver Bar" => [
                    "id" => "2842",
                    "H4927" => 17400,
                    "H4924" => 15360,
                    "H4925" => 14900,
                    "sc" => 4,
                    "mr" => 17400,
                    "cc" => 5,
                    "H4923" => 15360,
                    "H4921" => 11500,
                    "L4925" => 9285,
                    "L4924" => 5452,
                    "H4922" => 13925,
                ]
            ],
        ];

        foreach ($auctionatorPriceDatabase as $serverName => $items) {
            foreach ($items as $itemName => $item) {
                $itemId = $item['id'];

                foreach ($item as $key => $val) {
                    $matches = [];
                    if (preg_match('/^(H|L)(\d{4})$/', $key, $matches)) {
                        // var_dump($matches);
                        if ($matches[1] === 'H') {
                            var_dump('High: ', static::formatDate($matches[2]));
                        } else if ($matches[1] === 'L') {
                            var_dump('Low: ', static::formatDate($matches[2]));
                        }
                    }
                }
            }
        }
    }

    /**
     *  I poked around in the Auctionator code a little bit. "H3252" means highest low (compares the lowest prices of all scans that day, and keeps the highest of those) price seen on 3,252 days since "day 0" (Nov. 15, 2010).
     * The "L3252" is the absolute lowest price seen that day. If the "H" price and "L" price are the same, then the "L" price isn't stored for that day.
     *
     * @see https://www.reddit.com/r/woweconomy/comments/disy0p/how_do_i_connect_auctioneer_db_to_excel_google/
     * @param string $aucDate eg: 4927 -> 4927 days from 15.11.2010
     * @return void
     */
    private static function formatDate(string $aucDate)
    {
        $realDayZero = new DateTime('2010-11-15'); // Not sure yet where it comes from.
        $realDayZero = '2010-11-15';
        $date = date('Y-m-d', strtotime("2010-11-15 + $aucDate days"));

        return $date;
    }
}
