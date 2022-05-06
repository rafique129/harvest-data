<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class GenerateComponent extends Command
{

    protected $signature = 'generate:component {entity} {role} {--a=}  {--p} {--c}';

    protected $description = 'Command description';


    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $entityName = $this->argument('entity');
        $roleName = $this->argument('role');
        $entityParamter = Str::camel($entityName);
        $routeNamePrefix =  strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $entityName));
        $action = $this->option('a');
        $actionKababCase =  strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $action));
        $parameter = $this->option('p');
        $isComponent = $this->option('c');

        $entityNameKababCase =  strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $entityName));

        $role = Str::ucfirst($roleName);
        $roleKebabCase = Str::kebab($roleName);
        $roleNamePlurized = Str::plural($roleName);
        $roleNamePlurizedKababCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $roleNamePlurized));
        $roleNameKababCase =  strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $roleName));


        $entityNamePlurized = Str::plural($entityName);
        $entityNamePlurizedKababCase = strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $entityNamePlurized));
        $routesFileName  = $roleNameKababCase . '/' . $entityNameKababCase . '.php';
        $routesFilePath = "routes/" . $routesFileName ;


        if (!$action) {
            $this->error('Provide action name!');
            return;
        }

        $command = 'livewire:make ' .  $role . '/' .  $entityName . '/' . ($isComponent ? 'Components/' : '') . $action;
        Artisan::call($command);

        if (!$isComponent) {
            $content =
                "Route::get('" .  $actionKababCase . ($parameter ? "/{" . $entityParamter . "}" : "") . "', \\App\\Http\\Livewire\\" . $role . "\\" . $entityName . '\\' . $action . "::class)->name('" . Str::lower($role) . "." .  $routeNamePrefix . "." . $actionKababCase . "');\n" .
                "        //next-slot-" . $roleKebabCase;

            $data = file_get_contents($routesFilePath);
            $data = str_replace("//next-slot-" . $roleKebabCase, $content, $data);
            file_put_contents($routesFilePath, $data);
        }


        $file_path = 'app/Policies/' . $entityName . 'Policy' . ".php";
        if ($policyExists = file_exists($file_path)) {
            $data = file_get_contents($file_path);
            $content =
                "\n    public function " .  Str::snake( Str::ucfirst($action) . "For" . Str::ucfirst($role)) . "(User $" . "user," . $entityName . " $" .  $entityParamter   . ")\n" .
                "    {\n" .
                "        // logic\n" .
                "    }\n" .
                "    //next-slot";

            $data = str_replace("//next-slot", $content, $data);
            file_put_contents($file_path, $data);
        }

        $file_path = 'app/Http/Livewire/' . $role . '/' . $entityName  . '/' .  ($isComponent ? 'Components/' : '') . $action . '.php';
        $data = file_get_contents($file_path);

        $content =
            ($policyExists ? "use Illuminate\Foundation\Auth\Access\AuthorizesRequests;\nuse App\Models\\" . $entityName . ";\nuse Livewire\Component;" : "use Livewire\Component;");
        $data = str_replace('use Livewire\Component;', $content, $data);

        $content =
        ($policyExists ? "use AuthorizesRequests;\n\n" : "") .
            "    public function mount(" . ($parameter ? $entityName . " $"  . $entityParamter : '') . ")\n" .
            "    {\n" .
            ($policyExists ? "        //$" . "this->authorize('" . Str::snake( Str::ucfirst($action) . "For" . Str::ucfirst($role))  . "', new " . $entityName  . "());\n" : "\n") .
            "    }\n\n" .
            "    public function " .  Str::camel($action) . "()\n" .
            "    {\n" .
            ($policyExists ? "        //$" . "this->authorize('" . Str::snake( Str::ucfirst($action) . "For" . Str::ucfirst($role))  . "', new " . $entityName  . "());\n" : "\n") .
            "    }\n\n" .
            "    public function render()";

        $data = str_replace("public function render()", $content, $data);


        file_put_contents($file_path, $data);

        $this->info('The command was successful!');
    }
}
