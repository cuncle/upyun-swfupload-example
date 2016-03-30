<?php 
$bucket = 'bucket';//upyun空间名
$form_api_secret = 'form_api_secret';//表单密钥：后台——>空间——>通用——>基本设置
$options = array();
$options['bucket'] = $bucket;
$options['expiration'] = time()+600;
$options['save-key'] = '/{year}/{mon}/{day}/upload_{filename}{.suffix}';//save-key 详细说明可以看官方文档
$policy = base64_encode(json_encode($options));//policy 生成
$signature = md5($policy.'&'.$form_api_secret);// sigenature生成
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<head>
<title>SWFUpload</title>
<link href="css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="swfupload/swfupload.js"></script>
<script type="text/javascript" src="js/swfupload.queue.js"></script>
<script type="text/javascript" src="js/fileprogress.js"></script>
<script type="text/javascript" src="js/handlers.js"></script>
<script type="text/javascript">
var swfu;

		window.onload = function() {
			var settings = {
				flash_url : "swfupload/swfupload.swf",//swfupload.swf文件的绝对或相对地址，相对地址是指相对于当前的页面地址
				upload_url: 'http://v0.api.upyun.com/' + '<?php echo $bucket; ?>',	// API上传地址
				file_post_name : "file", //相当于用普通的文件域上传文件时的name属性，服务器端接收页面通过该名称来获取上传的文件
				post_params: {
				"policy" : "<?php echo $policy;?>",//policy传递
				"signature" : "<?php echo $signature; ?>"},//sigenature参数传递
				file_size_limit : "100 MB",//指定要上传的文件的最大体积，可以带单位，合法的单位有:B、KB、MB、GB，如果省略了单位，则默认为KB。该属性为0时，表示不限制文件的大小。
				file_types : "*.*", //指定了允许上传的文件类型，当有多个类型时使用分号隔开，比如：*.jpg;*.png ,允许所有类型时请使用 *.*
				file_types_description : "All Files",//指定在文件选取窗口中显示的文件类型描述，起一个提示和说明的作用吧 
				file_upload_limit : 100,/*指定最多能上传多少个文件，当上传成功的文件数量达到了这个最大值后，就不能再上传文件了，也不能往上传队列里添加文件了。把该属性设为0时表示不限制文件的上传数量。*/
				file_queue_limit : 0, /* 指定文件上传队列里最多能同时存放多少个文件。当超过了这个数目后只有当队列里有文件上传成功、上传出错或被取消上传后，等同数量的其他文件才可以被添加进来。当file_upload_limit的数值或者剩余的能上传的文件数量小于file_queue_limit时，则取那个更小的值 */
				custom_settings : {
					progressTarget : "fsUploadProgress",
					cancelButtonId : "btnCancel"
				},
				debug: false,

				// Button settings
				button_image_url: "images/TestImageNoText_65x29.png",	// Relative to the Flash file
				button_width: "65",
				button_height: "29",
				button_placeholder_id: "spanButtonPlaceHolder",
				button_text: '<span class="theFont">浏览</span>',
				button_text_style: ".theFont { font-size: 16; }",
				button_text_left_padding: 12,
				button_text_top_padding: 3,
				
				// The event handler functions are defined in handlers.js
				file_queued_handler : fileQueued,
				file_queue_error_handler : fileQueueError,
				file_dialog_complete_handler : fileDialogComplete,
				upload_start_handler : uploadStart,
				upload_progress_handler : uploadProgress,
				upload_error_handler : uploadError,
				upload_success_handler : uploadSuccess,
				upload_complete_handler : uploadComplete,
				queue_complete_handler : queueComplete	// Queue plugin event
			};

			swfu = new SWFUpload(settings);
	     };

	</script>
</head>
<body>
<div id="header">
	<h1 id="logo"><a href="/">SWFUpload</a></h1>
	<div id="version">v2.2.0</div>
</div>

<div id="content">
	<h2>Simple Demo</h2>
	<form id="form1" action="index.php" method="post" enctype="multipart/form-data">
		<p>This page demonstrates a simple usage of SWFUpload.  It uses the Queue Plugin to simplify uploading or cancelling all queued files.</p>

			<div class="fieldset flash" id="fsUploadProgress">
			<span class="legend">Upload Queue</span>
			</div>
		<div id="divStatus">0 Files Uploaded</div>
			<div>
				<span id="spanButtonPlaceHolder"> </span>
				<input id="btnCancel" type="button" value="Cancel All Uploads" onclick="swfu.cancelQueue();" disabled="disabled" style="margin-left: 2px; font-size: 8pt; height: 29px;" />
			</div>

	</form>
</div>
</div>
</body>
</html>
