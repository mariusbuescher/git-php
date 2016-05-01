<?php

namespace GitdownDocs\Git;

use Symfony\Component\Process\Process;
use GitdownDocs\Git\Hash\Blob;

/**
* The repository class
*
* @package GitdownDocs\Git
* @author Marius Büscher <marius.buescher@gmx.de>
*/
class Repository
{
    /**
     * The git directory
     *
     * @var string
     **/
    protected $gitDirectory = '.git';

    /**
     * The working tree
     *
     * @var string
     **/
    protected $workingTree = '.';

    /**
     * The process
     *
     * @var string
     **/
    protected $process;

    public function __construct(Process $process)
    {
        $this->process = $process;
        $this->command = 'git';
    }

    /**
     * Returns the git directory
     *
     * @return string
     **/
    public function getGitDirectory()
    {
        return $this->gitDirectory;
    }

    /**
     * Sets the git directory
     *
     * @param string $gitDirectory The git directory
     *
     * @return self
     */
    public function setGitDirectory($gitDirectory)
    {
        $this->gitDirectory = $gitDirectory;

        return $this;
    }

    /**
     * Gets the value of workingTree.
     *
     * @return string
     */
    public function getWorkingTree()
    {
        return $this->workingTree;
    }

    /**
     * Sets the value of workingTree.
     *
     * @param string $workingTree the working tree
     *
     * @return self
     */
    public function setWorkingTree($workingTree)
    {
        $this->workingTree = $workingTree;

        return $this;
    }

    /**
     * Runs a git command
     *
     * @param string $command The command to run
     * @param string $input   The input
     * @return void
     **/
    public function runCommand($command, $input = '')
    {
        $exitCode = $this->process->setCommandline($this->buildCommandline($command, $input))
                                  ->mustRun();

        return $this->process->getOutput();
    }

    /**
     * Returns an object hash
     *
     * @param string $ObjectHash The blobs object hash
     * @return Blob
     **/
    public function getBlob($objectHash)
    {
        return Blob::fromObjectHash($this, $objectHash);
    }

    /**
     * Builds the commandline
     *
     * @param string $command The git command
     * @param string $input   The input
     * @return string
     **/
    private function buildCommandline($command, $input = '')
    {
        $buildCommand = '';

        if ($input !== '') {
            $buildCommand = 'echo "' . $input . '"|';
        }

        $buildCommand .= 'git ' . '--git-dir=' . $this->gitDirectory . ' --work-tree=' . $this->workingTree . ' ' . $command;

        return $buildCommand;
    }
}

?>
