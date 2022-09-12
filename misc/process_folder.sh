#!/bin/bash

# change directory to the desired one
cur_folder=$1

./format_folder_name.sh ${cur_folder}

./rar-tuzac ${cur_folder}