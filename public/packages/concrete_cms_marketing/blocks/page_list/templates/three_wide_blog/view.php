<?php
/**
 * @var string|null $pageListTitle
 * @var \Concrete\Block\PageList\Controller $controller
 * @var \Concrete\Core\Page\Page[] $pages
 */

?>
<div class="twb-container">
    <div class="twb-header">
        <span><?= $pageListTitle ?></span>
        <a class="btn-twb" href="<?= $_ENV['URL_SITE_MARKETING_COMMERCIAL'] ?? 'https://www.concretecms.com' ?>/about/blog">
            Show All Articles
            <i class="fa fa-angle-right"></i>
        </a>
    </div>
    <div class="twb-posts">
        <?php
        foreach ($pages as $page) {
            ?>
            <div class="twb-post">
                <div class="twb-post-title">
                    <span class="twb-force-ellipsis">
                        <?= h((string) $page->getCollectionName()) ?>
                    </span>
                </div>
                <span class="twb-post-time">
                    <?= h($page->getCollectionDatePublicObject()->format('M j, Y')) ?>
                </span>
                <div class="twb-post-description">
                    <span class="twb-force-ellipsis">
                        <?= h((string) $page->getCollectionDescription()) ?>
                    </span>
                </div>
                <div class="twb-post-action">
                    <a class="btn-twb" href="<?= URL::to($page->getCollectionPath()) ?>">
                        Read Full Post
                    </a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<script>
    (function() {

        $(function() {
            $('.twb-force-ellipsis').each(function() {
                const me = $(this).removeClass('twb-force-ellipsis')
                const currentText = me.text().trim().split(' ')
                let parentWidth = me.parent().width()
                const resize = () => {
                    const text = [...currentText]
                    if (parentWidth < me.parent().width()) {
                        // Handle scaling back up
                        me.text(text.join(' '))
                    }
                    parentWidth = me.parent().width()
                    while (text.length && me.height() > me.parent().height()) {
                        text.pop()
                        me.text(text.length ? text.join(' ') + '...' : '')
                    }
                }

                $(window).on('resize', resize)
                resize()
            })
        })
    }())
</script>