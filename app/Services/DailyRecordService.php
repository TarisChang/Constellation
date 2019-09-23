<?php

namespace App\Services;

use App\DailyRecord;

class DailyRecordService
{
    public function filter12ConstellationHerf($crawler)
    {
        return $crawler->filter('div[class="STAR12_BOX"] > ul > li > a')->each(function ($node) {
            return ($node->attr('href'));
        });
    }

    public function filterSpecificConstellationData($htmlDom, $href)
    {
        $crawler = $htmlDom->request('GET', $href);
        $script  = $crawler->filter('script')->text();
        $link    = substr(trim($script), 15, -2);
        $crawler = $htmlDom->request('GET', $link);

        $date = $crawler->filter('#iAcDay > option[selected="selected"]')->text();

        $name = $crawler->filter('div[class="TODAY_CONTENT"] > h3')->text();
        $name = mb_substr($name, 2, -2);

        $totalDescription = $crawler->filter('div[class="TODAY_CONTENT"] > p')->each(function ($node) {
            return ($node->text());
        });

        $data = [
            'date'       => $date,
            'name'       => $name,
            'total_n'    => substr_count($totalDescription[0], '★'),
            'total_d'    => $totalDescription[1],
            'love_n'     => substr_count($totalDescription[2], '★'),
            'love_d'     => $totalDescription[3],
            'work_n'     => substr_count($totalDescription[4], '★'),
            'work_d'     => $totalDescription[5],
            'money_n'    => substr_count($totalDescription[6], '★'),
            'money_d'    => $totalDescription[7],
            'updated_at' => date('Y-m-d H:i:s')
        ];

        return $data;
    }


    public function getDailyRecordByDateAndName($date, $name)
    {
        return $oldValue = DailyRecord::where([
            'date' => $date,
            'name' => $name
        ])->get();
    }

    public function insertToDB($data)
    {
        return DailyRecord::insert($data);
    }

    public function getDailyRecordByDate($date)
    {
        return $oldValue = DailyRecord::where([
            'date' => $date
        ])->get();
    }
}
