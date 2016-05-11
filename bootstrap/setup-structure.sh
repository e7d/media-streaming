#!/bin/bash

. /vagrant/resources/colors.sh
. /vagrant/resources/trycatch.sh

try
(
	throwErrors

	echo "Create neap folder"
	mkdir -p /var/www/neap

	echo "Link API folder"
	rm -fr /var/www/neap/api
	ln -fs /vagrant/api/ /var/www/neap/

	echo "Create database folder"
	mkdir -p /var/www/neap/db

	echo "Download latest Adminer"
	wget -q https://www.adminer.org/latest-en.php -O /var/www/neap/db/index.php

	echo "Create RTMP folders"
	mkdir -p /data/rtmp/dash
	mkdir -p /data/rtmp/hls
	mkdir -p /data/rtmp/rec

	echo "Link RTMP folder"
	rm -fr /var/www/neap/rtmp
	ln -fs /data/rtmp/ /var/www/neap/

	echo "Fix RTMP folders permissions"
	chmod -cR 700 /data/rtmp
	chown -cR www-data.root /data/rtmp

	echo "Link static folder"
	rm -fr /var/www/neap/static
	ln -fs /vagrant/static/ /var/www/neap/

	echo "Create static folders"
	mkdir -p /var/www/neap/static/channel/background
	mkdir -p /var/www/neap/static/channel/banner
	mkdir -p /var/www/neap/static/channel/logo
	mkdir -p /var/www/neap/static/channel/profile_banner
	mkdir -p /var/www/neap/static/channel/video_banner
	mkdir -p /var/www/neap/static/emoji
	mkdir -p /var/www/neap/static/stream/preview
	mkdir -p /var/www/neap/static/team/background
	mkdir -p /var/www/neap/static/team/banner
	mkdir -p /var/www/neap/static/team/logo
	mkdir -p /var/www/neap/static/user/logo
	mkdir -p /var/www/neap/static/video/preview

	echo "Link web folder"
	rm -fr /var/www/neap/web
	ln -fs /vagrant/web/ /var/www/neap/

	echo "Fix Neap folders permissions"
	chown -cR www-data:www-data /var/www/neap
)
catch || {
	case $ex_code in
		*)
			echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
			throw $ex_code
		;;
	esac
}
