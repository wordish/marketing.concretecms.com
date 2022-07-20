#!/bin/bash
set -euo pipefail

tempdir=/tmp/codedeployupload

[[ -d $tempdir ]] && rm -r $tempdir
mkdir -p $tempdir

if [ "$APPLICATION_NAME" == "marketing.stage.concretecms.com" ]
then
  echo "export projectdir=\"/home/forge/marketing.stage.concretecms.com\"" > "/tmp/.cdvariables";
  echo "export deploydir=\"/home/forge/marketing.stage.concretecms.com/releases/$DEPLOYMENT_ID\"" >> "/tmp/.cdvariables";
elif [ "$APPLICATION_NAME" == "www.concretecms.com" ]
then
  echo "export projectdir=\"/home/forge/marketing.concretecms.com\"" > "/tmp/.cdvariables";
  echo "export deploydir=\"/home/forge/marketing.concretecms.com/releases/$DEPLOYMENT_ID\"" >> "/tmp/.cdvariables";
fi
