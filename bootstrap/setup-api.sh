#!/bin/bash

try
(
    throwErrors

    echo "Install dependencies"
    cd ${DIR}/api/
    composer install --no-interaction --prefer-source

    echo "Copy Neap configuration files"
    cp ${DIR}/api/config/development.config.php.dist ${DIR}/api/config/development.config.php
    cp ${DIR}/api/config/autoload/local.php.dist ${DIR}/api/config/autoload/local.php
    cp ${DIR}/api/config/autoload/oauth2.local.php.dist ${DIR}/api/config/autoload/oauth2.local.php

    echo "Remove cache files"
    rm -rf ${DIR}/api/data/cache/*.cache.php

    echo "Enable development mode"
    sleep 1s
    php ${DIR}/api/public/index.php development enable
)
catch || {
    case $ex_code in
        *)
            echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
            throw $ex_code
        ;;
    esac
}