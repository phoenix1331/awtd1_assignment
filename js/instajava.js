/* 
Instagram by Tom Reed
I used this tutorial for help with creating the API, but only used the code that was useful for me, and changed it for my needs http://eduvoyage.com/instagram-search-app.html */

var Instagram = {};

(function(){

function toScreen(photos){

$.each(photos.data, function(index, photo){
  photo = "<div class='image'>" +
    "<a href='"+ photo.link +"' target='_blank'>"+
      "<img class='picture' src='" + photo.images.low_resolution.url + "' />" +
    "</a>" +
  "</div>";

  $('div#imagewrapper').append(photo);
});
}

  function search(tag){
  	  var url = "https://api.instagram.com/v1/tags/" + tag + "/media/recent?callback=?&amp;client_id=226dccdab81f41ac8edf799492acac04"
    $.getJSON(url, toScreen);
  }
  

  
  Instagram.search = search;
})();

Instagram.search('whisky');



