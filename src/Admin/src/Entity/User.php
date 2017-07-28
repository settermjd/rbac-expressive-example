<?php

namespace Admin\Entity;

/**
 * Class User
 * @package Admin\Entity
 */
class User
{
    /**
     * @return string
     */
    public function getRole()
    {
        return 'content.editor';
    }

    /**
     * @return int
     */
    public function getId()
    {
        return 25;
    }
}
