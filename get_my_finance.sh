#!/bin/bash

#get list
my_code_list=`curl -s http://localhost/finance/update_items.php`

for i in `echo "$my_code_list"`
do
#get info
sleep 2
search_item=`curl -s https://stocks.finance.yahoo.co.jp/stocks/detail/?code=${i}.T`

#get last-value from code
item_last_value=`echo "$search_item" | grep '<td class="stoksPrice">' | sed -e 's/<td class="stoksPrice">//' | sed -e 's/<\/td>//' | tr -d ' ' | cut -d '.' -f 1 | sed -e 's/,//'`

#get name from code
item_name=`echo "$search_item" | grep 'class="symbol"' | sed -e 's/        <th class="symbol"><h1>//' | cut -f 1 -d '<'`


#get 前日比
item_diff_per=`echo "$search_item" | grep 'td class="change"' | sed -e 's/<[^>]*>//g' | sed -e 's/前日比//g'`

#

#export json 
#echo "{\"code\":\"${1}\" ,\"name\":\"${item_name}\",\"last_value\":\"${item_last_value}\"}"

curl -s http://localhost/finance/update_exec.php -d "code=${i}" -d "name=${item_name}" -d "last_value=${item_last_value}" -d "time_value=`date +'%Y-%m-%d %H:%M:%S'`"
done


