<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Hydrator\Channel;

class ChannelHydratorFactory
{
    public function __invoke($services)
    {
        return new ChannelHydrator(
            $services->get('Application\Database\Chat\ChatModel'),
            $services->get('Application\Database\Stream\StreamModel'),
            $services->get('Application\Database\User\UserModel')
        );
    }
}
