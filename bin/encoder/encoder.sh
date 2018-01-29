#!/bin/bash
#run this script to encode video

function log {
    echo -e "$(date) - $1" >> var/logs/encoder.log
}

NEWFILE=$1
log "new video detected: ${NEWFILE}"
DIR=$(dirname ${NEWFILE})
rm -f ${DIR}/*.m3u8 ${DIR}/*.ts ${DIR}/lock ${DIR}/error
touch ${DIR}/lock
log "encoding ${NEWFILE}..."
ffmpeg -i ${DIR}/*.mp4 ${DIR}/index.m3u8 2> /dev/null
if [ $? -eq 0 ]; then
    log "${NEWFILE} encoded!"
else
    touch ${DIR}/error
fi
rm -f ${DIR}/lock