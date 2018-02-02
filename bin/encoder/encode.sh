#!/bin/bash
####################################
#encode a single video
#Usage:
#bin/encoder/encode.sh 12: will encode in folder 12
####################################
source 'bin/encoder/lib.sh'
if [ -n "$1" ]; then
    if [ -d ${MONITORDIR}/$1 ]; then
        echo -e "launching encoding for ${MONITORDIR}/$1"
        launchEncoding ${MONITORDIR}/$1
    else
        echo -e "path not found: '${MONITORDIR}/$1'"
    fi
else
    echo -e "missing video id parameter to encode"
fi