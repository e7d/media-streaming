<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Root\V1\Rest\Root;

use ZF\ApiProblem\ApiProblem;
use ZF\Hal\Entity;
use ZF\Hal\Link\Link;
use ZF\Rest\AbstractResourceListener;

class RootResource extends AbstractResourceListener
{
    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params)
    {
        $root = new Entity(array());

        $root->getLinks()->add(Link::factory(array(
            'rel' => 'ingests',
            'route' => array(
                'name' => 'ingest.rest.ingest',
            ),
        )));

        $root->getLinks()->add(Link::factory(array(
            'rel' => 'users',
            'route' => array(
                'name' => 'user.rest.user',
            ),
        )));

        $root->getLinks()->add(Link::factory(array(
            'rel' => 'channels',
            'route' => array(
                'name' => 'channel.rest.channel',
            ),
        )));

        $root->getLinks()->add(Link::factory(array(
            'rel' => 'streams',
            'route' => array(
                'name' => 'stream.rest.stream',
            ),
        )));

        $root->getLinks()->add(Link::factory(array(
            'rel' => 'videos',
            'route' => array(
                'name' => 'video.rest.video',
            ),
        )));

        $root->getLinks()->add(Link::factory(array(
            'rel' => 'search',
            'route' => array(
                'name' => 'search.rest.search',
            ),
        )));

        return $root;
    }
}
