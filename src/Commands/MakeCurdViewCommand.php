<?php

namespace Aiddroid\Generators\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\AppNamespaceDetectorTrait;
use Illuminate\Support\Facades\Schema;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class MakeCurdViewCommand extends Command
{
    use AppNamespaceDetectorTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:view:curd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate curd views from database table';

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [];

    protected function getArguments()
    {
        return [
            ['name',InputArgument::REQUIRED,'views name'],
        ];
    }

    /**
    * Get the name
    *
    * @return string
    */
    protected function getNameInput()
    {
        return $this->argument('name');
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['model', null, InputOption::VALUE_OPTIONAL, 'The database model you want to curd'],
        ];
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $name = $this->getNameInput();
        $this->views = [
            'index-view.stub' => $name.'/index.blade.php',
            'create-view.stub' => $name.'/create.blade.php',
            'edit-view.stub' => $name.'/edit.blade.php',
            'show-view.stub' => $name.'/show.blade.php',
        ];
        $this->createDirectories();

        $this->exportViews();

        $this->comment('Curd views generated successfully!');
    }

    /**
     * Create the directories for the files.
     *
     * @return void
     */
    protected function createDirectories()
    {
        $name = $this->getNameInput();
        if (! is_dir(base_path('resources/views/layouts'))) {
            mkdir(base_path('resources/views/layouts'), 0755, true);
        }

        if (! is_dir(base_path('resources/views/'.$name))) {
            mkdir(base_path('resources/views/'.$name), 0755, true);
        }
    }

    /**
     * Export the authentication views.
     *
     * @return void
     */
    protected function exportViews()
    {
        $name = $this->getNameInput();
        $form = $this->createForm();
        file_put_contents(base_path('resources/views/'.$name.'/_form.blade.php'),$form);

        foreach ($this->views as $key => $value) {
            $path = base_path('resources/views/'.$value);

            $this->line('<info>Created View:</info> '.$path);

            $content = file_get_contents(__DIR__.'/../stubs/'.$key);
            $content = str_replace('{{view}}',$name,$content);
            file_put_contents($path, $content);
        }
    }

    protected function createForm(){
        $modelClass = $this->option('model');
        $table = (new $modelClass())->table;
        $tableColumns = Schema::getColumnListing($table);
        $form = '{!! Form::model($model) !!}'.PHP_EOL;
        foreach($tableColumns as $column){
            if($column === 'id'){
                continue;
            }
            $form .= '    <div class="form-group">'.PHP_EOL;
            $form .= '        {!! Form::label(\''.$column.'\') !!}'.PHP_EOL;
            $form .= '        {!! Form::text(\''.$column.'\',null,[\'class\'=>\'form-control\']) !!}'.PHP_EOL;
            $form .= '    </div>'.PHP_EOL;
        }
        $form .= '    <div class="form-group">'.PHP_EOL;
        $form .= '        {!! Form::submit(\'save\',[\'class\'=>\'btn btn-primary form-control\']) !!}'.PHP_EOL;
        $form .= '    </div>'.PHP_EOL;
        $form .= '{!! Form::close() !!}'.PHP_EOL;
        return $form;
    }

}

