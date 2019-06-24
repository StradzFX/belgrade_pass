<!DOCTYPE html>
<html>
<head>
    <title>My Uploadify Implementation</title>
<link rel="stylesheet" type="text/css" href="uploadify.css" />
<link rel="stylesheet" type="text/css" href="../../css/style.css" />
<script type="text/javascript" src="../jquery.js"></script>
<script type="text/javascript" src="jquery.uploadify-3.1.min.js"></script>
    <script type="text/javascript">
    $(function() {
		$element_name = 'file_upload';
		$dest_folder = 'untitled';
		$button_text = 'SELECT FILE';
        $('#'+$element_name).uploadify({
            'swf'      : 'uploadify.swf',
            'uploader' : 'uploadify.php?folder='+$dest_folder,
            // Your options here
			'buttonClass' : 'uploadify_button',
			'preventCaching' : false,
			'removeCompleted' : false,
			'buttonText' : $button_text,
			'multi' : false,
			'method' : 'post',
			'auto'     : true,
			'onFallback' : function() {
				$('#'+$element_name).uploadify('destroy');
			},
			'onUploadSuccess' : function(file, data, response) {
				$('#'+$element_name).hide();
				
        	},
			'onSelect' : function(file) {
           		$('#'+$element_name).uploadify('disable', true);
        	},
			'onUploadError' : function(file, errorCode, errorMsg, errorString) {
				$('#'+$element_name).uploadify('disable', false);
				$('#'+$element_name).uploadify('cancel','*');
			}
        });
    });
    </script>
</head>
<body>

<input type="file" name="file_upload" id="file_upload" />
</body>
</html>