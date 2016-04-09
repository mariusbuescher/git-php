<?php
namespace GitdownDocs\Git;

use Symfony\Component\Process\Process;

/**
 * The git shell trait
 *
 * @package GitdownDocs\Git
 * @author Marius Büscher <marius.buescher@gmx.de>
 */
trait GitShell
{
    use Shell;

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
        $this->process->setCommandLine('git');

        return $this;
    }
}
?>
