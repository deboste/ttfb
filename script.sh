#!/bin/bash

cur_dns=$(echo $1 | awk -F'.' '{print $(NF-1)"."$(NF);}')
cur_ns=$(dig +time=1 +tries=1 +nocmd +noall +answer NS ${cur_dns} | head -n1 | awk '{print $NF;}')
cur_reg=$(echo ${cur_ns} | awk -F'.' '{print $(NF-2);}')
cur_ttl=$(dig +time=1 +tries=1 +nocmd +noall +answer @${cur_ns} $1 | awk '{print $2;}')
echo "$cur_reg:$cur_ttl"