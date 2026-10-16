<?php

$maxVideoSizeMb = min(100, max(1, (int) env('PRODUCT_VIDEO_MAX_SIZE_MB', 100)));

return [
    'max_video_size_mb' => $maxVideoSizeMb,
    'max_video_size_kb' => $maxVideoSizeMb * 1024,
];
