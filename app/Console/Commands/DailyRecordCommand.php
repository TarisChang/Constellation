<?php

namespace App\Console\Commands;

use App\Services\DailyRecordService;
use Exception;
use Goutte\Client as htmlClient;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class DailyRecordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'DailyRecordCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '每日星座運勢';


    private $dailyRecordService;
    private $htmlDom;

    /**
     * DailyRecordCommand constructor.
     * @param DailyRecordService $dailyRecordService
     */
    public function __construct(DailyRecordService $dailyRecordService)
    {
        parent::__construct();
        $this->dailyRecordService = $dailyRecordService;
        $this->htmlDom            = new htmlClient();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $url     = 'http://astro.click108.com.tw/';
            $crawler = $this->htmlDom->request('GET', $url);

            $constellationUrls = $this->dailyRecordService->filter12ConstellationHerf($crawler);

            $insertToDbData = [];
            foreach ($constellationUrls as $constellationUrl) {
                $data = $this->dailyRecordService->filterSpecificConstellationData($this->htmlDom, $constellationUrl);

                $oldValue = $this->dailyRecordService->getDailyRecordByDateAndName($data['date'], $data['name']);

                if ($oldValue->isEmpty()) {
                    array_push($insertToDbData, $data);
                }
            }

            if (empty($insertToDbData)){
                throw new Exception('Insert Data Null');
            }
            $insertResult = $this->dailyRecordService->insertToDB($insertToDbData);

            if ($insertResult) {
                Log::info('Daily Record Insert To DB Success');
            } else {
                Log::error('Daily Record Insert To DB Fail');
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
