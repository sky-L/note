#do not modify
ROOT=`dirname $0`
cd $ROOT
ROOT=`pwd`
echo $ROOT >> /tmp/xxx

CRON_LOG=${ROOT}/${CRON_NAME}.log
CRON_PID=${ROOT}/${CRON_NAME}.pid
CRON_LOCK=${ROOT}/${CRON_NAME}.lock
CRON_JOB_PID=${ROOT}/${CRON_NAME}_job.pid

start () {
    echo "starting..."
    if [ -f $CRON_LOCK ]
    then
        return 1
    else
        touch $CRON_LOCK
        if [ $? != 0 ]
        then
            exit 1
        fi
        trap 'rm $CRON_LOCK' EXIT
        echo $$ > $CRON_PID
        while true
        do
            $CRON_EXEC $CRON_FILE $CRON_ARGV >> $CRON_LOG 2>&1 & PID=$!
            echo $PID > $CRON_JOB_PID
            wait $PID
            RET=$?
            NOW=`date`
            echo "${NOW}:$CRON_NAME exit with code $RET" >> $CRON_LOG
			if [[ $SLEEP_TIME > 0 ]]
			then
			    sleep $SLEEP_TIME
			fi
        done
    fi
}

stop_pid_file () {
    PID_FILE=$1
    if [ -f $PID_FILE ]
    then
        PID=`cat $PID_FILE`
        ps $PID >/dev/null 2>/dev/null
        if [ $? == 0 ]
        then
            kill $PID
            return 0
        fi
    fi
    return 1
}

stop () {
    stop_pid_file "$CRON_PID"
    RET=$?
    stop_pid_file "$CRON_JOB_PID"
    RET_JOB=$?
    if [[ $RET == 0 && $RET_JOB == 0 ]]
    then
        echo "stop ok"
    fi
}

status () {
    if [ -f $CRON_PID ]
    then
        PID=`cat $CRON_PID`
        ps $PID  >/dev/null 2>/dev/null
        if [ $? == 0 ]
        then
            echo "running..."
        else
            echo "not running"
        fi
    else
        echo "not running"
    fi
}

case "$1" in
        start)
                $1
                RETVAL=$?
                ;;
        stop)
                $1
                RETVAL=$?
                ;;
        restart)
                stop
                sleep 1
                start
                RETVAL=$?
                ;;
        status)
                $1
                ;;
        *)
                echo $"Usage: $0 {start|stop|restart|status}"
                RETVAL=2
esac

exit $RETVAL
