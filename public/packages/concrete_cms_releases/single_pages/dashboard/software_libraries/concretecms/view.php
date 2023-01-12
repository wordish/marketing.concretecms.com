<?php

defined('C5_EXECUTE') or die('Access denied');

?>

<div class="ccm-dashboard-header-buttons">
    <a href="<?php echo Url::to("/dashboard/software_libraries/concretecms/add"); ?>" class="btn btn-primary">
        <?php echo t("Add Concrete CMS Release"); ?>
    </a>
</div>

<div id="ccm-search-results-table">
    <table class="ccm-search-results-table" data-search-results="concrete-releases">
        <thead>
        <tr>
            <?php
            foreach ($result->getColumns() as $column): ?>
                <th class="<?php
                echo $column->getColumnStyleClass() ?>">
                    <?php
                    if ($column->isColumnSortable()): ?>
                        <a href="<?php
                        echo $column->getColumnSortURL() ?>">
                            <?php
                            echo $column->getColumnTitle() ?>
                        </a>
                    <?php
                    else: ?>
                        <span>
                                <?php
                                echo $column->getColumnTitle() ?>
                            </span>
                    <?php
                    endif; ?>
                </th>
            <?php
            endforeach; ?>
        </tr>
        </thead>

        <tbody>
        <?php
        foreach ($result->getItems() as $item) {
            ?>
            <?php
            /** @var Item $item */
            ?>
            <tr data-details-url="<?= $item->getDetailsUrl() ?>">
                <?php
                foreach ($item->getColumns() as $column) {
                    $class = $column->getColumn(
                    ) instanceof \PortlandLabs\Concrete\Releases\Search\ConcreteRelease\ColumnSet\Column\VersionNumberColumn ?
                        'ccm-search-results-name' : '';
                    ?>
                    <td class="<?= $class ?>">
                        <?php
                        echo $column->getColumnValue(); ?>
                    </td>
                    <?php
                } ?>

            </tr>
            <?php
        } ?>
        </tbody>
    </table>
</div>

<?php
echo $result->getPagination()->renderView('dashboard'); ?>
