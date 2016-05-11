<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Video\V1\Rest\Video;

use ZF\ApiProblem\ApiProblem;
use Application\Rest\AbstractResourceListener;

class VideoResource extends AbstractResourceListener
{
    public function __construct($identityService, $videoService)
    {
        $this->identityService = $identityService;
        $this->service = $videoService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $videoId
     * @return ApiProblem|mixed
     */
    public function fetch($videoId)
    {
        return $this->service->fetch($videoId);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params = [])
    {
        return $this->service->fetchAll($params);
    }
}
