<?php

defined('C5_EXECUTE') or die('Access denied');

?>

<div v-cloak data-form="concrete-releases">
    <div class="alert alert-danger" v-if="generalErrorMessages.length > 0">
        <span v-html="generalErrorMessages.join('<br>')"></span>
    </div>
    <form @submit="save">
        <fieldset>
            <legend><?=t('Basics')?></legend>
            <div class="mb-3">
                <label class="form-label" for="versionNumber">Version Number</label>
                <input :class="{'form-control': true, 'is-invalid': invalidVersionNumberMessages.length}"  placeholder="9.0.0" v-model="concreteRelease.versionNumber"
                       autocomplete="off" type="text" id="versionNumber" required="required"/>
                <div class="invalid-feedback" v-if="invalidVersionNumberMessages.length > 0">
                    <span v-html="invalidVersionNumberMessages.join('<br>')"></span>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label" for="releaseDate">Release Date</label>
                <input class="form-control" v-model="concreteRelease.releaseDate"
                       type="date" id="releaseDate" required="required"/>
            </div>

            <div class="mb-3">
                <label class="form-label" for="releaseDate">Release Download File</label>
                <concrete-file-input v-model="concreteRelease.directDownloadFile" choose-text="<?=t('Choose Release File')?>"></concrete-file-input>
            </div>

            <div class="mb-3">
                <label class="form-label" for="md5sum">File MD5 Hash</label>
                <input type="text" class="form-control" v-model="concreteRelease.md5sum" id="md5sum" />
            </div>

        </fieldset>
        <fieldset>
            <legend><?=t('Release Information')?></legend>
            <div class="mb-3">
                <label class="form-label" for="releaseNotes">Release Notes</label>
                <textarea rows="16" class="form-control" v-model="concreteRelease.releaseNotes" id="releaseNotes"></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label" for="releaseNotesUrl">Release Notes URL</label>
                <input type="url" class="form-control" v-model="concreteRelease.releaseNotesUrl" id="releaseNotesUrl"></input>
            </div>
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="isPrerelease" v-model="concreteRelease.isPrerelease">
                    <label class="form-check-label" for="isPrerelease"><?=t('This is a pre-release (not available for general use).')?></label>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend><?=t('Remote Update')?></legend>
            <div class="mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="isAvailableForRemoteUpdate" v-model="concreteRelease.isAvailableForRemoteUpdate">
                    <label class="form-check-label" for="isAvailableForRemoteUpdate"><?=t('Available for remote update.')?></label>
                </div>
            </div>
            <div class="mb-3" v-if="concreteRelease.isAvailableForRemoteUpdate">
                <label class="form-label" for="releaseDate">Remote Update Download File</label>
                <concrete-file-input v-model="concreteRelease.remoteUpdaterFile" choose-text="<?=t('Choose File')?>"></concrete-file-input>
            </div>
        </fieldset>


        <div class="ccm-dashboard-form-actions-wrapper">
            <div class="ccm-dashboard-form-actions">
                <button type="button" class="btn btn-secondary" @click="goBack">
                    Back
                </button>

                <div class="float-end">
                    <button type="submit" class="btn btn-primary" @click="save">
                        Save
                    </button>
                </div>
            </div>
        </div>

    </form>
</div>

<script>
    $(function () {
        Concrete.Vue.activateContext('backend', function (Vue, config) {
            new Vue({
                components: config.components,
                el: '[data-form=concrete-releases]',
                data: {
                    errorList: [],
                    saveUrl: '<?=$saveUrl?>',
                    saveToken: '<?=$token->generate('submit')?>',
                    backUrl: '<?=$backUrl?>',
                    concreteRelease: <?=json_encode($release)?>,
                    generalErrorMessages: [],
                    invalidVersionNumberMessages: []
                },
                watch: {
                    errorList: function (value) {
                        this.generalErrorMessages = []
                        this.invalidVersionNumberMessages = []
                        this.errorList.forEach((error) => {
                            this.generalErrorMessages = []
                            if (typeof (error.field) !== 'undefined') {
                                if (error.field.element === 'versionNumber') {
                                    this.invalidVersionNumberMessages.push(error.message)
                                } else {
                                    this.generalErrorMessages.push(error.message)
                                }
                            } else {
                                this.generalErrorMessages.push(error.message)
                            }
                        })
                    }
                },
                methods: {
                    goBack() {
                        window.location.href = this.backUrl
                    },
                    save(e) {
                        e.preventDefault()
                        r = this.$el.querySelector('form').reportValidity()
                        if (r) {
                            new ConcreteAjaxRequest({
                                url: this.saveUrl,
                                skipResponseValidation: true,
                                data: {
                                    ccm_token: this.saveToken,
                                    release: JSON.stringify(this.concreteRelease),
                                },
                                success: (r) => {
                                    if (typeof (r.error) !== 'undefined') {
                                        window.scrollTo(0, 0)
                                        this.errorList = r.list
                                    } else {
                                        this.errorList = []
                                        if (r.id) {
                                            window.location.href = CCM_DISPATCHER_FILENAME + '/dashboard/software_libraries/concretecms/details/' + r.id
                                        }
                                    }
                                }
                            })
                        }
                    }
                }
            });
        });

    });
</script>