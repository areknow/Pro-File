var id;
var xmlIsReady = false;
var zipIsReady = false;

var showtoast = new ToastBuilder();

$(document).ready(function (e) {
  
  checkCookie()
  newUser();
  
  $("#uploadFormProfile").on('submit',(function(e) {
    e.preventDefault();
    $.ajax({
      url: "php/upload.php",
      type: "POST",
      data:  new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      success: function(data) {
        var mydata= $.parseJSON(data);
        console.log(mydata);
        $("#uploadFormProfile .title").html(mydata[1]);
        if (mydata[0]=="0") {
          xmlIsReady = true;
          showtoast('system profile ready');
        } else if (mydata[1]=="1") {
          xmlIsReady = false;
        }
        checkIfReadyToRun();
      }, error: function() {
        console.log(e);
      } 	        
    });
  }));

  $("#uploadFormDashboard").on('submit',(function(e) {
    e.preventDefault();
    $.ajax({
      url: "php/upload.php",
      type: "POST",
      data:  new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      success: function(data) {
        var mydata= $.parseJSON(data);
        console.log(mydata);
        $("#uploadFormDashboard .title").html(mydata[1]);
        if (mydata[0]=="0") {
          zipIsReady = true;
          showtoast('dashboards ready');
        } else if (mydata[1]=="1") {
          zipIsReady = false;
        }
        checkIfReadyToRun();
      }, error: function() {
        console.log(e);
      } 	        
    });
  }));

  $("#runner").click(function() {
    $('.button').toggleClass('disabled');
    console.log("begin fetch");
    showtoast("running...");
    $("#runner-icon").toggleClass("bt-spin");
    $("#runner .title").html("Searching for measures");
    $.ajax({
      type: "POST",
      url: "php/parse.php",
      data: {id:id},
      cache: false,
      success: function(data){
        var mydata= $.parseJSON(data);
        console.log(mydata);
        console.log(mydata.length);
        $('.button-row').toggleClass('button-row-adjusted');
        $('#output').fadeToggle();
        $('#measure-count span').html(mydata.length);
        var ul = $('#output ul');
        $.each(mydata, function(i) {
          var li = $('<li/>')
          .appendTo(ul)
          .text(mydata[i]);
        });
        console.log("end fetch");
        showtoast("done!");
        $("#runner-icon").toggleClass("bt-spin");
        $("#runner .title").html("Search for measures");
        resetUser();
      }
    });
  });

  $('#close-output').click(function() {
    $('.button-row').toggleClass('button-row-adjusted');
    $('#output').fadeToggle();
    $('#output ul').html("");
  });

  $('.info-button, #modal-close').click(function() {
    $('.modal-cover').fadeToggle();
  });
});













function checkIfReadyToRun() {
  if (xmlIsReady && zipIsReady) {
    $('.button3').toggleClass('disabled');
  }
}
function clickProfileUpload() {
  var ext = $("#fileProfile").val().split('.').pop().toLowerCase();
  if($.inArray(ext, ['xml']) == -1) {
    showtoast("only .xml is allowed");
  } else {
    $('#profileUpload').click();
  }
}
function clickDashboardUpload() {
  var ext = $("#fileDash").val().split('.').pop().toLowerCase();
  if($.inArray(ext, ['zip']) == -1) {
    showtoast("only .zip is allowed");
  } else {
    $('#dashboardUpload').click();
  }
}
function guid() {
  return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
    s4() + '-' + s4() + s4() + s4();
}
function s4() {
  return Math.floor((1 + Math.random()) * 0x10000)
    .toString(16)
    .substring(1);
}
function newUser() {
  id = guid();
  $(".guid").val(id);
  console.log(id);
}
function resetUser() {
  $.ajax({
    type: "POST",
    url: "php/unlink.php",
    data: {id:id},
    success: function (data) {console.log(data);}
  });
  $('.button1').toggleClass('disabled');
  $('.button2').toggleClass('disabled');
  $("#fileProfile").val('');
  $("#fileDash").val('');
  $("#uploadFormProfile .title").html("Choose system profile");
  $("#uploadFormDashboard .title").html("Choose dashboard archive");
  console.log('user has been reset');
  newUser();
}









function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}
function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
function checkCookie() {
  var check = getCookie("firsttimeprofile");
  if (check != "") {
  } else {
    setCookie("firsttimeprofile", "set", 365);
    $('.modal-cover').fadeToggle();
  }
}












function ToastBuilder(options) {
  var opts = options || {};
  opts.defaultText = opts.defaultText || 'default text';
  opts.displayTime = opts.displayTime || 3000;
  opts.target = opts.target || 'body';

  return function (text) {
    $('<div/>')
    .addClass('toast')
    .prependTo($(opts.target))
    .text(text || opts.defaultText)
    .queue(function(next) {
      $(this).css({
        'opacity': 1
      });
      var topOffset = 15;
      $('.toast').each(function() {
        var $this = $(this);
        var height = $this.outerHeight();
        var offset = 15;
        $this.css('top', topOffset + 'px');
        topOffset += height + offset;
      });
      next();
    })
    .delay(opts.displayTime)
    .queue(function(next) {
      var $this = $(this);
      var width = $this.outerWidth() + 20;
      $this.css({
        'right': '-' + width + 'px',
        'opacity': 0
      });
      next();
    })
    .delay(600)
    .queue(function(next) {
      $(this).remove();
      next();
    });
  };
}