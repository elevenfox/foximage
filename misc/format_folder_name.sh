#!/bin/bash

# For adding prefix or suffix for files(directories), you could use the simple and powerful way by xargs:
# ls | xargs -I {} mv {} PRE_{}
# ls | xargs -I {} mv {} {}_SUF
# ls *.old | xargs -I {} mv {} PRE_{}

# change directory to the desired one
cur_folder=$1

if [ -z "$cur_folder" ]; then
  read -p "Use '/mnt/wd8t/jw-hd-no-watermark/02-processing/'? (y/n)" CHOICE
  CHOICE=${CHOICE:-y}
  if [ ${CHOICE} == "y" ]; then
    cur_folder="/mnt/wd8t/jw-hd-no-watermark/02-processing/"
  else
    echo "Must set a full path folder!!!"
    echo ""
    exit 1
  fi 
fi   

echo "Current folder is: ${cur_folder}"

#######################################
# Define functions
#######################################
format_folder_name () {
  old_name=$1
  
  new_name=${old_name//XIUREN/XiuRen}
  new_name=${new_name//xiuren/XiuRen}
  new_name=${new_name//Xiuren/XiuRen}
  new_name=${new_name//NO./No.}
  new_name=${new_name//N0./No.}
  new_name=${new_name//\'/-}
  new_name=${new_name//\"/-}
  new_name=${new_name// - /-}
  new_name=${new_name// (/-}
  new_name=${new_name//(/-}
  new_name=${new_name//) /-}
  new_name=${new_name//)/-}
  new_name=${new_name//  /-}
  new_name=${new_name// /-}
  new_name=${new_name//--/-}

  echo ${new_name}
}

reorg_files () {
  full_dir_path=$1
  
  OIFS="$IFS"
  IFS=$'\n'

  # loop folder, exclude ., .., thumbnail.jpg, non-jpg files
  echo "--- reorg files in folder: ${full_dir_path}"
  cd "${full_dir_path}"

  # rename jpeg files to jpg if this is the case
  #rename 's/\.jpeg/\.jpg/' *
  # rename files to 000-->999 with postfix to avoid override
  i=1
  timestamp=$(date +%s)
  filelist=$(ls | grep -i '.jpg')
  for f in $filelist; do
    if [ "$f" != "thumbnail.jpg" ]; then
      num=`printf "%03d" ${i}`
      # rand_s=`tr -dc A-Za-z0-9 </dev/urandom | head -c 5`
      echo "---- mv ${f} --> ${num}-${timestamp}.jpg"
      mv "${f}" "${num}-${timestamp}.jpg"
      #exiftool -overwrite_original -all= "${num}-${timestamp}.jpg"
      i=$((i+1))
    fi  
  done

  # remove postfix
  i=1
  filelist=$(ls | grep -i '.jpg')
  for f in $filelist; do
    if [ "$f" != "thumbnail.jpg" ]; then
      num=`printf "%03d" ${i}`
      #rand_s=`tr -dc A-Za-z0-9 </dev/urandom | head -c 5`
      echo "---- mv ${f} --> ${num}.jpg"
      mv "${f}" "${num}.jpg"
      i=$((i+1))
    fi  
  done

  IFS="$OIFS"
}
#######################################
# End of functions
#######################################

new_cur_folder_name=`format_folder_name "${cur_folder}"`

if [ "${new_cur_folder_name}" != "${cur_folder}" ]; then
  echo " --> ${new_cur_folder_name}"
  mv "${cur_folder}" "${new_cur_folder_name}"
  echo ''
fi

cd "${new_cur_folder_name}"
reorg_files "${new_cur_folder_name}"

# look up sub folders
for d in */; do
  if [ "$d" != "*/" ]; then
    new_d=`format_folder_name "${d}"`
    if [ "${new_d}" != "${d}" ]; then
      echo "-- ${d}"
      echo "  --> ${new_d}"
      mv "${d}" "${new_d}"
    fi
    # re org file names to 000 --> 999 format
    reorg_files "${new_d}"
    cd ..
  fi  
done

echo ''