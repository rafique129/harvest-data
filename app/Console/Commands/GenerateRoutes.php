<?php

namespace App\Console\Commands;

use Directory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use function PHPUnit\Framework\directoryExists;

class GenerateRoutes extends Command
{

    protected $signature = 'generate:routes {entity} {role} {--m}';

    protected $description = 'Generate Routes';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $entityName = $this->argument('entity');
        $roleName = $this->argument('role');
        $makeModel = $this->option('m');
        $entityNamePlurized = Str::plural($entityName);
        $entityNamePlurizedKababCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $entityNamePlurized));
        $entityNameKababCase =  strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $entityName));

        $roleNamePlurized = Str::plural($roleName);
        $roleNamePlurizedKababCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $roleNamePlurized));
        $roleNameKababCase =  strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $roleName));

        $routesFileName  = $roleNameKababCase . '/' . $entityNameKababCase . '.php';
        $routesFilePath = "routes/" . $routesFileName ;

        if(!is_dir("routes/" . $roleNameKababCase)){
            mkdir("routes/" . $roleNameKababCase);
        }

        if (file_exists($routesFilePath)) {
            $this->error('Role already exists');
            return null;
        }



        $openedFile = fopen($routesFilePath, 'w');
        $content = "<?php\n\n" .
            "use Illuminate\Support\Facades\Route;\n" .
            "\n" .
            "Route::prefix('" . $roleNameKababCase  ."-portal/" . $entityNamePlurizedKababCase . "')->group(function () {\n" .
            "    Route::middleware(['auth','role:" . $roleName . "'])->group(function () {\n" .
            "         //next-slot-"  . $roleNameKababCase .
            "    \n});\n" .
            "});";
        fwrite($openedFile, $content);
        fclose($openedFile);

        $webFilePath = 'routes/web.php';
        $openedWebFile = fopen($webFilePath, 'a');
        fwrite($openedWebFile, "require_once __DIR__.'/" . $routesFileName . "';\n");
        fclose($openedWebFile);

        if ($makeModel) {
            Artisan::call('make:model ' . $entityName . ' -m');

            if (!file_exists('app/Policies')) {
                mkdir('app/Policies', 0777, true);
            }
            $policyFilePath = 'app/Policies/' . $entityName . 'Policy' . ".php";
            $openedPolicyFile = fopen($policyFilePath, 'a');
            $content =
                "<?php\n" .
                "namespace App\Policies;\n\n" .
                "use App\Models\\" . $entityName . ";\n" .
                "use App\Models\User;\n\n" .
                "class " . $entityName . "Policy\n" .
                "{\n" .
                "    //next-slot" .
                "\n}";
            fwrite($openedPolicyFile, $content);
            fclose($openedPolicyFile);
        }

        // success
        $this->info('Routes for ' .  $entityName .  ' Created!');
    }
}
