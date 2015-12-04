<?php
/**
 * Neap (http://neap.io/)
 *
 * @link      http://github.com/e7d/neap for the canonical source repository
 * @copyright Copyright (c) 2015 Michaël "e7d" Ferrand (http://github.com/e7d)
 * @license   https://github.com/e7d/neap/blob/master/LICENSE.md The MIT License
 */

namespace Application\Database\Channel;

use Zend\Stdlib\Hydrator\ObjectProperty;

class Channel extends ObjectProperty
{
    public $id;
    public $user_id;
    public $chat_id;
    public $name;
    public $stream_key;
    public $title;
    public $topic_id;
    public $topic;
    public $language;
    public $delay;
    public $logo;
    public $banner;
    public $video_banner;
    public $background;
    public $profile_banner;
    public $views;
    public $followers;
    public $created_at;
    public $updated_at;

    public function exchangeArray($data)
    {
        $this->id = (!empty($data['channel_id'])) ? $data['channel_id'] : null;
        $this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
        $this->chat_id = (!empty($data['chat_id'])) ? $data['chat_id'] : null;
        $this->name = (!empty($data['name'])) ? $data['name'] : null;
        $this->stream_key = (!empty($data['stream_key'])) ? $data['stream_key'] : null;
        $this->title = (!empty($data['title'])) ? $data['title'] : null;
        $this->topic_id = (!empty($data['topic_id'])) ? $data['topic_id'] : null;
        $this->topic = (!empty($data['topic'])) ? $data['topic'] : null;
        $this->language = (!empty($data['language'])) ? $data['language'] : null;
        $this->delay = (!empty($data['delay'])) ? $data['delay'] : null;
        $this->logo = (!empty($data['logo'])) ? $data['logo'] : null;
        $this->banner = (!empty($data['banner'])) ? $data['banner'] : null;
        $this->video_banner = (!empty($data['video_banner'])) ? $data['video_banner'] : null;
        $this->background = (!empty($data['background'])) ? $data['background'] : null;
        $this->profile_banner = (!empty($data['profile_banner'])) ? $data['profile_banner'] : null;
        $this->views = (!empty($data['views'])) ? $data['views'] : null;
        $this->followers = (!empty($data['followers'])) ? $data['followers'] : null;
        $this->created_at = (!empty($data['created_at'])) ? $data['created_at'] : null;
        $this->updated_at = (!empty($data['updated_at'])) ? $data['updated_at'] : null;
    }
}
