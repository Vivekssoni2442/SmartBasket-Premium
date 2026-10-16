<?php

return [
    'window_days' => min(365, max(1, (int) env('ORDER_RETURN_WINDOW_DAYS', 30))),
];
