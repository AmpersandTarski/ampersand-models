// JavaScript (c) by Bas Joosten 2009
// requires jQuer 1.3+

if (window!= top) top.location.href=location.href;
// bust out of frames

var compilenow=null;
var compileQueue=new Array();
function compile(op){
  if(compilenow==null){ //Previous compilations have exited without errors
     compilenow = $('#op'+op+' span');
     compilenow.html("compiling...");
     $.ajax($.ajaxSetup({url:"compile.php",type:"POST",dataType:'text',data:'op='+op,complete:recieveDataOnPost}));
  }else{
     $('#op'+op+' span').html="queued...";
     compileQueue[compileQueue.length]=op;
  }
}
function recieveDataOnPost(data,status){
  data = data.responseText;
  if(status=='error') data='error:Error retrieving compile.php';
  var splitdata = data.split('ok:',2);
  if(splitdata.length==2){ // data is saved, follow URL (to exit edit mode)
    compilenow.html(splitdata[1]);
    if(compileQueue.length){
      compilenow=null;
      compile(compileQueue.pop());
    }
  } else {
    splitdata = data.split('hold:',2);
    if(splitdata.length==2){
      $.ajax($.ajaxSetup({url:"compile.php",type:"POST",dataType:'text',data:splitdata[1],complete:recieveDataOnPost}));
    }else{
      splitdata = data.split('error:',2);
      if(splitdata.length==2){
         compilenow.html(splitdata[1]);
      }else{
         //compilenow.html("failed");    
	 compilenow.html(data);
         if(compileQueue.length){
           compilenow=null;
           compile(compileQueue.pop());
	 }
      }
      for(i=0;i<compileQueue.length;i++){
         $('#op'+compileQueue[i]+' span').html("aborted...");
      }
    }
  }
}
