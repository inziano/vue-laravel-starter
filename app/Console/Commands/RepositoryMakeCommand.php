<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Component\Console\Input\InputArgument;
use Illuminate\Component\Console\Exception\InvalidArgumentException;


class RepositoryMakeCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new model repository';

    /**
     * $type
     *
     * @var string
     */
    protected $type = 'Repository';

    /**
     * $repositoryClass
     *
     * @var undefined
     */
    private $repositoryClass;

    /**
     * $model
     *
     * @var undefined
     */
    private $model;

    /**
     * setRepositoryClass
     *
     * @return void
     */
    private function setRepositoryClass()
    {
        $name = ucwords(strtolower($this->argument('model')));

        $this->model = $name;

        $modelClass = $name;

        $this->repositoryClass = $modelClass . 'Repository';

        return $this;
    }

    /**
     * replaceClass
     *
     * @param mixed $stub
     * @param mixed $name
     * @return void
     */
    protected function replaceClass($stub, $name)
    {
        if (!$this->argument('model'))
        {
            throw new InvalidArgumentException("Missing argument, requires model name");
        }

        $stub = parent::replaceClass($stub, $name);

        return str_replace('DummyModel', $this->model, $stub);
    }

    /**
     * getStub
     *
     * @return void
     */
    protected function getStub()
    {
        return __DIR__.'stubs/repository.stub';
    }

    /**
     * getDefaultNamespace
     *
     * @param mixed $rootNamespace
     * @return void
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\Repositories';
    }

    /**
     * getArguments
     *
     * @return void
     */
    protected function getArguments()
    {
        return [
            [ 'model', InputArgument::REQUIRED, 'The name of the model class'],
        ];
    }
    /**
     * fire
     *
     * @return void
     */
    public function handle(){

        $this->setRepositoryClass();

        $path = $this->getPath($this->repositoryClass);

        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return false;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->buildClass($this->repositoryClass));

        $this->info($this->type.' created successfully.');

        $this->line("<info>Created Repository :</info> $this->repositoryClass");
    }

}
