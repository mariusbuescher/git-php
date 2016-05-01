<?php

namespace GitdownDocs\Git\Tests\Hash;

use GitdownDocs\Git\Hash\Tree;

class TreeTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the construction from a valid object hash
     *
     * @return void
     */
    public function testConstructionFromValidObjectHash()
    {
        $fakeObjectHash = 'e69de29bb2d1d6434b8b29ae775ad8c2e48c5391';

        $repository = $this->getMockBuilder('GitdownDocs\\Git\\Repository')
                           ->disableOriginalConstructor()
                           ->getMock();

        $repository->method('runCommand')
                   ->willReturn('tree');

        $tree = Tree::fromObjectHash($repository, $fakeObjectHash);

        $this->assertInstanceOf('GitdownDocs\\Git\\Hash\\Tree', $tree);
    }

    /**
     * Tests the validation for the hash in the constructo
     *
     * @dataProvider invalidObjectHashProvider
     * @return void
     */
    public function testConstructionFromInvalidObjectHash($objectHashType)
    {
        $this->setExpectedException(
            'InvalidArgumentException',
            sprintf('Expected tree type object hash, %s given', $objectHashType)
        );
        $fakeObjectHash = 'e69de29bb2d1d6434b8b29ae775ad8c2e48c5391';

        $repository = $this->getMockBuilder('GitdownDocs\\Git\\Repository')
                           ->disableOriginalConstructor()
                           ->getMock();

        $repository->expects($this->once())
                   ->method('runCommand')
                   ->with('cat-file -t ' . $fakeObjectHash)
                   ->willReturn($objectHashType);

        $tree = Tree::fromObjectHash($repository, $fakeObjectHash);
    }

    /**
     * Data provider for invalid object hash types
     *
     * @return array The object hash types
     */
    public function invalidObjectHashProvider()
    {
        return array(
            array('commit'),
            array('blob')
        );
    }

    /**
     * Tests the constructor without a hash
     *
     * @return void
     **/
    public function testConstructorWithoutHash()
    {
        $repository = $this->getMockBuilder('GitdownDocs\\Git\\Repository')
                           ->disableOriginalConstructor()
                           ->getMock();

        $repository->method('runCommand')
                   ->willReturn('tree');

        $tree = Tree::fromObjectHash($repository);

        $this->assertInstanceOf('GitdownDocs\\Git\\Hash\\Tree', $tree);
    }
}

?>
