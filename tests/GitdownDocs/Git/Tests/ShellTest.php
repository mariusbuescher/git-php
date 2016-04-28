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

    /**
     * Tests the default arguments
     *
     * @return void
     **/
    public function testDefaultArguments()
    {
        $testProcess = $this->getMockBuilder('Symfony\Component\Process\Process')
                            ->disableOriginalConstructor()
                            ->getMock();

        $shell = $this->getObjectForTrait('GitdownDocs\\Git\\Shell');
        $shell->setProcess($testProcess);

        $this->assertInternalType('array', $shell->getArguments());
        $this->assertEmpty($shell->getArguments());
    }

    /**
     * Tests the add argument method
     *
     * @return void
     **/
    public function testAddArgument()
    {
        $testProcess = $this->getMockBuilder('Symfony\Component\Process\Process')
                            ->disableOriginalConstructor()
                            ->getMock();

        $expectedArgument = '--git-dir=test.git/';

        $shell = $this->getObjectForTrait('GitdownDocs\\Git\\Shell');
        $shell->setProcess($testProcess);

        $shell->addArgument($expectedArgument);

        $this->assertContains($expectedArgument, $shell->getArguments());
    }

    /**
     * Tests the add argument method
     *
     * @return void
     **/
    public function testAddArguments()
    {
        $testProcess = $this->getMockBuilder('Symfony\Component\Process\Process')
                            ->disableOriginalConstructor()
                            ->getMock();

        $expectedArgument = '--git-dir=test.git/';
        $expectedAdditionalArgumentA = '--working-dir=./';
        $expectedAdditionalArgumentB = 'status';

        $shell = $this->getObjectForTrait('GitdownDocs\\Git\\Shell');
        $shell->setProcess($testProcess);

        $shell->addArgument($expectedArgument);
        $shell->addArguments(array($expectedAdditionalArgumentA, $expectedAdditionalArgumentB));

        $this->assertContains($expectedArgument, $shell->getArguments());
        $this->assertContains($expectedAdditionalArgumentA, $shell->getArguments());
        $this->assertContains($expectedAdditionalArgumentB, $shell->getArguments());
    }

    /**
     * Tests the run method
     *
     * @return void
     */
    public function testRun()
    {
        $testProcess = $this->getMockBuilder('Symfony\Component\Process\Process')
                            ->disableOriginalConstructor()
                            ->getMock();

        $process = $this->getObjectForTrait('GitdownDocs\\Git\\Shell');
        $process->setProcess($testProcess);
    }
}
?>
