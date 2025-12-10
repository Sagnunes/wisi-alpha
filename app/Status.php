<?php

namespace App;

enum Status: int
{
    // Authentication
    case PENDING = 1;
    case ACTIVE = 2;
}
