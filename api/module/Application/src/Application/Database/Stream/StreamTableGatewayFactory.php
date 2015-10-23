<?php
namespace Application\Database\Stream;

use Application\Database\Stream\Stream;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class StreamTableGatewayFactory
{
    public function __invoke($services)
    {
        $adapter = $services->get('Application\Database\DatabaseService')->getAdapter();
        $resultSet = new ResultSet();
        $resultSet->setArrayObjectPrototype(new Stream());
        return new TableGateway('stream', $adapter, null, $resultSet);
    }
}