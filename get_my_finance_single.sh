#!/bin/bash

#get list
my_code_list=$1

for i in `echo "$my_code_list"`
do
#get info
search_item=`curl -s https://stocks.finance.yahoo.co.jp/stocks/detail/?code=${i}.T`

#get last-value from code
item_last_value=`echo "$search_item" | grep '<td class="stoksPrice">' | sed -e 's/<td class="stoksPrice">//' | sed -e 's/<\/td>//' | tr -d ' ' | cut -d '.' -f 1 | sed -e 's/,//'`

#get name from code
item_name=`echo "$search_item" | grep 'class="symbol"' | sed -e 's/        <th class="symbol"><h1>//' | cut -f 1 -d '<'`

#export json 
#echo "{\"code\":\"${1}\" ,\"name\":\"${item_name}\",\"last_value\":\"${item_last_value}\"}"

curl -s http://localhost/finance/update_exec.php -d "code=${i}" -d "name=${item_name}" -d "last_value=${item_last_value}"
done


