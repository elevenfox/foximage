#!/bin/bash

# change directory to the desired one
cd $1
echo $1
echo ''

# look up files with extensions
for fname in *.*; do
  if [[ $(file -b ${fname}) =~ ^'JPEG ' ]]; then
    # get the width of the image
    WIDTH=`identify -ping -format '%w' ${fname}`
    # get the height of the image
    HEIGHT=`identify -ping -format '%h' ${fname}`
    
    MAX_SIZE=$WIDTH
    if [ $WIDTH -lt $HEIGHT ]; then
        MAX_SIZE=$HEIGHT
    fi
    echo "-- image width: $WIDTH, height: ${HEIGHT}...max_size: ${MAX_SIZE}"
    
    if [ $MAX_SIZE -gt 1400 ]; then
      if [ ${fname} != 'thumbnail.jpg' ];then  
        # set quality to 85% to make smaller file
        echo "Compress $fname with quality 85% ..."
        #mogrify -resize ${PERCENTAGE}%  -quality 80 "$fname"
        convert -strip -interlace Plane -gaussian-blur 0.05 -quality 85% "$fname" "$fname"
      fi  
    fi  
  fi
done

echo ''