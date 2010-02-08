// JavaScript (c) by Bas Joosten 2009
// requires jQuer 1.3+

if (window!= top) top.location.href=location.href;
// bust out of frames

var compilenow=null;
var compileQueue=new Array();
function compile(op){
    compileQueue[compileQueue.length]=op;
     var queue = $('#op'+op+' span');
     queue.html("queued...");
     compileNext(); 
}

function compileNext(){
     if(compilenow==null)
     {
        var op = compileQueue.pop();
	compilenow =  $('#op'+op+' span');
	compilenow.html("compiling...");
	$.ajax($.ajaxSetup({url:"compile.php",type:"POST",dataType:'text',data:'op='+op,complete:receiveDataOnPost}));
    }
}

function receiveDataOnPost(data,status){
  data = data.responseText;
  if(status=='error') {data='error:Error retrieving compile.php';}
//  var splitdata = data.split('hold:',2); //data.split('ok:',2);
//  if(splitdata.length==2){
//    $.ajax($.ajaxSetup({url:"compile.php",type:"POST",dataType:'text',data:splitdata[1],complete:testrecieveDataOnPost}));
//  }else{
    var splitdata = data.split('ok:',2);
    if(splitdata.length==2) data=splitdata[1];
    else {splitdata = data.split('error:',2);
          if(splitdata.length==2) data=splitdata[1];}
          //else -> data=="failed"  
    var datalines = data.split("\n");
    var htmlstr = '';
    for(i=0; i<datalines.length; i++){
	  var pat = /!Error of type/;
	  if (pat.test(datalines[i])) { htmlstr += '<p><b>'+datalines[i]+'</b></p>';} 
	  else {htmlstr += '<p>'+datalines[i]+'</p>';}
    }  
    compilenow.html(htmlstr);
    compilenow = null;
    compileNext();
}


