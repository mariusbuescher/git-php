<?php

namespace GitdownDocs\Git;

use Symfony\Component\Process\Process;

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
}

?>
