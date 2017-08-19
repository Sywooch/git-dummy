#!/bin/bash
SNAPSHOT="/home/backup/$(date +%Y/%m/%d)"





for file in *
do
  echo $file;
  convert $file -quality 75 $file;
done


#convert $file -quality 75 $file;