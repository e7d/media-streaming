<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 e7d (http://e7d.io)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Channel\V1\Rest\Video;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class VideoResource extends AbstractResourceListener
{
    private $identityService;
    private $channelService;

    function __construct($identityService, $channelService)
    {
        $this->identityService = $identityService;
        $this->channelService = $channelService;
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = array())
    {
        $params = array_merge((array) $params, array(
            'channel_id' => $this->getEvent()->getRouteParam('channel_id')
        ));

        $collection = $this->channelService->fetchVideos($params);

        return $collection;
    }
}