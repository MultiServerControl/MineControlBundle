<?php
use MultiServerControl\CoreBundle\Manager\BaseManager;
use Symfony\Component\Process\Process;

/**
 * Created by JetBrains PhpStorm.
 * User: fabian
 * Date: 12/7/12
 * Time: 10:04 PM
 * To change this template use File | Settings | File Templates.
 */
class MineControlManager extends BaseManager
{
    protected $process;

    public function __construct()
    {
        $this->process = new Process();
    }

    public function start()
    {
        if (!$this->isRunning()) {
            // TODO build start command dynamically
            $this->process->setCommandLine('java -jar -Xms512M -Xmx1G minecraft_server.jar');
            $this->process->run();
            if (!$this->process->isSuccessful()) {
                throw new \RuntimeException($this->process->getErrorOutput());
            }

            print $this->process->getOutput();
            print $this->process->getErrorOutput();
        } else throw new \RuntimeException("This server instance is already running.");
    }

    public function stop()
    {
        if ($this->isRunning()) {
            $this->process->stop(0);
        } else throw new \RuntimeException("No instance of this server is running.");
    }

    public function restart()
    {
        $this->stop();
        $this->start();
    }

    public function isRunning()
    {
        return $this->process->isRunning();
    }
}
