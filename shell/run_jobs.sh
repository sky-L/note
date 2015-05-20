ROOT=`dirname $0`
cd $ROOT
ROOT=`pwd`

for F in `find . -type f -iname "job.sh"`
do
/bin/sh $F start &
done

