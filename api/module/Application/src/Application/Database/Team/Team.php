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

namespace Application\Database\Team;

use Zend\Hydrator\ObjectProperty;

/**
 * Team
 */
class Team extends ObjectProperty
{
    /** @var string */
    public $team_id;

    /** @var string */
    public $name;

    /** @var string */
    public $display_name;

    /** @var string */
    public $logo;

    /** @var string */
    public $banner;

    /** @var string */
    public $background;

    /** @var string */
    public $created_at;

    /** @var string */
    public $updated_at;

    /**
     * @param array $data
     *
     * @return void
     */
    public function exchangeArray(array $data)
    {
        $this->team_id = $data['team_id'];
        $this->name = $data['name'];
        $this->display_name = $data['display_name'];
        $this->logo = $data['logo'];
        $this->banner = $data['banner'];
        $this->background = $data['background'];
        $this->created_at = $data['created_at'];
        $this->updated_at = $data['updated_at'];
    }
}
