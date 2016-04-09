<?php

namespace GitdownDocs\Git\Tests;

use GitdownDocs\Git\Repository;
use GitdownDocs\Git\RepositoryFactory;

/**
* The repository test
*
* @package GitdownDocs\Git\Tests
* @author Marius Büscher <marius.buescher@gmx.de>
*/
class RepositoryFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the get repository method
     *
     * @return void
     **/
    public function testCreate()
    {
        $factory = new RepositoryFactory();

        $repository = $factory->createRepository();

        $this->assertInstanceOf('GitdownDocs\Git\Repository', $repository);
    }
}
?>
