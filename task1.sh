#!/bin/bash

# 1
useradd -m Hod

for a in $(seq 1 2)
do
useradd -m prof$a
done

for a in $(seq 1 100)
do
useradd -m student$a
done

# 2 and 3

for a in $(seq 1 2)
sudo mkdir /home/prof$a/Teaching_Material
sudo chown prof$a /home/prof$a/*
sudo chgrp prof$a /home/prof$a/*
sudo chmod 660 /home/prof$a/*
sudo setfacl -m u:Hod:rw0 .
done


for a in $(seq 1 100)
do
sudo mkdir /home/student$a/HomeWork
sudo chown student$a student$a /home/student$a/*
sudo chgrp student$a student$a /home/student$a/*
sudo chmod 660 /home/student$a/*
sudo setfacl -m u:Hod:rw0 .
sudo setfacl -m u:prof1:rw0 .
sudo setfacl -m u:prof2:rw0 .
done

# 4

for a in $(seq 1 2)
do
for b in $(seq 1 50)
do
sudo touch /home/prof$a/Teaching_Material/q$b.txt
cat /dev/urandom| tr -dc '0-9a-zA-Z'|head -c 100 > q$b.txt
done
done

# 5

for a in $(seq 1 100)
do
sudo mkdir /home/student$a/prof1_work
sudo mkdir /home/student$a/prof2_work
shuf -i 1-50 -n 5 | while read x
do
sudo cp /home/prof1/Teaching_Material/q$x.txt /home/student$a/prof1_work
sudo cp /home/prof2/Teaching_Material/q$x.txt /home/student$a/prof2_work
done
done

# 1

for a in $(seq 1 2)
do
sudo rm /home/prof$a/Teaching_Material/*
done

# 1a

sudo wget -O /home/prof1/dataStructures.txt http://inductions.delta.nitt.edu/algorithm.txt
sudo wget -O /home/prof2/Algorithms.txt http://inductions.delta.nitt.edu/dataStructure.txt

# 1b

sudo sed -i 's/\*\*/))/g' /home/prof1/dataStructures.txt
sudo sed -i 's/\*\*/))/g' /home/prof2/Algorithms.txt

cat /home/prof1/dataStuctures.txt | while read i
do
if [[ ${i:0:2} == '))' ]]
then
declare "m=1"
sudo mkdir /home/prof1/Teaching_Material/"$(echo $i | cut -c 4-)"
n=$(echo $i | cut -c 4-)
else
if [[ ${i:0:1} == '-' ]]
then
sudo echo "$(echo $i | cut -c 3-)" > /home/prof1/Teaching_Material/"$n"/q$m.txt
let "m= $m + 1"
fi
fi
done

cat /home/prof2/Algorithms.txt | while read i
do
if [[ ${i:0:2} == '))' ]]
then
declare "m=1"
sudo mkdir /home/prof2/Teaching_Material/"$(echo $i | cut -c 4-)"
n=$(echo $i | cut -c 4-)
else
if [[ ${i:0:1} == '-' ]]
then
sudo echo "$(echo $i | cut -c 3-)" > /home/prof2/Teaching_Material/"$n"/q$m.txt
let "m= $m + 1"
fi
fi
done


# 2

crontab -l > mycron
echo "0 17 * * 1,2,3,4,5,6 for a in $(seq 1 100); do sudo ls /home/prof1/Teaching_Material | shuf -n 5 | while read x; do ls /home/prof1/Teaching_Material/$x | shuf -n 1 | while read y; do cp /home/prof1/Teaching_Material/$x/$y /home/student$a/HomeWork; done; done;
sudo ls /home/prof2/Teaching_Material | shuf -n 5 | while read x; do ls /home/prof2/Teaching_Material/$x | shuf -n 1 | while read y; do cp /home/prof2/Teaching_Material/$x/$y /home/student$a/HomeWork; done; done; done" >> mycron 
crontab mycron
rm mycron

