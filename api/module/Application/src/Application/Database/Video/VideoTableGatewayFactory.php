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

namespace Application\Database\Video;

use Application\Database\Video\Video;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;
use Zend\ServiceManager\ServiceManager;

/**
 * VideoTableGatewayFactory
 */
class VideoTableGatewayFactory
{
    /**
     * @param ServiceManager $serviceManager
     *
     * @return TableGateway
     */
    public function __invoke(ServiceManager $serviceManager)
    {
        $adapter = $serviceManager->get('Application\Database\DatabaseService')->getAdapter();
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Video());
        return new TableGateway('video', $adapter, null, $resultSet);
    }
}
