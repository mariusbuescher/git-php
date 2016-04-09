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
        $repository = new Repository();

        $this->assertEquals('.git', $repository->getGitDirectory());
    }

    /**
     * Tests the git directory
     *
     * @return void
     **/
    public function testGitDirectory()
    {
        $expectedGitDirectory = 'foo/bar.git';
        $repository = new Repository();

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
        $repository = new Repository();

        $this->assertEquals('.', $repository->getWorkingTree());
    }

    /**
     * Tests the working tree
     *
     * @return void
     **/
    public function testWorkingTree()
    {
        $expectedWorkingTree = 'foo/bar';
        $repository = new Repository();

        $repository->setWorkingTree($expectedWorkingTree);

        $this->assertEquals($expectedWorkingTree, $repository->getWorkingTree());
    }
}
?>
