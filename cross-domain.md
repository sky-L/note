##ajax跨域可以这样解决，也真是大吃一惊啊，

直接上dame


###CORS语法

header(‘Access-Control-Allow-Origin: http://www.example.com/’); //指定某域下才可访问

header(‘Access-Control-Allow-Methods: GET, POST, PUT, DELETE’); //可用方法 不写为全部

header(‘Access-Control-Max-Age: 3628800′); //数据缓存有效期


一般来说只写第一条就可以满足大部分的需求

###具体代码：

>php端，以下是比较粗暴有效的做法，为了安全可参考上面的选项


```
<?php
header("Access-Control-Allow-Origin:*");
var_dump($_POST);

```

>前端

```
<script>
   $.ajax({
  		 type: "POST",
  		 url: "http://localhost/cors.php",
  		 data: {username:"a"},
  		 success: function(data){
  					alert(data);
  			}
      });
</script>
```


这样就能解决跨域的问题，竟也是无言以对
