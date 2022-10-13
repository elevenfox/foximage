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
    
    if [ $MAX_SIZE -gt 2700 ]; then
        PERCENTAGE=$((200*2400/$MAX_SIZE % 2 + 100*2400/$MAX_SIZE))
        
        # resize and set quality to 80% to make smaller file
        echo "resizing $fname to $PERCENTAGE% ..."
        mogrify -resize ${PERCENTAGE}%  -quality 80 "$fname"
    fi

    # this is the watermarking part
    if [ $MAX_SIZE -gt 1024 ]; then       
        POINT=30
        if [ $MAX_SIZE -ge 1800 ]; then
            POINT=40
        fi
        echo "watermarking $fname with pointsize ${POINT}"
        sleep 1
        convert $fname -font Liberation-Sans-Bold -pointsize $POINT -draw "gravity northeast fill rgba(0,0,0,1.0) text 30,32 'TUZAC.com' fill rgba(255,255,255,1.0) text 30,31 'TUZAC.com'" $fname
    fi
  fi
done

echo ''