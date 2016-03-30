<?php 
$bucket = 'bucket';//upyun�ռ���
$form_api_secret = 'form_api_secret';//����Կ����̨����>�ռ䡪��>ͨ�á���>��������
$options = array();
$options['bucket'] = $bucket;
$options['expiration'] = time()+600;
$options['save-key'] = '/{year}/{mon}/{day}/upload_{filename}{.suffix}';//save-key ��ϸ˵�����Կ��ٷ��ĵ�
$policy = base64_encode(json_encode($options));//policy ����
$signature = md5($policy.'&'.$form_api_secret);// sigenature����
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
				flash_url : "swfupload/swfupload.swf",//swfupload.swf�ļ��ľ��Ի���Ե�ַ����Ե�ַ��ָ����ڵ�ǰ��ҳ���ַ
				upload_url: 'http://v0.api.upyun.com/' + '<?php echo $bucket; ?>',	// API�ϴ���ַ
				file_post_name : "file", //�൱������ͨ���ļ����ϴ��ļ�ʱ��name���ԣ��������˽���ҳ��ͨ������������ȡ�ϴ����ļ�
				post_params: {
				"policy" : "<?php echo $policy;?>",//policy����
				"signature" : "<?php echo $signature; ?>"},//sigenature��������
				file_size_limit : "100 MB",//ָ��Ҫ�ϴ����ļ��������������Դ���λ���Ϸ��ĵ�λ��:B��KB��MB��GB�����ʡ���˵�λ����Ĭ��ΪKB��������Ϊ0ʱ����ʾ�������ļ��Ĵ�С��
				file_types : "*.*", //ָ���������ϴ����ļ����ͣ����ж������ʱʹ�÷ֺŸ��������磺*.jpg;*.png ,������������ʱ��ʹ�� *.*
				file_types_description : "All Files",//ָ�����ļ�ѡȡ��������ʾ���ļ�������������һ����ʾ��˵�������ð� 
				file_upload_limit : 100,/*ָ��������ϴ����ٸ��ļ������ϴ��ɹ����ļ������ﵽ��������ֵ�󣬾Ͳ������ϴ��ļ��ˣ�Ҳ�������ϴ�����������ļ��ˡ��Ѹ�������Ϊ0ʱ��ʾ�������ļ����ϴ�������*/
				file_queue_limit : 0, /* ָ���ļ��ϴ������������ͬʱ��Ŷ��ٸ��ļ����������������Ŀ��ֻ�е����������ļ��ϴ��ɹ����ϴ������ȡ���ϴ��󣬵�ͬ�����������ļ��ſ��Ա���ӽ�������file_upload_limit����ֵ����ʣ������ϴ����ļ�����С��file_queue_limitʱ����ȡ�Ǹ���С��ֵ */
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
				button_text: '<span class="theFont">���</span>',
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
