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

echo " ----> ${new_cur_folder_name}"
mv "${cur_folder}" "${new_cur_folder_name}"
echo ''

cd "${new_cur_folder_name}"

# look up files with extensions
for d in */; do
  new_d=`format_folder_name "${d}"`
  echo "---- ${d}"
  echo "  ----> ${new_d}"
  mv "${d}" "${new_d}"
done

echo ''