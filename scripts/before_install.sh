#!/bin/bash
set -euo pipefail

tempdir=/tmp/marketing/codedeployupload

[[ -d $tempdir ]] && rm -r $tempdir
mkdir -p $tempdir

mkdir /tmp/$DEPLOYMENT_ID

echo "export tempdir=\"$tempdir\"" > "/tmp/$DEPLOYMENT_ID/.cdvariables";

if [ "$APPLICATION_NAME" == "marketing.stage.concretecms.com" ]
then
  echo "export projectdir=\"/home/forge/marketing.stage.concretecms.com\"" >> "/tmp/$DEPLOYMENT_ID/.cdvariables";
  echo "export deploydir=\"/home/forge/marketing.stage.concretecms.com/releases/$DEPLOYMENT_ID\"" >> "/tmp/$DEPLOYMENT_ID/.cdvariables";
elif [ "$APPLICATION_NAME" == "marketing.concretecms.com" ]
then
  echo "export projectdir=\"/home/forge/marketing.concretecms.com\"" >> "/tmp/$DEPLOYMENT_ID/.cdvariables";
  echo "export deploydir=\"/home/forge/marketing.concretecms.com/releases/$DEPLOYMENT_ID\"" >> "/tmp/$DEPLOYMENT_ID/.cdvariables";
fi
