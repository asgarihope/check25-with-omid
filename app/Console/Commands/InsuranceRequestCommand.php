<?php

namespace App\Console\Commands;

use App\Http\Requests\InsuranceRequestCommandRequest;
use app\Services\Insurance\InsuranceServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class InsuranceRequestCommand extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'insurance {--file=}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process an insurance request from a JSON file.';
    private InsuranceServiceInterface $insuranceService;

    public function __construct(InsuranceServiceInterface $insuranceService)
    {
        parent::__construct();
        $this->insuranceService = $insuranceService;
    }


    /**
     * Execute the console command.
     */
    public function handle()
    {
        $fileName = $this->option('file');
        if (!$fileName) {
            $this->error(trans("validation.required", ['attribute' => '--file']));
            die();
        }

        $filePath = storage_path(('app/private/' . $fileName));
        if (!file_exists($filePath)) {
            $this->error(trans("validation.exists", ['attribute' => 'file']));
            die();
        }

        $jsonData = json_decode(file_get_contents($filePath), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error(trans("validation.json", ['attribute' => 'file']));
            die();
        }

        $request = new InsuranceRequestCommandRequest();

        $request->replace($jsonData);
        $validator = Validator::make($request->all(), $request->rules());

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            die();
        }

        $this->info($this->insuranceService->handleRequest($request->toDTO()));


    }
}
