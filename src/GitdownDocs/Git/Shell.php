<?php
namespace GitdownDocs\Git;

use Symfony\Component\Process\Process;

/**
 * The shell trait
 *
 * @package GitdownDocs\Git
 * @author Marius Büscher <marius.buescher@gmx.de>
 */
trait Shell
{
    /**
     * The process for the interaction with the repository
     *
     * @var Process
     **/
    protected $process = null;

    /**
     * The base directory
     *
     * @var string
     **/
    protected $baseDirectory = '';

    /**
     * The command
     *
     * @var string
     **/
    protected $command;

    /**
     * Gets the value of process.
     *
     * @return Process
     */
    public function getProcess()
    {
        return $this->process;
    }

    /**
     * Sets the value of process.
     *
     * @param Process $process the process
     *
     * @return self
     */
    public function setProcess(Process $process)
    {
        $this->process = $process;

        return $this;
    }

    /**
     * Gets the base directory
     *
     * @return string
     **/
    public function getBaseDirectory()
    {
        $process = $this->getProcess();

        if ($process === null) {
            throw new \Exception("No process specified", 1);
        }

        return $process->getWorkingDirectory();
    }

    /**
     * Sets the base directory
     *
     * @param string $baseDirectory The base directory
     * @return self
     **/
    public function setBaseDirectory($baseDirectory)
    {
        $process = $this->getProcess();

        if ($process === null) {
            throw new \Exception("No process specified", 1);
        }

        $process->setWorkingDirectory($baseDirectory);

        return $this;
    }
}
?>
