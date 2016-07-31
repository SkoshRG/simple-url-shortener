$(document).ready(function() {
  $('#shorten').on('click', function () {
    var link = $('#link-to-shorten').val();
    var valid = /^(http[s]?:\/\/){0,1}(www\.){0,1}[a-zA-Z0-9\.\-]+\.[a-zA-Z]{2,5}[\.]{0,1}/.test(link);
    if(valid) {
      // TODO: Request to shorten.php
      $.post('./shorten.php', {shorten: link}, function(data) {
        handleJsonResponse(data, function(data) {
          var shortenedLink = data['shortened_link'];
          $('#shortened-link').text('Shortened link: ' + shortenedLink);
          $('#shortened-link').css('display', 'block');
        });
      });
    } else {
      console.log("Link is not valid.");
      // TODO: Alert person that link is invalid
    }
  });
});

function handleJsonResponse (jsonObj, callback) {
  jsonObj = JSON.parse(jsonObj);
	if (jsonObj['success'] === 1) {
		var data = jsonObj['data'];
		callback(data);
	} else {
		var msg = jsonObj['errMsg'];
		errMsg(msg);
	}
}
