<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Flight;
use App\Models\Drain;
use App\Models\Location;
use App\Models\Useage;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class ProcessJson extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'process:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process a telemetry json file';

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
     * @return mixed
     */
    public function handle()
    {
        foreach (range(1, 3) as $num) {
            $this->process(json_decode(file_get_contents("./database/seeds/flight-${num}.json"), true));
        }
    }

    public function process($json)
    {

        $this->info("Processing flight ${json['uuid']}");

        $flight = new Flight([
            'id' => $json['uuid'],
            'name' => $json['aircraft_name'],
            'sn' => $json['aircraft_sn'],
        ]);
        $flight->save();

        $bar = $this->output->createProgressBar(count($json['frames']));
        $bar->start();

        foreach ($json['frames'] as $frame) {
            if ($frame['type'] === 'gps') {
                (new Location([
                    'flight_id' => $json['uuid'],
                    'location' => new Point($frame['lat'], $frame['long']),
                    'alt' => $frame['alt'],
                    'created_at' => Carbon::createFromTimestamp($frame['timestamp']),
                ]))->save();
            }
            if ($frame['type'] === 'battery') {
                dump($json['uuid']);
                (new Drain([
                    'flight_id' => $json['uuid'],
                    'name' => $json['batteries'][0]['battery_name'],
                    'sn' => $frame['battery_sn'],
                    'percent' => $frame['battery_percent'],
                    'temperature' => $frame['battery_temperature'],
                    'created_at' => Carbon::createFromTimestamp($frame['timestamp']),
                ]))->save();
            }
            $bar->advance();
        }
        $bar->finish();
        $this->info('');
        $this->info('Process completed');
    }
}
