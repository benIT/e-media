#!/bin/bash
#this scripts to encode video: from a video file to a .index.m3u8 file for Http Live Streaming!
# https://opensource.com/article/17/6/ffmpeg-convert-media-file-formats
source 'bin/encoder/lib.sh'
NEWFILE=$1
log "$LEVEL_INFO" "video to encode detected: ${NEWFILE}"
DIR=$(dirname ${NEWFILE})
FILENAME=$(basename "$NEWFILE")
EXTENSION="${FILENAME##*.}"
FILENAME="${FILENAME%.*}"
echo "evaluating ${file} : filename is ${FILENAME} and extension is ${EXTENSION}"

rm -f ${DIR}/*.m3u8 ${DIR}/*.ts ${DIR}/lock ${DIR}/error
touch ${DIR}/lock
log "$LEVEL_INFO" "encoding video: ${NEWFILE}..."

for FRAME_SIZE in "${FRAME_SIZES_TO_PROCESS[@]}"
do
    rm -rf ${DIR}/${FRAME_SIZE}
    mkdir -p ${DIR}/${FRAME_SIZE}
    #generate framesize
    ffmpeg -i ${NEWFILE} -c:a copy -s ${FRAME_SIZE} "${DIR}/${FRAME_SIZE}/${FILENAME}.${EXTENSION}" 2> /dev/null
    ffmpeg -i ${DIR}/${FRAME_SIZE}/${FILENAME}.${EXTENSION}  -hls_list_size 0 -f hls ${DIR}/${FRAME_SIZE}/index.m3u8 2> /dev/null
done
#generate hls segment and playlist for original uploaded file too
ffmpeg -i ${NEWFILE} -hls_list_size 0 -f hls ${DIR}/index.m3u8 2> /dev/null
if [ $? -eq 0 ]; then
    log "$LEVEL_INFO" "video encoded: ${NEWFILE}"
else
    log "$LEVEL_ERROR" "encoding error: ${NEWFILE}"
    touch ${DIR}/error
fi
rm -f ${DIR}/lock