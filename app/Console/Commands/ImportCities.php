<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\City;
use App\Models\Country;

class ImportCities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:cities';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import cities with russian and english names';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        //The path to the large file.
        $fileName = public_path().'/pb_city.json';
        //Open the file in "reading only" mode.
        $fileHandle = fopen($fileName, "r");
        //If we failed to get a file handle, throw an Exception.
        if($fileHandle === false){
            throw new Exception('Could not get file handle for: ' . $fileName);
        }
        //While we haven't reach the end of the file.
        // $i = 0;
        while(!feof($fileHandle)) { // && $i<1
            // if($i>=0) {
            //Read the current line in.
            $line = fgets($fileHandle);
            //Do whatever you want to do with the line.
            $city = json_decode($line,true);
            $data['name'] = json_encode(["ru" => $city['name'], "en" => $city['english']], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            $data['longitude'] = $city['longitude']==null?0:$city['longitude'];
            $data['latitude'] = $city['latitude']==null?0:$city['latitude'];
            $data['country_id'] = optional(Country::where('iso2', $city['country'])->first())->id;
            $data['country_code'] = $city['country'];
            $data['wikiDataId'] = $city['wiki'];
            City::create($data);
            // }

            // $i++;
        }
        //Finally, close the file handle.
        fclose($fileHandle);
    }
}
