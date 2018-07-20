#!/bin/bash

sudo apt-get install -y mysql-server
sudo mysql_secure_installation
sudo mysql -u root -e "CREATE USER 'phpmyadmin'@'localhost' IDENTIFIED BY 'phpmyadmin';GRANT ALL PRIVILEGES ON *.* TO 'phpmyadmin'@'localhost' WITH GRANT OPTION; FLUSH PRIVILEGES"
sudo mysql -u root -e "CREATE DATABASE 'task';USE task"
sudo mysql -u root -e "CREATE TABLE monitortask (id INT PRIMARY KEY AUTO_INCREMENT,mempercent VARCHAR(255),cpu VARCHAR(255),disk VARCHAR(255),uptime VARCHAR(255),netconnects VARCHAR(255),maxmemproc VARCHAR(255),timestamp VARCHAR(255) );"
cd /tmp
curl -O https://repo.continuum.io/archive/Anaconda3-5.0.1-Linux-x86_64.sh
bash Anaconda3-5.0.1-Linux-x86_64.sh
conda create --name my_env python=3
source activate my_env
pip3 install pymysql
pip3 install flask
source deactivate
sudo echo "[Unit]
Description=Delta task, keep server always on
After=network.target
After=mysqld.service
StartLimitIntervalSec=0

[Service]
Type=simple
Restart=always
User=sandy
ExecStart=/home/sandy/anaconda3/envs/my_env/bin/python /home/sandy/Delta-SysAd-Inductions/monitortask/server.py
ExecRestart=/home/sandy/anaconda3/envs/my_env/bin/python /home/sandy/Delta-SysAd-Inductions/monitortask/server.py

[Install]
WantedBy=multi-user.target" >> /lib/systemd/system/monitortaskServer.service
sudo echo "[Unit]
Description=Run the Delta task Bash
After=network.target
After=mysqld.service
StartLimitIntervalSec=0

[Service]
Type=simple
Restart=always
RestartSec=300
User=sandy
ExecStart=/bin/bash /home/sandy/Delta-SysAd-Inductions/monitortask/hm.sh
ExecRestart=/bin/bash /home/sandy/Delta-SysAd-Inductions/monitortask/hm.sh

[Install]
WantedBy=multi-user.target" >> /lib/systemd/system/monitortaskBash.service

sudo systemctl start monitortaskServer
sudo systemctl enable monitortaskServer
sudo systemctl start monitortaskBash
sudo systemctl enable monitortaskBash
