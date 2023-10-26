<?php
namespace PortlandLabs\Concrete\Releases\Task\Command;

use Concrete\Core\Foundation\Command\Command;

defined('C5_EXECUTE') or die("Access Denied.");

class ImportNewReleaseCommand extends Command
{

    public function __construct(
        public readonly string $tag
    ) {
    }


}
