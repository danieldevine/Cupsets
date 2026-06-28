<?php

namespace Coderjerk\Cupsets\Enums;

enum MatchStatus: string
{
    case SCHEDULED = 'SCHEDULED';
    case LIVE = 'LIVE';
    case IN_PLAY = 'IN_PLAY';
    case PAUSED = 'PAUSED';
    case FINISHED = 'FINISHED';
    case POSTPONED = 'POSTPONED';
    case SUSPENDED = 'SUSPENDED';
    case CANCELLED = 'CANCELLED';
}
