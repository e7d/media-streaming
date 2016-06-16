<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Chat\V1\Rest\Chat;

use ZF\ApiProblem\ApiProblem;
use Application\Rest\AbstractResourceListener;

class ChatResource extends AbstractResourceListener
{
    public function __construct($identityService, $chatService)
    {
        $this->identityService = $identityService;
        $this->service = $chatService;
    }

    /**
     * Fetch a resource
     *
     * @param  mixed $chatId
     * @return ApiProblem|mixed
     */
    public function fetch($chatId)
    {
        return $this->service->fetch($chatId);
    }
}
