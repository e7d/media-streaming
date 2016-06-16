<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Channel\V1\Rest\StreamKey;

use ZF\ApiProblem\ApiProblem;
use Application\Rest\AbstractResourceListener;

class StreamKeyResource extends AbstractResourceListener
{
    public function __construct($identityService, $channelService)
    {
        $this->identityService = $identityService;
        $this->service = $channelService;
    }

    /**
     * Delete a resource
     *
     * @param  mixed $channelId
     * @return ApiProblem|mixed
     */
    public function delete($channelId)
    {
        $channel = $this->service->fetch($channelId);
        if (!$channel) {
            return new ApiProblem(404, 'The channel does not exists.');
        }

        $identity = $this->identityService->getIdentity();
        if (!$this->service->isOwner($channelId, $identity->user_id)) {
            return new ApiProblem(403, 'The channel is not your property.');
        }

        $channel = $this->service->update($channelId, array('stream_key' => ''));

        return true;
    }
}
