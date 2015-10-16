<?php

namespace Application\Authorization;

class IdentityService
{
    protected $identity;

    public function setIdentity($identity)
    {
        $this->identity = $identity;
        return $this;
    }

    public function getIdentity($identity)
    {
        return $this->identity;
    }
}
