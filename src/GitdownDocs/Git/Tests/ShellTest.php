<?php

namespace GitdownDocs\Git\Tests;

use Symfony\Component\Process\Process;

/**
* The shell test
*
* @package GitdownDocs\Git\Tests
* @author Marius Büscher <marius.buescher@gmx.de>
*/
class ShellTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the default process
     *
     * @return void
     **/
    public function testDefaultProcess()
    {
        $process = $this->getObjectForTrait('GitdownDocs\\Git\\Shell');

        $this->assertNull($process->getProcess());
    }

    /**
     * Tests the default process
     *
     * @return void
     **/
    public function testProcess()
    {
        $testProcess = new Process('sh');

        $process = $this->getObjectForTrait('GitdownDocs\\Git\\Shell');
        $process->setProcess($testProcess);

        $this->assertEquals($testProcess, $process->getProcess());
    }

    /**
     * Tests what happens when no process is set and there is a cwd to be set
     *
     * @return void
     *
     * @expectedException        Exception
     * @expectedExceptionMessage No process specified
     **/
    public function testEmptyProcessOnGetBaseDirectory()
    {
        $process = $this->getObjectForTrait('GitdownDocs\\Git\\Shell');

        $process->getBaseDirectory();
    }

    /**
     * Tests what happens when no process is set and there is a cwd to be set
     *
     * @return void
     *
     * @expectedException        Exception
     * @expectedExceptionMessage No process specified
     **/
    public function testEmptyProcessOnSetBaseDirectory()
    {
        $process = $this->getObjectForTrait('GitdownDocs\\Git\\Shell');

        $process->setBaseDirectory('');
    }

    /**
     * Tests the default base directory
     *
     * @return void
     **/
    public function testDefaultBaseDirectory()
    {
        $testProcess = new Process('sh');

        $process = $this->getObjectForTrait('GitdownDocs\\Git\\Shell');
        $process->setProcess($testProcess);

        $this->assertEquals(
            $testProcess->getWorkingDirectory(),
            $process->getBaseDirectory()
        );
    }

    /**
     * Tests the base directory
     *
     * @return void
     **/
    public function testBaseDirectory()
    {
        $testProcess = new Process('sh');

        $expectedBaseDirectory = 'foo/bar';
        $process = $this->getObjectForTrait('GitdownDocs\\Git\\Shell');
        $process->setProcess($testProcess);

        $process->setBaseDirectory($expectedBaseDirectory);

        $this->assertEquals($expectedBaseDirectory, $process->getBaseDirectory());
    }
}
?>
