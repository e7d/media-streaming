<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2016 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.txt The MIT License
 */

namespace Application\Hydrator\Outage;

use Application\Hydrator\Hydrator;
use Application\Database\Ingest\IngestModel;
use ZF\Hal\Entity;

class OutageHydrator extends Hydrator
{
    protected $ingestModel;

    public function __construct(IngestModel $ingestModel)
    {
        parent::__construct();
        $this->ingestModel = $ingestModel;
    }

    public function buildEntity($outage)
    {
        $this->object = $outage;

        $ingest = $this->ingestModel->fetch($outage->ingest_id);

        $this->entity = new Entity($this->extract($outage));

        $this->addSelfLink();
        $this->addLink('linkIngest', $ingest);

        return $this->entity;
    }
}
