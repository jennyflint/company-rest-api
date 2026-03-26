<?php

namespace App\Enums;

enum CompanyStatusEnum: string
{
    case CREATED = 'created';
    case UPDATED = 'updated';
    case DUPLICATE = 'duplicate';
}
