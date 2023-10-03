#!/bin/bash

# change directory to the desired one
cur_folder=$1
action=$2
prefix=$3

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
if [ -z "$action" ]; then
    echo "Must set an action!!!"
    echo ""
    exit 1
fi
if [ -z "$prefix" ]; then
    echo "Must set the prefix string!!!"
    echo ""
    exit 1
fi

echo "Target parent folder is: ${cur_folder}"
echo "Action is: ${action}"
echo "Prefix is: ${prefix}"

cd "${cur_folder}"

if [ ${action} == 'add' ]; then
  # For adding prefix or suffix for files(directories), you could use the simple and powerful way by xargs:
  ls | xargs -I {} mv {} ${prefix}{}
fi

if [ ${action} == 'remove' ]; then
  # look up sub folders
  for d in */; do
    if [ "$d" != "*/" ]; then
      new_d=${d//${prefix}/''}
      if [ "${new_d}" != "${d}" ]; then
        echo "-- ${d}"
        echo "  --> ${new_d}"
        mv "${d}" "${new_d}"
      fi
    fi  
  done
fi
