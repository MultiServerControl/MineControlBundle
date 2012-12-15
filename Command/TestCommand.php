<?php

namespace MultiServerControl\MineControlBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Process\Process;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use SharedMemory\SharedMemory;

class TestCommand extends ContainerAwareCommand
{
    protected $input;
    protected $output;

    protected function configure()
    {
        $this
            ->setName('minecraft')
            ->setDescription('Starts a minecraft server.')
            ->addArgument(
            'action',
            InputArgument::REQUIRED,
            'a action to exec on the minecraft server like start, stop, restart etc.'
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        switch ($this->input->getArgument('action')) {
            case 'start':
                $this->start();
                break;
            case 'stop':
                $this->stop();
                break;
            case 'restart':
                $this->restart();
                break;
            case 'status':
                $this->isRunning();
                break;
        }
    }

    protected function start()
    {
        $output = $this->output;
        $process = new Process('');
        $sm = SharedMemory::getInstance();

        $process->setCommandLine('java -jar server/minecraft_server.jar &');
        $process->setTimeout(null);
        $sm[1000] = $process;
        $process->run(function ($type, $buffer) use ($output) {
            if ('err' === $type) {
                $output->write('ERR > ' . $buffer);
            } else {
                $output->write('OUT > ' . $buffer);
            }
        });
    }

    protected function stop()
    {
        $process = $this->getProcess();

        $this->output->writeln('------------------------');
        $this->output->writeln('not implemented yet!');
        $this->output->writeln('------------------------');
    }

    protected function restart()
    {
        $this->stop();
        $this->start();
    }

    protected function isRunning()
    {
        $process = $this->getProcess();

        if ($process->isRunning()) {
            $this->output->writeln('Server instance already running');
        } else $this->output->writeln('Server instance offline');

        return $process->isRunning();
    }

    protected function getProcess()
    {
        $sm = SharedMemory::getInstance();
        return $sm[1000];
    }
}