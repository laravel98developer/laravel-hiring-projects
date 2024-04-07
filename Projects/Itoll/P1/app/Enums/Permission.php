<?php

namespace App\Enums;

enum Permission: string {
    case DELIVERY_REQUEST_INSERT = 'deliver-request:insert';
    case DELIVERY_REQUEST_CANCEL = 'deliver-request:cancel';
    case DELIVERY_REQUEST_LIST = 'deliver-request:list';
    case DELIVERY_REQUEST_ACCEPT = 'deliver-request:accept';
    case DELIVERY_REQUEST_RECEIVE = 'deliver-request:receive';
    case DELIVERY_REQUEST_FULL_DELIVERY_OP = 'deliver-request:fulldeliveryop';
    case USER_UPDATE = 'user:update';
}