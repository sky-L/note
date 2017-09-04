## nginx转发请求

```

server {
    listen 80;
    server_name example.com;

    location / {
        proxy_set_header   X-Real-IP $remote_addr;
        proxy_set_header   Host      $http_host;
        proxy_pass         http://127.0.0.1:2368;
    }
}

```
## apache转发请求

```
<VirtualHost *:80> 
  ServerAdmin 管理员邮箱 
  ServerName localhost 
  ServerAlias localhost 
  ProxyPass http://127.0.0.1:9999
</VirtualHost> 

```


## apache支持php

`AddHandler application/x-httpd-php .php`

## nginx支持php

```
    location ~ ^(.+\.php)(.*)$
    {
            fastcgi_split_path_info ^(.+\.php)(.*)$;
            include fastcgi.conf;
            fastcgi_pass 127.0.0.1:9000;
            fastcgi_index index.php;
            fastcgi_param PATH_INFO $fastcgi_path_info;
    }
```
