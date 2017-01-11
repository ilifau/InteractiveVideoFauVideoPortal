il.fauMediaQuery = (function (scope) {
	'use strict';

	var pub = {
		video_url	: null,
		video_title : null
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
				pub.video_title = data.title;
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				
			}
		});
	};

	pub.appendListenerToTextInput = function()
	{
		$('#fau_id').on('input',function(e){
			pro.setVideoTitle('');
			pub.getVideoUrl($(this).val());
			if(pub.video_url !== null)
			{
				pro.setVideoTitle(pub.video_title);
				$('#fau_url').val(pub.video_url)
			}
		});
	};
	
	pro.setVideoTitle = function(text)
	{
		$('#fau_id').next().html(text);
	};
	
	pub.protect = pro;
	return pub;
}(il));

$( document ).ready(function() {
	il.fauMediaQuery.appendListenerToTextInput();
});