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
     * The arguments
     *
     * @var array
     */
    protected $args = array();

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

    /**
     * Returns the arguments
     *
     * @return Array
     **/
    public function getArguments()
    {
        return $this->args;
    }

    /**
     * Adds an argument to the arguments
     *
     * @param string $argument The argument
     * @return self
     */
    public function addArgument($argument)
    {
        array_push($this->args, $argument);

        return $this;
    }

    /**
     * Adds several arguments
     *
     * @param Array $arguments The arguments
     * @return self
     **/
    public function addArguments(Array $arguments)
    {
        $this->args = array_merge($this->args, $arguments);

        return $this;
    }
}
?>
