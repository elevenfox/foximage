#!/bin/bash

for i in {1..34}
do
 mkdir $i
 cd $i
 for j in {1..12}
 do
    echo $j
    wget https://javhd.pics/photos/japanese/maria-ozawa/${i}/maria-ozawa-${j}.jpg
 done
 cd ..
done

# https://javhd.pics/photos/japanese/anri-okita/76/anri-okita-1.jpg 
# https://javhd.pics/photos/japanese/bejean-tia/54/bejean-tia-12.jpg
# https://javhd.pics/photos/japanese/megu-fujiura/87/megu-fujiura-12.jpg
# https://javhd.pics/photos/japanese/maria-ozawa/34/maria-ozawa-12.jpg