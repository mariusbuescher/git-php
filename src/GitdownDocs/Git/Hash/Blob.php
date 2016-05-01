<?php

namespace GitdownDocs\Git\Hash;

use GitdownDocs\Git\Hash;
use GitdownDocs\Git\Repository;

/**
 * The blob hash class
 *
 * @package GitdownDocs\Git\Hash
 * @author Marius Büscher <marius.buescher@gmx.de>
 */
class Blob extends Hash
{
    const HASH_TYPE = 'blob';

    /**
     * The content
     *
     * @var string
     **/
    private $content;

    private function __construct(Repository $repository, $objectHash = '')
    {
        $this->repository = $repository;

        if ($objectHash !== '') {
            $type = $this->repository->runCommand('cat-file -t ' . $objectHash);
            if ($type !== self::HASH_TYPE) {
                throw new \InvalidArgumentException(sprintf('Expected blob type object hash, %s given', $type));
            }
        }

        $this->objectHash = $objectHash;
    }

    /**
     * Generates a blob object from an object hash
     *
     * @param Repository $repository The repository
     * @param string     $objectHash The object hash
     * @return self
     */
    public static function fromObjectHash(Repository $repository, $objectHash = '')
    {
        return new self($repository, $objectHash);
    }

    /**
     * Returns the content of the hash
     *
     * @return string
     **/
    public function getContent()
    {
        if ($this->content === null && $this->getObjectHash() !== '') {
            $this->content = $this->repository->runCommand('cat-file -p ' . $this->objectHash);
        }

        return $this->content;
    }

    /**
     * Sets the content
     *
     * @param string $content The new content
     * @return self
     **/
    public function setContent($content)
    {
        if ($this->getContent() !== $content) {
            $this->content = $content;
            $this->objectHash = '';
        }

        return $this;
    }

    /**
     * Saves the blob
     *
     * @return self
     **/
    public function save()
    {
        $this->objectHash = $this->repository->runCommand('hash-object --stdin -w', $this->getContent());

        return $this;
    }
}
?>
