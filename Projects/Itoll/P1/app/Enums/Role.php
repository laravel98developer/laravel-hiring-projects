<?php

namespace App\Enums;

enum Role: string {
    case ADMIN = 'admin';
    case DELIVERER = 'deliverer';
    case COLLECTION = 'collection';
}