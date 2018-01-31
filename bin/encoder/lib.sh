#!/bin/bash

##################################################################
#Variables
##################################################################
MONITORDIR="/vagrant/shared/e-media/web/e-media-data/video"
LOGFILE='var/logs/encoder.log'
declare -a VIDEO_EXTENSION=("mp4" "flv" "mkv");

##################################################################
#Functions
##################################################################
in_array() {
    local haystack=${1}[@]
    local needle=${2}
    for i in ${!haystack}; do
        if [[ ${i} == ${needle} ]]; then
            return 0
        fi
    done
    return 1
}

readonly LEVEL_INFO='INFO'
readonly LEVEL_WARNING='WARNING'
readonly LEVEL_ERROR='ERROR'

#$1: log level
#$2: log message
function log {
    echo -e "$(date) - $1 - $2" >> ${LOGFILE}
}