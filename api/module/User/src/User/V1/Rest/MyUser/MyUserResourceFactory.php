<?php
/**
 * Neap (http://neap.io/)
 *
 * @package   Neap
 * @author    Michaël "e7d" Ferrand <michael@e7d.io>
 * @copyright 2017 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 * @link      https://github.com/e7d/neap
 *
 * PHP version 7.1
 */

namespace User\V1\Rest\MyUser;

class MyUserResourceFactory
{
    public function __invoke($serviceManager)
    {
        return new MyUserResource(
            $serviceManager->get('Application\Authorization\IdentityService'),
            $serviceManager->get('User\V1\Service\UserService')
        );
    }
}
