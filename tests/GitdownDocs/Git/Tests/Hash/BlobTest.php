<?php

namespace GitdownDocs\Git\Tests\Hash;

use GitdownDocs\Git\Hash\Blob;

/**
 * Tests the blobs
 *
 * @package GitdownDocs\Git\Tests\Hash
 * @author Marius Büscher <marius.buescher@gmx.de>
 */
class BlobTest extends \PHPUnit_Framework_TestCase
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
                   ->willReturn('blob');

        $blob = Blob::fromObjectHash($repository, $fakeObjectHash);

        $this->assertInstanceOf('GitdownDocs\\Git\\Hash\\Blob', $blob);
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
            sprintf('Expected blob type object hash, %s given', $objectHashType)
        );
        $fakeObjectHash = 'e69de29bb2d1d6434b8b29ae775ad8c2e48c5391';

        $repository = $this->getMockBuilder('GitdownDocs\\Git\\Repository')
                           ->disableOriginalConstructor()
                           ->getMock();

        $repository->expects($this->once())
                   ->method('runCommand')
                   ->with('cat-file -t ' . $fakeObjectHash)
                   ->willReturn($objectHashType);

        $blob = Blob::fromObjectHash($repository, $fakeObjectHash);
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
            array('tree')
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
                   ->willReturn('blob');

        $blob = Blob::fromObjectHash($repository);

        $this->assertInstanceOf('GitdownDocs\\Git\\Hash\\Blob', $blob);
    }

    /**
     * Tests the get content method
     *
     * @return void
     **/
    public function testGetContent()
    {
        $fakeObjectHash = '980a0d5f19a64b4b30a87d4206aade58726b60e3';
        $fakeContent = 'Hello World!';

        $repository = $this->getMockBuilder('GitdownDocs\\Git\\Repository')
                           ->disableOriginalConstructor()
                           ->getMock();

        $repository->expects($this->exactly(2))
                   ->method('runCommand')
                   ->withConsecutive(
                        array('cat-file -t ' . $fakeObjectHash),
                        array('cat-file -p ' . $fakeObjectHash)
                    )
                   ->will($this->returnValueMap(array(
                        array('cat-file -t ' . $fakeObjectHash, '', 'blob'),
                        array('cat-file -p ' . $fakeObjectHash, '', $fakeContent)
                    )));

        $blob = Blob::fromObjectHash($repository, $fakeObjectHash);

        $this->assertEquals($fakeContent, $blob->getContent());
    }

    /**
     * Tests the get content methods cache
     *
     * @return void
     **/
    public function testGetContentMultipleTimes()
    {
        $fakeObjectHash = '980a0d5f19a64b4b30a87d4206aade58726b60e3';
        $fakeContent = 'Hello World!';

        $repository = $this->getMockBuilder('GitdownDocs\\Git\\Repository')
                           ->disableOriginalConstructor()
                           ->getMock();

        $repository->expects($this->exactly(2))
                   ->method('runCommand')
                   ->withConsecutive(
                        array('cat-file -t ' . $fakeObjectHash),
                        array('cat-file -p ' . $fakeObjectHash)
                    )
                   ->will($this->returnValueMap(array(
                        array('cat-file -t ' . $fakeObjectHash, '', 'blob'),
                        array('cat-file -p ' . $fakeObjectHash, '', $fakeContent)
                    )));

        $blob = Blob::fromObjectHash($repository, $fakeObjectHash);

        $this->assertEquals($fakeContent, $blob->getContent());
        $this->assertEquals($fakeContent, $blob->getContent());
    }

    /**
     * Tests the set content method
     *
     * @return void
     **/
    public function testSetContent()
    {
        $fakeObjectHash = '980a0d5f19a64b4b30a87d4206aade58726b60e3';
        $fakeContent = 'Hello World!';

        $repository = $this->getMockBuilder('GitdownDocs\\Git\\Repository')
                           ->disableOriginalConstructor()
                           ->getMock();

        $repository->method('runCommand')
                   ->willReturn('blob');

        $blob = Blob::fromObjectHash($repository, $fakeObjectHash);

        $blob->setContent($fakeContent);

        $this->assertEquals($fakeContent, $blob->getContent());
        $this->assertEquals('', $blob->getObjectHash());
    }

    /**
     * Tests the set content method with the same content
     *
     * @return void
     **/
    public function testSetCommandWithNonDifferentContent()
    {
        $fakeObjectHash = '980a0d5f19a64b4b30a87d4206aade58726b60e3';
        $fakeContent = 'Hello World!';

        $repository = $this->getMockBuilder('GitdownDocs\\Git\\Repository')
                           ->disableOriginalConstructor()
                           ->getMock();

        $repository->method('runCommand')
                   ->withConsecutive(
                        array('cat-file -t ' . $fakeObjectHash),
                        array('cat-file -p ' . $fakeObjectHash)
                    )
                   ->will($this->returnValueMap(array(
                        array('cat-file -t ' . $fakeObjectHash, '', 'blob'),
                        array('cat-file -p ' . $fakeObjectHash, '', $fakeContent)
                    )));

        $blob = Blob::fromObjectHash($repository, $fakeObjectHash);

        $blob->setContent($fakeContent);

        $this->assertEquals($fakeContent, $blob->getContent());
        $this->assertEquals($fakeObjectHash, $blob->getObjectHash());
    }

    /**
     * Tests the save method
     *
     * @return void
     **/
    public function testSaveBlob()
    {
        $fakeObjectHash = '980a0d5f19a64b4b30a87d4206aade58726b60e3';
        $fakeContent = 'Hello World!';

        $repository = $this->getMockBuilder('GitdownDocs\\Git\\Repository')
                           ->disableOriginalConstructor()
                           ->getMock();

        $repository->expects($this->once())
                   ->method('runCommand')
                   ->with('hash-object --stdin -w', $fakeContent)
                   ->willReturn($fakeObjectHash);

        $blob = Blob::fromObjectHash($repository);

        $blob->setContent($fakeContent);
        $blob->save();

        $this->assertEquals($fakeContent, $blob->getContent());
        $this->assertEquals($fakeObjectHash, $blob->getObjectHash());
    }
}
?>
