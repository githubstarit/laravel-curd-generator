<?php

namespace Aiddroid\Generators\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeCurdCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:controller:curd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new curd controller';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Curd';

    /**
     * Parse the name and format according to the root namespace.
     *
     * @param  string $name
     * @return string
     */
    protected function parseName($name)
    {
        return ucwords(camel_case($name)) . 'Controller';
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__ . '/../stubs/curd-controller.stub';
    }

    /**
     * Get the destination class path.
     *
     * @param  string $name
     * @return string
     */
    protected function getPath($name)
    {
        return base_path() . '/app/Http/Controllers/' . str_replace('\\', '/', $name) . '.php';
    }
}
