<?php

namespace GitdownDocs\Git\Tests;

use GitdownDocs\Git\Repository;
use Symfony\Component\Process\Process;

/**
* The repository test
*
* @package GitdownDocs\Git\Tests
* @author Marius Büscher <marius.buescher@gmx.de>
*/
class RepositoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the default git directory
     *
     * @return void
     **/
    public function testDefaultGitDirectory()
    {
        $process = $this->getMockBuilder('Symfony\Component\Process\Process')
                        ->disableOriginalConstructor()
                        ->getMock();

        $repository = new Repository($process);

        $this->assertEquals('.git', $repository->getGitDirectory());
    }

    /**
     * Tests the git directory
     *
     * @return void
     **/
    public function testGitDirectory()
    {
        $process = $this->getMockBuilder('Symfony\Component\Process\Process')
                        ->disableOriginalConstructor()
                        ->getMock();
        $expectedGitDirectory = 'foo/bar.git';

        $repository = new Repository($process);

        $repository->setGitDirectory($expectedGitDirectory);

        $this->assertEquals($expectedGitDirectory, $repository->getGitDirectory());
    }

    /**
     * Tests the default working tree
     *
     * @return void
     **/
    public function testDefaultWorkingTree()
    {
        $process = $this->getMockBuilder('Symfony\Component\Process\Process')
                        ->disableOriginalConstructor()
                        ->getMock();

        $repository = new Repository($process);

        $this->assertEquals('.', $repository->getWorkingTree());
    }

    /**
     * Tests the working tree
     *
     * @return void
     **/
    public function testWorkingTree()
    {
        $process = $this->getMockBuilder('Symfony\Component\Process\Process')
                        ->disableOriginalConstructor()
                        ->getMock();
        $expectedWorkingTree = 'foo/bar';

        $repository = new Repository($process);

        $repository->setWorkingTree($expectedWorkingTree);

        $this->assertEquals($expectedWorkingTree, $repository->getWorkingTree());
    }

    /**
     * Tests the run command method
     *
     * @return void
     **/
    public function testRunCommand()
    {
        $process = $this->getMockBuilder('Symfony\Component\Process\Process')
                        ->disableOriginalConstructor()
                        ->getMock();

        $command = 'log';

        $process->expects($this->once())
                ->method('setCommandline')
                ->with('git --git-dir=.git --work-tree=. ' . $command)
                ->willReturn($process);

        $process->expects($this->once())
                ->method('mustRun');

        $process->method('getOutput')
                ->willReturn('test');

        $repository = new Repository($process);

        $this->assertEquals('test', $repository->runCommand($command));
    }

    /**
     * Tests the get blob method
     *
     * @return void
     */
    public function testGetBlob()
    {
        $fakeObjectHash = 'e69de29bb2d1d6434b8b29ae775ad8c2e48c5391';

        $process = $this->getMockBuilder('Symfony\Component\Process\Process')
                        ->disableOriginalConstructor()
                        ->getMock();

        $process->expects($this->once())
                ->method('setCommandline')
                ->with('git --git-dir=.git --work-tree=. cat-file -t ' . $fakeObjectHash)
                ->willReturn($process);

        $process->expects($this->once())
                ->method('mustRun');

        $process->method('getOutput')
                ->willReturn('blob');

        $repository = new Repository($process);

        $this->assertInstanceOf(
            'GitdownDocs\\Git\\Hash\\Blob',
            $repository->getBlob($fakeObjectHash)
        );
    }
}
?>
