<?php

namespace HermesDj\Seat\SeatPlanetaryIndustry\Commands\Sde;

use GuzzleHttp\Client;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\FactoryInput;
use HermesDj\Seat\SeatPlanetaryIndustry\Models\Schematic;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Helper\ProgressBar;

class PlanetarySdeCommand extends Command
{
    protected $signature = 'eve:update:sde:planetary';

    protected $description = 'Updates the EVE Online SDE Data for Planetary schematics';

    protected object $json;

    protected string $storage_path;
    private Client $guzzle;

    private array $fileNames = ['planetSchematics', 'planetSchematicsTypeMap'];

    private string $format = '.csv.bz2';

    private string $extracted_format = '.csv';

    public function handle(): int
    {
        $this->json = $this->getJsonResource();

        if (!$this->json) {

            $this->warn('Unable to reach the resources endpoint.');

            return $this::FAILURE;
        }

        if (!$this->isStorageOk()) {

            $this->error('Storage path is not OK. Please check permissions');

            return $this::INVALID;
        }

        $this->downloadSchematics();
        $this->importSchematics();


        return $this::SUCCESS;
    }

    public function getJsonResource()
    {

        $result = $this->getGuzzle()->request('GET',
            'https://raw.githubusercontent.com/eveseat/resources/master/sde.json', [
                'headers' => ['Accept' => 'application/json'],
            ]);

        if ($result->getStatusCode() != 200)
            return json_encode([]);

        return json_decode($result->getBody());
    }

    public function getGuzzle(): Client
    {

        if (isset($this->guzzle)) {
            return $this->guzzle;
        }

        $this->guzzle = new Client();

        return $this->guzzle;
    }

    public function downloadSchematics(): void
    {
        $bar = $this->getProgressBar(count($this->fileNames));

        foreach ($this->fileNames as $fileName) {
            $url = str_replace(':version', $this->json->version, $this->json->url) . $fileName . $this->format;
            $destination = $this->storage_path . $fileName . $this->format;

            $file_handler = fopen($destination, 'w');

            $result = $this->getGuzzle()->request('GET', $url, [
                'sink' => $file_handler
            ]);

            fclose($file_handler);

            if ($result->getStatusCode() != 200)
                $this->error('Unable to download ' . $url .
                    '. The HTTP response was: ' . $result->getStatusCode());

            $bar->advance();
        }

        $bar->finish();
        $this->line('');
    }

    public function importSchematics(): void
    {
        foreach ($this->fileNames as $fileName) {
            $archive_path = $this->storage_path . $fileName . $this->format;
            $extracted_path = $this->storage_path . $fileName . $this->extracted_format;

            if (!File::exists($archive_path)) {
                $this->warn($archive_path . ' seems to be invalid. Skipping.');
                continue;
            }

            $this->info("Uncompressing file $fileName");

            $this->uncompressFile($archive_path, $extracted_path);

            $this->info("Reading file $fileName");

            $data = [];
            $row = 1;
            if (($handle = fopen($extracted_path, 'r')) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                    if ($row == 1) {
                        // Header
                        $row++;
                        continue;
                    }

                    $row++;

                    switch ($fileName) {
                        case 'planetSchematics':
                            $schematicID = $data[0];
                            $schematicName = $data[1];
                            $cycleTime = $data[2];

                            Schematic::firstOrNew([
                                'schematic_id' => $schematicID
                            ])->fill([
                                'schematic_name' => $schematicName,
                                'cycle_time' => $cycleTime
                            ])->save();
                            break;
                        case 'planetSchematicsTypeMap':
                            $schematicID = $data[0];
                            $typeID = $data[1];
                            $quantity = $data[2];
                            $isInput = $data[3];

                            if ($isInput) {
                                FactoryInput::firstOrNew([
                                    'schematic_id' => $schematicID,
                                    'input_type_id' => $typeID,
                                ])->fill([
                                    'quantity_consumed' => $quantity
                                ])->save();
                            } else {
                                Schematic::where('schematic_id', $schematicID)
                                    ->update([
                                        'type_id' => $typeID
                                    ]);
                            }
                            break;
                        default:
                            $this->warn("Unsupported filename $fileName");
                    }
                }
                fclose($handle);
            }
        }
    }

    public function getProgressBar($iterations): ProgressBar
    {

        $bar = $this->output->createProgressBar($iterations);

        $bar->setFormat(' %current%/%max% [%bar%] %percent:3s%% %elapsed:6s% %memory:6s%');

        return $bar;
    }

    public function isStorageOk(): bool
    {

        $storage = storage_path() . '/sde/' . $this->json->version . '/';
        $this->info('Storage path is: ' . $storage);

        if (File::isWritable(storage_path())) {

            // Check that the path exists
            if (!File::exists($storage))
                File::makeDirectory($storage, 0755, true);

            // Set the storage path
            $this->storage_path = $storage;

            return true;

        }

        return false;
    }

    private function uncompressFile($archive_path, $extracted_target_path): void
    {
        // Get 2 handles ready for both the in and out files
        $input_file = bzopen($archive_path, 'r');
        $output_file = fopen($extracted_target_path, 'w');

        // Write the $output_file in chunks
        while ($chunk = bzread($input_file, 4096))
            fwrite($output_file, $chunk, 4096);

        // Close the files
        bzclose($input_file);
        fclose($output_file);
    }

}