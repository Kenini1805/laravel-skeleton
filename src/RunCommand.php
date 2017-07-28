<?php

namespace Framgia\Laravel\Skeleton\Console;

use ZipArchive;
use RuntimeException;
use GuzzleHttp\Client;
use Symfony\Component\Process\Process;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Exception\IOExceptionInterface;

class RunCommand extends Command
{
    /**
     * Configure the command options.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('run')
            ->setDescription('Create a new Laravel skeleton application.')
            ->addArgument('name', InputArgument::OPTIONAL)
            ->addOption('with-docker', null, InputOption::VALUE_NONE, 'Init with docker-compose file')
            ->addOption('docker-only', null, InputOption::VALUE_NONE, 'Init docker-compose file only');
    }

    /**
     * Execute the command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (! class_exists('ZipArchive')) {
            throw new RuntimeException('The Zip PHP extension is not installed. Please install it and try again.');
        }

        $directory = ($input->getArgument('name')) ? getcwd().'/'.$input->getArgument('name') : getcwd();

        if ($input->getOption('with-docker') || $input->getOption('docker-only')) {
            $output->writeln('<info>Creating docker-compose...</info>');
            $this->makeDocker($directory, $input);
            $output->writeln('<comment>Done!</comment>');
        }

        if (!$input->getOption('docker-only')) {
            $output->writeln('<info>Creating Laravel skeleton...</info>');

            $this->download($zipFile = $this->makeFilename())
                ->removeFiles($directory, $output)
                ->extract($zipFile, $directory, $output)
                ->removeUserModel($directory)
                ->cleanUp($zipFile);

            $composer = $this->findComposer();
            $commands = [
                $composer.' update',
            ];

            $process = new Process(implode(' && ', $commands), $directory, null, null, null);
            if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
                $process->setTty(true);
            }
            $process->run(
                function ($type, $line) use ($output) {
                    $output->write($line);
                }
            );

            $output->writeln('<comment>Done! Do something!</comment>');
        }
    }

    /**
     * Delete files
     *
     * @param                      $directory
     * @param OutputInterface|null $output
     *
     * @return $this
     */
    protected function removeFiles($directory, OutputInterface $output = null)
    {
        $deleteFileUrl = 'https://raw.githubusercontent.com/framgia/laravel-skeleton/master/deleteFiles.txt';
        $deleteFile = file_get_contents($deleteFileUrl);

        if ($output) {
            $output->writeln('<info>Removing files...</info>');
            $output->writeln($deleteFile);
        }

        $files = preg_split('/\r\n|\r|\n/', $deleteFile, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($files as $file) {
            if (!empty($file)) {
                $fileDelete = $directory . '/' . $file;
                @chmod($fileDelete, 0777);
                @unlink($fileDelete);
            }
        }
        
        return $this;
    }

    /**
     * Delete old model User.php
     *
     * @param $directory
     *
     * @return $this
     */
    protected function removeUserModel($directory)
    {
        $modelFile = $directory . '/app/User.php';

        if (is_file($modelFile)) {
            @chmod($modelFile, 0777);
            @unlink($modelFile);
        }

        return $this;
    }

    /**
     * Generate a random temporary filename.
     *
     * @return string
     */
    protected function makeFilename()
    {
        return getcwd().'/laravel_skeleton_'.md5(time().uniqid()).'.zip';
    }

    /**
     * Download the temporary Zip to the given file.
     *
     * @param  string $zipFile
     * @param string  $url
     *
     * @return $this
     * @internal param string $version
     */
    protected function download($zipFile, $url = 'https://raw.githubusercontent.com/framgia/laravel-skeleton/master/skeleton.zip')
    {
        $response = (new Client)->get($url);
        file_put_contents($zipFile, $response->getBody());

        return $this;
    }

    /**
     * Extract the Zip file into the given directory.
     *
     * @param  string              $zipFile
     * @param  string              $directory
     * @param OutputInterface|null $output
     *
     * @return $this
     */
    protected function extract($zipFile, $directory, OutputInterface $output = null)
    {
        if ($output) {
            $output->writeln('<info>Extracting file...</info>');
        }

        $archive = new ZipArchive;
        $archive->open($zipFile);
        $archive->extractTo($directory);
        $archive->close();

        return $this;
    }

    /**
     * Clean-up the Zip file.
     *
     * @param  string  $zipFile
     * @return $this
     */
    protected function cleanUp($zipFile)
    {
        @chmod($zipFile, 0777);
        @unlink($zipFile);

        return $this;
    }

    /**
     * Get the composer command for the environment.
     *
     * @return string
     */
    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" composer.phar';
        }
        return 'composer';
    }

    /**
     * @param                      $directory
     * @param InputInterface       $input
     * @param OutputInterface|null $output
     *
     * @return $this
     */
    protected function makeDocker($directory, InputInterface $input, OutputInterface $output = null)
    {
        $url = 'https://raw.githubusercontent.com/framgia/laravel-skeleton/master/docker.zip';
        $this->download($zipFile = $this->makeDockerFilename(), $url)
            ->extract($zipFile, $directory, $output)
            ->cleanUp($zipFile);

        //create docker-compose.yml file
        $response = (new Client)->get('https://raw.githubusercontent.com/framgia/laravel-skeleton/master/docker-compose.yml.sample');
        $fileContent = $response->getBody();

        $name = ($input->getArgument('name')) ? $input->getArgument('name') : md5(time().uniqid());

        $fileContent = str_replace('{project_name}', $name, $fileContent);

        $dockerComposeFile = $directory . '/docker-compose.yml';
        file_put_contents($dockerComposeFile, $fileContent);

        return $this;
    }

    /**
     * Generate a random temporary filename.
     *
     * @return string
     */
    protected function makeDockerFilename()
    {
        return getcwd().'/docker_'.md5(time().uniqid()).'.zip';
    }
}
