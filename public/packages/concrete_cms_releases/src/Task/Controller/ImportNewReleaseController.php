<?php

namespace PortlandLabs\Concrete\Releases\Task\Controller;

use Concrete\Core\Command\Task\Controller\AbstractController;
use Concrete\Core\Command\Task\Input\Definition\BooleanField;
use Concrete\Core\Command\Task\Input\Definition\Definition;
use Concrete\Core\Command\Task\Input\Definition\Field;
use Concrete\Core\Command\Task\Input\InputInterface;
use Concrete\Core\Command\Task\Runner\ProcessTaskRunner;
use Concrete\Core\Command\Task\Runner\TaskRunnerInterface;
use Concrete\Core\Command\Task\TaskInterface;
use Concrete\Core\Page\Command\ClearPageIndexCommand;
use PortlandLabs\Concrete\Releases\Task\Command\ImportNewReleaseCommand;

defined('C5_EXECUTE') or die("Access Denied.");

class ImportNewReleaseController extends AbstractController
{

    public function getName(): string
    {
        return t('Import New Release');
    }

    public function getDescription(): string
    {
        return t('Given a GitHub Release Tag, imports the data into our releases data store.');
    }

    public function getInputDefinition(): ?Definition
    {
        $definition = new Definition();
        $definition->addField(new Field('tag', t('GitHub Release Tag'), t('Specifies the release to import.')));
        $definition->addField(
            new BooleanField(
                'skip-release-notes',
                t('Skip Release Notes'),
                t('If set to true, release notes will not automatically be created.')
            )
        );
        return $definition;
    }

    public function getTaskRunner(TaskInterface $task, InputInterface $input): TaskRunnerInterface
    {
        if (!$input->hasField('tag')) {
            throw new \RuntimeException(t('Tag is required.'));
        }
        $skipReleaseNotes = false;
        if ($input->hasField('skip-release-notes')) {
            $skipReleaseNotes = true;
        }

        return new ProcessTaskRunner(
            $task,
            new ImportNewReleaseCommand(
                $input->getField('tag')->getValue(),
                $skipReleaseNotes
            ),
            $input,
            t('Importing new release.')
        );
    }


}
