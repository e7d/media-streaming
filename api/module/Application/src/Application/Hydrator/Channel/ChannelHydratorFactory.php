<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Channel;

class ChannelHydratorFactory
{
    public function __invoke($serviceManager)
    {
        return new ChannelHydrator(
            $serviceManager->get('Application\Database\Chat\ChatModel'),
            $serviceManager->get('Application\Database\Panel\PanelModel'),
            $serviceManager->get('Application\Database\Stream\StreamModel'),
            $serviceManager->get('Application\Database\User\UserModel')
        );
    }
}
