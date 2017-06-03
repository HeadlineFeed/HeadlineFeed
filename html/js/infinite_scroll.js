var ajax_arry=[];
var ajax_index =0;
var sctp = 100;
$(function(){
  $('#loading').show();
$.ajax({
      url:"scroll.php",
                 type:"POST",
                 data:"actionfunction=showData&page=1",
       cache: false,
       success: function(response){
      $('#loading').hide();
     $('#wrap').html(response);

   }

    });
 $(window).scroll(function(){

    var height = $('#wrap').height();
    var scroll_top = $(this).scrollTop();
    if(ajax_arry.length>0){
    $('#loading').hide();
    for(var i=0;i<ajax_arry.length;i++){
      ajax_arry[i].abort();
    }
 }
    var page = $('#wrap').find('.nextpage').val();
    var isload = $('#wrap').find('.isload').val();

      if ((($(window).scrollTop()+document.body.clientHeight+400)>=$(window).height()) && isload=='true'){
      $('#loading').show();
    var ajaxreq = $.ajax({
      url:"scroll.php",
                 type:"POST",
                 data:"actionfunction=showData&page="+page,
       cache: false,
       success: function(response){
      $('#wrap').find('.nextpage').remove();
      $('#wrap').find('.isload').remove();
      $('#loading').hide();

     $('#wrap').append(response);

   }

    });
    ajax_arry[ajax_index++]= ajaxreq;

    }
 return false;


 });

});
