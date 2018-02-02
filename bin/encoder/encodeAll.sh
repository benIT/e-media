#!/bin/bash
####################################
#Usage:
#bin/encoder/encodeAll.sh: will encode all videos that are not already encoded.
#bin/encoder/encodeAll.sh -f: will encode all videos that are although if already encoded.
####################################
source 'bin/encoder/lib.sh'
ENCODE_EXISTING=false

while getopts ":f" opt; do
  case $opt in
    f)
      echo "all existing videos will be re-encoded." >&2
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