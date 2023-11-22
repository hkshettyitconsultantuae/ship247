<?php

namespace App\Jobs;

use App\Models\Location;
use App\Services\MaerskAPI;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class FetchMaerskGeoIDOfLocations implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public Location $location,
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = MaerskAPI::getLocationByUNLocCode($this->location->code);
        if ($response['success'] && isset($response['data'][0])){
            $this->location->city = $response['data'][0]->cityName;
            $this->location->maersk_geo_id = $response['data'][0]->carrierGeoID;
            $this->location->save();
        }
        Log::debug('Not Found for '.$this->location->fullname);
    }
}
