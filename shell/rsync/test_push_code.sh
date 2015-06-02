#!/bin/bash

read -p "Please input your Package name:" Pname

MPWD=/codes/vmall_test

UPWD=$MPWD/$Pname

logdir=`date +%Y%m%d`/`date +%H`/$Pname

cd $Pname

svn up --username sky --password xxxxxx

sleep 2s

cd ..

if [ -d  $UPWD ] ; then


IpList=`cat iplist.txt |awk '{print $1}'`

for i in $IpList

do

if [ ! -d $logdir ] ; then

	mkdir -p $logdir

fi
echo ${i}
echo "==========starting=========="
rsync -vzrtopg --exclude-from="/codes/vmall_test/exclude.list"  --delete $UPWD/  rsync@${i}::t${Pname} >> ${logdir}/${i}.log

sleep 2s

echo "The rsync with $i is complete"  
echo "==========End=========="

done

else

echo "The $Pname  not exist"

fi
