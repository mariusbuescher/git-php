<?php

namespace GitdownDocs\Git;

/**
 * The git hash class
 *
 * @package GitdownDocs\Git
 * @author Marius Büscher <marius.buescher@gmx.de>
 */
class Hash
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

    public function __construct(Repository $repository, $objectHash)
    {
        $this->repository = $repository;
        $this->objectHash = $objectHash;
    }

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
