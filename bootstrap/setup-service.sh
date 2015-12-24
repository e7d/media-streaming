#!/bin/bash

try
(
    throwErrors

    echo "Copy the gateway service binary"
    cp ${DIR}/resources/service/bin/neap /etc/init.d

    echo "Register the neap user account"
    useradd neap

    echo "Fix the service permissions"
    chown -c neap.neap /etc/init.d/neap
    chmod -c +x /etc/init.d/neap

    echo "Register service script"
    systemctl enable neap
    systemctl unmask neap
    systemctl daemon-reload

    echo "Start the Neap service"
    service neap start
)
catch || {
    case $ex_code in
        *)
            echox "${text_red}Error:${text_reset} An unexpected exception was thrown"
            throw $ex_code
        ;;
    esac
}