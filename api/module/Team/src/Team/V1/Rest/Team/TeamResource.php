<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Team\V1\Rest\Team;

use ZF\ApiProblem\ApiProblem;
use ZF\Rest\AbstractResourceListener;

class TeamResource extends AbstractResourceListener
{
    private $identityService;
    private $teamService;

    function __construct($identityService, $teamService)
    {
        $this->identityService = $identityService;
        $this->teamService = $teamService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $id
     * @return ApiProblem|mixed
     */
    public function fetch($id)
    {
        return $this->teamService->fetch($id);
    }

    /**
     * Fetch all or a subset of resources
     *
     * @param  array $params
     * @return ApiProblem|mixed
     */
    public function fetchAll($params)
    {
        return $this->teamService->fetchAll($params);
    }
}
