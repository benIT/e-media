#!/bin/bash
####################################
#Usage:
#bin/encoder/encodeAll.sh: will encode all videos that are not already encoded.
#bin/encoder/encodeAll.sh -f: will encode all videos that are although if already encoded.
####################################
source 'bin/encoder/lib.sh'
ENCODE_EXISTING=false

function launchEncoding(){
    CURRENTDIR=$1
    for i in "${VIDEO_EXTENSION[@]}"
        do
             ls $CURRENTDIR/*.$i > /dev/null 2>&1
             if [ $? -eq 0 ]; then
                bin/encoder/encoder.sh ${CURRENTDIR}/*.$i
             fi
        done
}

while getopts ":f" opt; do
  case $opt in
    f)
      echo "-f was triggered!" >&2
      ENCODE_EXISTING=true
      ;;
    \?)
      echo "Invalid option: -$OPTARG" >&2
      exit 1
      ;;
  esac
done

for CURRENTDIR in $(ls -d ${MONITORDIR}/*)
do
    echo ${CURRENTDIR}
    if [ -f ${CURRENTDIR}/index.m3u8 ]; then
        if [ "${ENCODE_EXISTING}" = true ]; then
            launchEncoding ${CURRENTDIR}
        else
            log "$LEVEL_INFO" "${CURRENTDIR} already encoded!"
        fi
    else
        launchEncoding ${CURRENTDIR}
    fi
done