<?php

declare(strict_types=1);

return [
    /**
     * Set this to an integer that corresponds to a parent page where new version history documents will be created.
     * The keys of the array are the major versions, because we now have split our docs to 9.x and 8.x.
     */
    'version_history_parent_page_id' => [
        '8' => null,
        '9' => null,
    ],
];