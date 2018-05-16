#!/bin/bash
##################################################################
#configuration
##################################################################
MONITORDIR="..//e-media-data/video"
LOGFILE='var/logs/encoder.log'
SEGMENT_DURATION=1
declare -a VIDEO_EXTENSION=("mp4" "flv" "mkv");
declare -a FRAME_SIZES_TO_PROCESS=("1280x720" "720x480");