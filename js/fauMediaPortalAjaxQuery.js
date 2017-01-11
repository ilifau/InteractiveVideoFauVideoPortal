il.fauMediaQuery = (function (scope) {
	'use strict';

	var pub = {
		video_url : null
	}, pro = {};
// 16292
	pub.getVideoUrl = function(video_id)
	{
		$.ajax({
			type     : "GET",
			dataType : "JSON",
			url      : 'https://www.video.uni-erlangen.de/services/oembed/?url=https://www.video.uni-erlangen.de/webplayer/id/' + video_id + '&format=json',
			async    : false,
			success  : function(data) {
				pub.video_url = data.file;
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				return 'nothing found';
			}
		});
	};

	pub.appendListenerToTextInput = function()
	{
		$('#fau_id').on('input',function(e){
			pub.getVideoUrl($(this).val());
			if(pub.video_url !== null)
			{
				$('#fau_url').val(pub.video_url)
			}
		});
	};
	
	pub.protect = pro;
	return pub;
}(il));

$( document ).ready(function() {
	il.fauMediaQuery.appendListenerToTextInput();
});