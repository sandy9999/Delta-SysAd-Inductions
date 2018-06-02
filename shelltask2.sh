#!/bin/bash

# 1 Assuming, ip.txt has been downloaded
awk '{print $2}' ip.txt | sort | uniq -c | sort -r -n -k 1 | head -20


# 2
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

#4

history | awk '{print $2}' | sort | uniq -c | sort -r -n -k 1 | head -11 

#5

ls -l -S

#6
find /home/sandy -atime +14 -type f | while read x; do if [ -s $x ]; then rm $x; fi; done 
