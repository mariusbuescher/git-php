<?php

namespace GitdownDocs\Git\Hash;

use GitdownDocs\Git\Hash;
use GitdownDocs\Git\Repository;

/**
 * The tree hash class
 *
 * @package GitdownDocs\Git\Hash
 * @author Marius Büscher <marius.buescher@gmx.de>
 */
class Tree extends Hash
{
    const HASH_TYPE = 'tree';

    private function __construct(Repository $repository, $objectHash = '')
    {
        $this->repository = $repository;

        if ($objectHash !== '') {
            $type = $this->repository->runCommand('cat-file -t ' . $objectHash);
            if ($type !== self::HASH_TYPE) {
                throw new \InvalidArgumentException(sprintf('Expected tree type object hash, %s given', $type));
            }
        }

        $this->objectHash = $objectHash;
    }

    /**
     * Generates a tree object from an object hash
     *
     * @param Repository $repository The repository
     * @param string     $objectHash The object hash
     * @return self
     */
    public static function fromObjectHash(Repository $repository, $objectHash = '')
    {
        return new self($repository, $objectHash);
    }
}
?>