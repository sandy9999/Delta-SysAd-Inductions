#!/bin/bash
totalmem=$(free --mega | head -n 2 | awk '{print $2}' | awk NR==2)
usedmem=$(free --mega | head -n 2 | awk '{print $3}' | awk NR==2)
mempercent=$(echo $(( $usedmem*100/$totalmem )))
cpu=$(iostat | awk NR==4 | awk '{print 100-$6}')
disk=$(df -H | awk NR==4 | awk '{print $5}')
uptimedate=$(uptime -s | awk '{print $1}')
uptimetime=$(uptime -s | awk '{print $2}')
netconnects=$(netstat -at | wc -l)
maxmemproc=$(ps aux | awk '{print $4"\t" $11}' | sort -k1rn | head -n 1 | awk '{print $2}')
timestamp=$(date)
json=$(cat << EOF
{"memory_usage":"$mempercent", "cpu_usage":"$cpu", "disk_usage":"$disk", "uptime":"$uptimedate $uptimetime", "active_connections":"$netconnects", "maxmem_process":"$maxmemproc", "timestamp":"$timestamp"}
EOF
)
echo $json
curl -i -H "Accept: application/json" -H "Content-Type:application/json" -X POST -d "$json" "http://localhost:5000/url1"
