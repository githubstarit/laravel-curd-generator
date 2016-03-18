<?php

namespace Aiddroid\Generators;

use Illuminate\Console\Command;
use Illuminate\Console\AppNamespaceDetectorTrait;

class MakeCurdViewCommand extends Command
{
    use AppNamespaceDetectorTrait;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view:curd {--views : Only scaffold the authentication views}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scaffold basic login and registration views and routes';

    /**
     * The views that need to be exported.
     *
     * @var array
     */
    protected $views = [];

    public function __construct()
    {
        parent::__construct();
        $name = $this->parseName($this->getNameInput());
        $this->views = [
            'index-view.stub' => $name.'/index.blade.php',
            'create-view.stub' => $name.'/create.blade.php',
            'edit-view.stub' => $name.'/edit.blade.php',
            'show-view.stub' => $name.'/show.blade.php',
        ];
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
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
        $name = $this->parseName($this->getNameInput());
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
        $name = $this->parseName($this->getNameInput());
        $form = $this->createForm();
        file_put_contents(base_path('resources/views/'.$name.'/_form.blade.php'),$form);

        foreach ($this->views as $key => $value) {
            $path = base_path('resources/views/'.$value);

            $this->line('<info>Created View:</info> '.$path);

            copy(__DIR__.'/../stubs/'.$key, $path);
        }
    }

    protected function createForm(){
        $table = $this->option('table');
        $tableColumns = Schema::getColumnListing($table);
        var_dump($tableColumns);die;
        $form = '{!! Form::model($model) !!}'
        foreach($tableColumns as $column){
            $form .= '<div class="form-group"> \n';
            $form .= '{!! Form::label(\''.$column.'\') !!} \n';
            $form .= '{!! Form::text(\''.$column.'\',null,['class'=>'form-control']) !!} \n';
            $form .= '</div> \n';
        }
        $form .= '<div class="form-group"> \n';
        $form .= '{!! Form::submit(\'save\',[\'class\'=>\'btn btn-primary form-control\']) !!} \n';
        $form .= '</div> \n';
        $form .= '{!! Form::close() !!} \n';
        return $form;
    }

}

