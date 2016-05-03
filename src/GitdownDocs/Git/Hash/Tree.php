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

    private $children = array();

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

    /**
     * Adds a hashObject
     *
     * @param Hash $hashObject The hash object
     * @param string $path The path where to add the hash object
     * @return self
     */
    public function addHashObject(Hash $hashObject, $path)
    {
        $pathParts = explode(DIRECTORY_SEPARATOR, $path);

        $directHashObject = $hashObject;
        if (count($pathParts) > 1) {
            $directHashObject = new self($this->repository);
            $path = array_shift($pathParts);
            $newPath = implode(
                DIRECTORY_SEPARATOR,
                $pathParts
            );
            $directHashObject->addHashObject($hashObject, $newPath);
        }

        $this->children[$path] = $directHashObject;

        return $this;
    }

    /**
     * Returns the paths
     *
     * @return array
     */
    public function getPaths()
    {
        return array_keys($this->children);
    }

    /**
     * Returns the hash object at a given path
     *
     * @param string $path The path
     * @return Hash
     */
    public function getPath($path)
    {
        $pathParts = explode(DIRECTORY_SEPARATOR, $path);

        if (count($pathParts) === 1) {
            $result = $this->children[$path];
        } else {
            $result = $this->children[array_shift($pathParts)]
                           ->getPath(implode(DIRECTORY_SEPARATOR, $pathParts));
        }

        return $result;
    }
    }
}
?>
