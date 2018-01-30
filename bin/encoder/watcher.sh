#!/bin/bash
#run this script to launch file watcher
source 'bin/encoder/lib.sh'
declare -a VIDEO_EXTENSION=("mp4" "flv" "mkv");

MONITORDIR="/vagrant/shared/e-media/web/e-media-data/video"
inotifywait -m -r -e create --format '%w%f' "${MONITORDIR}" | while read NEWFILE
do
    in_array VIDEO_EXTENSION "${NEWFILE#*.}"
    if [ $? -eq 0 ]; then
        bin/encoder/encoder.sh $NEWFILE &
    fi
done