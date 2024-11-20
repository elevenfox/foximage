#!/bin/bash

# Change directory to the desired one
cd $1
echo $1
echo ''

# Look up files with extensions
for fname in *.*; do
  if [[ $(file -b ${fname}) =~ ^'JPEG ' ]]; then
    # Get the width of the image
    WIDTH=`identify -ping -format '%w' ${fname}`
    # Get the height of the image
    HEIGHT=`identify -ping -format '%h' ${fname}`

    # Get file size
    FILESIZE=$(stat -c%s "${fname}")
    
    MAX_SIZE=$WIDTH
    if [ $WIDTH -lt $HEIGHT ]; then
        MAX_SIZE=$HEIGHT
    fi
    echo "-- Image width: $WIDTH, height: ${HEIGHT}...max_size: ${MAX_SIZE}"
    
    if [ $MAX_SIZE -gt 2700 ]; then
        PERCENTAGE=$((200*2400/$MAX_SIZE % 2 + 100*2400/$MAX_SIZE))
        
        # resize and set quality to 80% to make smaller file
        echo "Resizing $fname to $PERCENTAGE% ..."
        mogrify -resize ${PERCENTAGE}%  -quality 80 "$fname"
        # convert -strip -interlace Plane -gaussian-blur 0.05 -quality 80% -resize ${PERCENTAGE}% "$fname" "$fname"
    elif [ $FILESIZE -gt 800000 ]; then
        echo "Compressing $fname ..."
        convert -quality 80% "$fname" "$fname"
    fi

    # Convert *.png to jpg
    # -- mogrify -format jpg -quality 100 *.png
    # -- mogrify -resize 100% -quality 80 *.jpg

    # this is the watermarking part
    # -- do not wm thumbnail.jpg
    # -- do not wm images smaller than 1024
    # -- sleep 1 second if an image just be resized above
    if [ ${fname} != 'thumbnail.jpg' ];then
      if [ $MAX_SIZE -gt 700 ]; then       
          POINT=30
          if [ $MAX_SIZE -ge 1800 ]; then
              POINT=40
          fi
          echo "watermarking $fname with pointsize ${POINT}"
          if [ $MAX_SIZE -gt 2700 ]; then
            sleep 0.1
          fi  
          convert $fname -font Liberation-Sans-Bold -pointsize $POINT -draw "gravity northeast fill rgba(0,0,0,1.0) text 30,32 'TUZAC.com' fill rgba(255,255,255,1.0) text 30,31 'TUZAC.com'" $fname
      fi
    fi  
  fi
done

echo ''