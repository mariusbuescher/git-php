<?php

namespace GitdownDocs\Git\Tests;

use GitdownDocs\Git\Repository;
use GitdownDocs\Git\Hash;

/**
* The hash test
*
* @package GitdownDocs\Git\Tests
* @author Marius Büscher <marius.buescher@gmx.de>
*/
class HashTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the get hash method
     *
     * @return void
     */
    public function testGetHash()
    {
        $repository = $this->getMock('GitdownDocs\Git\Repository');

        // Hash of am empty hash object
        $objectHash = 'e69de29bb2d1d6434b8b29ae775ad8c2e48c5391';

        $hashObject = new Hash($repository, $objectHash);
        $this->assertEquals($objectHash, $hashObject->getObjectHash());
    }
}

?>
