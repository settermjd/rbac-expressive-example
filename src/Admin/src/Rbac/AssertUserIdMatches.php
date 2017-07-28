<?php

namespace Admin\Rbac;

use Zend\Permissions\Rbac\AssertionInterface;
use Zend\Permissions\Rbac\Rbac;

/**
 * Class AssertUserIdMatches
 * @package Admin\Rbac
 */
class AssertUserIdMatches implements AssertionInterface
{
    /**
     * @var
     */
    protected $userId;
    /**
     * @var
     */
    protected $articleId;

    /**
     * AssertUserIdMatches constructor.
     * @param $userId
     * @param $articleId
     */
    public function __construct($userId, $articleId)
    {
        $this->userId = $userId;
        $this->articleId = $articleId;
    }

    /**
     * @param Rbac $rbac
     * @return bool
     */
    public function assert(Rbac $rbac)
    {
        return ($this->userId === $this->articleId);
    }
}
