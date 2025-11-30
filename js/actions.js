$(document).ready(function(){
  if(Foundation.MediaQuery.current == 'small') moveHomeElements();
});
$(window).on('changed.zf.mediaquery', function(event, newSize, oldSize){
    if($('.home') && (newSize =='small')) moveHomeElements();
    if($('.home') && (newSize !='small')) moveHomeElementsBack();
});


function moveHomeElements() {
  console.log("so it's small");
  console.log("move the activities list at the top");
  $('#iniziative').prependTo("#col1");

  console.log("move the news list at the top");
  $('#news').prependTo("#col1");

  console.log("set the first block on the top again");
  $('[data-post-id="133"]').prependTo("#col1");

  console.log("move 'dona-con-paypal' to the bottom of the first col");
  $('[data-post-id="dona-con-paypal"]').appendTo("#col1");
}

function moveHomeElementsBack() {
  console.log("so it's not small");
  console.log("move the activities list back to the 2th column");
  $('#iniziative').appendTo("#col2");
  console.log("move the news list back to the 3th column");
  $('#news').prependTo("#col3");

  console.log("move 'sostieni-la-co' to the bottom of the first col");
  $('[data-post-id="sostieni-la-co"]').appendTo("#col1");


}
