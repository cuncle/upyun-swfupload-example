**UPYUN-Swfupload上传Demo**

一个基于 又拍云云存储 及swfupload 开发的上传Demo

**依赖**

1、Swfupload 2.2.0

2、UPYUN HTTP FORM API

**安装和运行程序**

获取源代码： git clone https://github.com/cuncle/upyun-swfupload-example.git

编辑 index.php 文件，修改您的服务名，操作员，操作员密码。

**说明**

```
        flash_url : "swfupload/swfupload.swf",//swfupload.swf文件的绝对或相对地址，相对地址是指相对于当前的页面地址
			upload_url: 'http://v0.api.upyun.com/' + '<?php echo $bucket; ?>',	// API上传地址
			file_post_name : "file",//相当于用普通的文件域上传文件时的name属性，服务器端接收页面通过该名称来获取上传的文件
			post_params: {
			"policy" : "<?php echo $policy;?>",//policy传递
			"authorization" : "<?php echo $authorization; ?>"},//authorization参数传递
```

上传文件后，可以通过UPYUN外链方式访问获取上传的文件。
