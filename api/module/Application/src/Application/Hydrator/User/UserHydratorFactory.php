<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Hydrator\User;

class UserHydratorFactory
{
    public function __invoke($services)
    {
        return new UserHydrator(
            $services->get('Application\Database\User\UserModel'),
            $services->get('Application\Database\Channel\ChannelModel'),
            $services->get('Application\Database\Team\TeamModel')
        );
    }
}
