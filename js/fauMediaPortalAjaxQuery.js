il.fauMediaQuery = (function (scope) {
	'use strict';

	var pub = {
		video_url	: null,
		video_title : null
	}, pro = {};
// 16292
	pub.getVideoUrl = function(video_id)
	{
		pub.video_url = null;

		$.ajax({
			type     : "GET",
			dataType : "JSON",
			url      : 'https://itunes.video.uni-erlangen.de/services/oembed/?url=https://www.video.uni-erlangen.de/clip/id/' + video_id + '&format=json',
			async    : false,
			success  : function(data) {
				pub.video_url = data.file;
				pub.video_title = data.title;
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				pro.setVideoTitle(il.Language.lng.rep_robj_xvid_fau_not_found);
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
				pro.setVideoTitle(il.Language.lng.rep_robj_xvid_fau_video_found + ' ' + pub.video_title);
				$('#fau_url').val(pub.video_url)
			}
			else
			{
				pro.setVideoTitle(il.Language.lng.rep_robj_xvid_fau_not_found);
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