>服务端的基本配置

```
secrets file = /etc/rsyncd.secrets
motd file = /etc/rsyncd.motd 
uid = root
gid = root
use chroot = no
max connections = 15
log file = /logs/rsync/rsyncd.log
pid file = /logs/rsync/rsyncd.pid
lock file = /logs/rsync/rsync.lock
hosts allow = 10.99.101.110
hosts deny = *
# Remote sync configuration module
[t1]
comment = testsync directory
read only = false
path = /tmp/rsync


```

客户端使用命令
`rsync -vzrtopg --exclude-from="/codes/vmall_test/exclude.list"  --delete /codes/vmall_test/admin/ rsync@192.168.1.1::t1`
