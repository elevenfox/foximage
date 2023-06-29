#!/bin/bash

# For adding prefix or suffix for files(directories), you could use the simple and powerful way by xargs:
# ls | xargs -I {} mv {} PRE_{}
# ls | xargs -I {} mv {} {}_SUF
# ls *.old | xargs -I {} mv {} PRE_{}

# change directory to the desired one
cur_folder=$1

# defaultFolder="/mnt/wd8t/jw-hd-no-watermark/02-processing/"
defaultFolder="/home/eric/work/002-processing/"
if [ -z "$cur_folder" ]; then
  read -p "Use '${defaultFolder}'? (y/n)" CHOICE
  CHOICE=${CHOICE:-y}
  if [ ${CHOICE} == "y" ]; then
    cur_folder=${defaultFolder}
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
  # new_name=${new_name//XiuRen秀人网/XiuRen}
  new_name=${new_name//NO./No.}
  new_name=${new_name//N0./No.}
  new_name=${new_name//YouMi Vol./YouMi尤蜜荟-}
  new_name=${new_name//XingYan Vol./XingYan星颜社-}
  new_name=${new_name//MyGirl Vol./MyGirl美媛馆-}
  new_name=${new_name//HuaYang Vol./HuaYang花漾-}
  new_name=${new_name//HuaYan Vol./HuaYan花の颜-}
  new_name=${new_name//MFStar Vol./MFStar模范学院-}
  new_name=${new_name//MFStar-Vol./MFStar模范学院-}
  new_name=${new_name//IMiss Vol./IMiss爱蜜社-}
  new_name=${new_name//\'/-}
  new_name=${new_name//\"/-}
  new_name=${new_name// - /-}
  new_name=${new_name// (/-}
  new_name=${new_name//(/-}
  new_name=${new_name//) /-}
  new_name=${new_name//)/-}
  new_name=${new_name//  /-}
  new_name=${new_name// /-}
  new_name=${new_name//\&/-}
  new_name=${new_name//!/-}
  new_name=${new_name//\;/-}
  new_name=${new_name//\#/-}
  new_name=${new_name//+/-}
  new_name=${new_name//\[/-}
  new_name=${new_name//\]/-}
  new_name=${new_name//--/-}
  new_name=${new_name//安然anran/安然}
  new_name=${new_name//夏沫沫tifa/夏沫沫}
  new_name=${new_name//张思允nice/张思允}
  new_name=${new_name//小海臀rena/小海臀}
  new_name=${new_name//严利娅yuliya/严利娅}
  new_name=${new_name//养乐多dodo/养乐多}
  new_name=${new_name//顾乔楠cora/顾乔楠}
  new_name=${new_name//徐莉芝booty/徐莉芝}
  new_name=${new_name//周于希sally/周于希}
  new_name=${new_name//鱼子酱fish/鱼子酱}
  new_name=${new_name//王馨瑶yanni/王馨瑶}
  new_name=${new_name//郑颖姗bev/郑颖姗}
  new_name=${new_name//米娜mnal/米娜}
  new_name=${new_name//冯木木LRIS/冯木木}
  new_name=${new_name//Emily尹菲/尹菲}
  new_name=${new_name//果儿Victoria/果儿}
  new_name=${new_name//小蛮妖Yummy/小蛮妖}
  new_name=${new_name//文芮jeninfer/文芮}
  
  

  firstchar=${new_name:0:1}
  if [ "$firstchar" == "-" ]; then
    new_name="${new_name:1}"
  fi

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
  echo "--- rename jpeg files to jpg"
  rename 's/\.jpeg/\.jpg/' *
  rename 's/\.JPG/\.jpg/' *

  # Convert *.png to jpg
  echo "--- Convert *.png to jpg"
  mogrify -format jpg -quality 100 *.png
  rm -f *.png

  # rename files to 000-->999 with postfix to avoid override
  i=1
  timestamp=$(date +%s)
  filelist=$(ls -v | grep -i '.jpg')
  for f in $filelist; do
    exiftool -overwrite_original -all= "${f}"
    if [ "$f" != "thumbnail.jpg" ]; then
      num=`printf "%03d" ${i}`
      # rand_s=`tr -dc A-Za-z0-9 </dev/urandom | head -c 5`
      echo "---- mv ${f} --> ${num}-${timestamp}.jpg"
      mv "${f}" "${num}-${timestamp}.jpg"
      i=$((i+1))
    fi  
  done

  # remove postfix
  i=1
  filelist=$(ls -v | grep -i '.jpg')
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