<?php

namespace GitdownDocs\Git;

/**
 * The git hash class
 *
 * @package GitdownDocs\Git
 * @author Marius Büscher <marius.buescher@gmx.de>
 */
abstract class Hash
{
    /**
     * The repository
     *
     * @var Repository
     */
    protected $repository;

    /**
     * The object hash
     *
     * @var string
     */
    protected $objectHash;

    /**
     * Returns the object hash
     *
     * @return string
     */
    public function getObjectHash()
    {
        return $this->objectHash;
    }
}
?>
