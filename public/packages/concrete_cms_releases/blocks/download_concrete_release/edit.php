<?php

defined('C5_EXECUTE') or die('Access denied');


?>

<div class="form-group" data-view="edit-download-concrete-release-block" v-cloak>

    <div class="mb-3">
        <label class="form-label"><?= t('Release') ?></label>
        <div class="form-check">
            <input class="form-check-input" type="radio" value="S" id="downloadReleaseType1"
                   name="downloadReleaseType"
                   v-model="downloadReleaseType">
            <label class="form-check-label" for="downloadReleaseType1">
                <?= t('Specific Version') ?>
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" value="B" id="downloadReleaseType2"
                   name="downloadReleaseType"
                   v-model="downloadReleaseType">
            <label class="form-check-label" for="downloadReleaseType2">
                <?= t('Latest stable release of a specific branch') ?>
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" value="L" id="downloadReleaseType3"
                   name="downloadReleaseType"
                   v-model="downloadReleaseType">
            <label class="form-check-label" for="downloadReleaseType3">
                <?= t('Latest stable release (any branch)') ?>
            </label>
        </div>
    </div>
    <div class="mb-3" v-if="downloadReleaseType == 'B'">
        <label class="form-label" for="latestVersionSpecificBranchIdentifier">
            <?= t('Major Version') ?>
        </label>
        <input required type="number" class="form-control" v-model="latestVersionSpecificBranchIdentifier"
               name="latestVersionSpecificBranchIdentifier" id="latestVersionSpecificBranchIdentifier">
        <div class="help-block"><?= t(
                "This must be a single integer that maps to the major version you want to show releases of. e.g. '8' or '9'"
            ) ?></div>
    </div>
    <div class="mb-3" v-if="downloadReleaseType == 'S'">
        <label class="form-label" for="releaseID">
            <?= t('Release') ?>
        </label>
        <select required class="form-select" v-model="releaseID" name="releaseID" id="releaseID">
            <option value=""><?= t('** Choose a Release') ?></option>
            <option v-for="release in releases" :value="release.id">{{release.versionNumber}}</option>
        </select>
    </div>

</div>

<script type="text/javascript">

    Concrete.Vue.activateContext('cms', function (Vue, config) {
        new Vue({
            el: 'div[data-view=edit-download-concrete-release-block]',
            components: config.components,
            data: {
                downloadReleaseType: <?=json_encode($downloadReleaseType)?>,
                latestVersionSpecificBranchIdentifier: <?=json_encode($latestVersionSpecificBranchIdentifier)?>,
                releases: <?=json_encode($releases)?>,
                releaseID: <?=json_encode($releaseID)?>
            },
            mounted() {
            }
        })
    })


</script>
