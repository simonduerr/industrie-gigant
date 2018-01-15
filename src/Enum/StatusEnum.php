<?php

namespace App\Enum;

final class StatusEnum
{
    public const GENERAL_SUCCESS = 1000;
    public const GENERAL_INVALID_REQUEST = 1001;
    public const GENERAL_OTHER = 1999;

    public const TILE_NOT_FOUND = 2000;
    public const TILE_NOT_EMPTY = 2001;

    public const BUILT_OBJ_NOT_FOUND = 3000;

    public const BUILDING_NOT_FOUND = 4000;
}