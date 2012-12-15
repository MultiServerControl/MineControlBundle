<?php
namespace MultiServerControl\MineControlBundle\Manager;

use MultiServerControl\CoreBundle\Manager\BaseManager;
use Symfony\Component\Process\Process;

/**
 * File: MineControlManager.php
 * Date: 12/8/12
 *
 * (c) Fabian Frick <fabi.kcirf@gmail.com>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
class MineControlManager extends BaseManager
{
    protected $process;

    public function start()
    {
        $process = new Process('php ../app/console minecraft:start &');
        $process->run();
        if (!$process->isSuccessful()) {
            throw new \RuntimeException($process->getErrorOutput());
        }
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
