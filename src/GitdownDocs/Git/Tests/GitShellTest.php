<?php
namespace GitdownDocs\Git\Tests;

use Symfony\Component\Process\Process;

/**
* The git shell test
*
* @package GitdownDocs\Git\Tests
* @author Marius Büscher <marius.buescher@gmx.de>
*/
class GitShellTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the set process method
     *
     * @return void
     **/
    public function testSetProcess()
    {
        $testProcess = new Process('sh');

        $shell = $this->getObjectForTrait('GitdownDocs\\Git\\GitShell');
        $shell->setProcess($testProcess);

        $this->assertEquals(
            'git',
            $shell->getProcess()
                ->getCommandLine()
        );
    }
}
?>
