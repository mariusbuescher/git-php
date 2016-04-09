<?php

namespace GitdownDocs\Git;

/**
* The repository factory
*
* @package GitdownDocs\Git
* @author Marius Büscher <marius.buescher@gmx.de>
*/
class RepositoryFactory
{
    /**
     * Creates a new repository
     *
     * @return Repository
     **/
    public function createRepository()
    {
        $repository = new Repository();

        return $repository;
    }
}
?>
