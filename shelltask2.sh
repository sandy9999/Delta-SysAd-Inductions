#!/bin/bash

2
echo "Enter filename"
read filename
echo "Enter word"
read word
grep -o "$word" "$filename" | wc -l

#3
echo "Enter filename"
read filename
echo "Enter search word"
read sw
echo "Enter replace word"
read rw
sed -i "s/$sw/$rw/g" "$filename"


#5

ls -l -S

#6
find /home/sandy -atime +14 -type f | while read x; do if [ -s $x ]; then rm $x; fi; done 
