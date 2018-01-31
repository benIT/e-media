#!/bin/bash
#run this script to launch file watcher
source 'bin/encoder/lib.sh'
inotifywait -m -r -e create --format '%w%f' "${MONITORDIR}" | while read NEWFILE
do
    if [ -f $NEWFILE ]; then
        in_array VIDEO_EXTENSION "${NEWFILE#*.}"
        if [ $? -eq 0 ]; then
            bin/encoder/encoder.sh $NEWFILE &
        fi
    fi
done