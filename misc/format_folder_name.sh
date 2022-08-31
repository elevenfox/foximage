#!/bin/bash

# change directory to the desired one
cur_folder=$1

echo "Current folder is: ${cur_folder}"

format_folder_name () {
  old_name=$1;
  new_name=${old_name//\'/-}
  new_name=${new_name//\"/-}
  new_name=${new_name// - /-}
  new_name=${new_name// (/-}
  new_name=${new_name//(/-}
  new_name=${new_name//) /-}
  new_name=${new_name//)/-}
  new_name=${new_name// /-}

  echo ${new_name}
}

new_cur_folder_name=`format_folder_name "${cur_folder}"`

if [ "${new_cur_folder_name}" != "${cur_folder}" ]; then
  echo " ----> ${new_cur_folder_name}"
  mv "${cur_folder}" "${new_cur_folder_name}"
  echo ''
fi

cd "${new_cur_folder_name}"

# look up files with extensions
for d in */; do
  new_d=`format_folder_name "${d}"`
  if [ "${new_d}" != "${d}" ]; then
    echo "---- ${d}"
    echo "  ----> ${new_d}"
    mv "${d}" "${new_d}"
  fi
done

echo ''