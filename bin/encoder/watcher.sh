#!/bin/bash
#run this script to launch file watcher
MONITORDIR="/vagrant/shared/e-media/web/e-media-data/video"
inotifywait -m -r -e create --format '%w%f' "${MONITORDIR}" | while read NEWFILE
do
    #todo file extension
    if [[ "$NEWFILE" =~ .*mp4$ ]]; then
        bin/encoder/encoder.sh $NEWFILE &
    fi
done