function aj(url, data, idSourceLayer, idFilterDataLayer, opBeforeAction, opAfterAction, opTypeMethodContent, opTypeDecoration, opDuration, opProcessData, asynchronous) { 
   var beforeActionOK;
   var layer;
   
   beforeActionOK = true;
   if (opProcessData != true) opProcessData = false;   
   
   if (asynchronous == null) asynchronous = true;
   
   if ((opBeforeAction != null) && (opBeforeAction.length > 0) && (opBeforeAction.toLowerCase() != 'null')) beforeActionOK = confirm(opBeforeAction);   
   if ((opAfterAction == null) || ((opAfterAction != null) && (opAfterAction.toLowerCase() == 'null'))) opAfterAction = '';

   if ((opTypeMethodContent != 'TYPE_CONTENT_REPLACE') && (opTypeMethodContent != 'TYPE_CONTENT_APPEND_TOP') && (opTypeMethodContent != 'TYPE_CONTENT_APPEND_LOWER') && (opTypeMethodContent != 'TYPE_CONTENT_REPLACE_ALL') && (opTypeMethodContent != 'TYPE_CONTENT_REPLACE_NONE')) opTypeMethodContent = 'TYPE_CONTENT_REPLACE';
   
   if ((opTypeDecoration == null) || ((opTypeDecoration != null) && (opTypeDecoration.toLowerCase() != 'null') && (opTypeDecoration != 'TYPE_DECORATION_NONE') && (opTypeDecoration != 'TYPE_DECORATION_ROLL'))) opTypeDecoration = 'TYPE_DECORATION_FADE';
   else if (opTypeDecoration.toLowerCase() == 'null') opTypeDecoration = 'TYPE_DECORATION_NONE';
   
   if (idSourceLayer == null) { layer = 'html'; }
   else { layer = '#' + idSourceLayer; }
   
   if (beforeActionOK) {
      if (opTypeDecoration != 'TYPE_DECORATION_NONE') {
         if (opTypeDecoration == 'TYPE_DECORATION_FADE') {      
            $(layer).animate({
               opacity: 0.0
            }, opDuration, function onCompleteHandler() {
               _ajSync(url, data, idSourceLayer, idFilterDataLayer, opAfterAction, opTypeMethodContent, opProcessData);
               $(layer).animate({ opacity: 1.0 }, opDuration);
            });
         }
         else if (opTypeDecoration == 'TYPE_DECORATION_ROLL') {
            var origHeightLayer = $(layer).height();
                       
            $(layer).animate({
               opacity: 0.0,    
               height: 0.0
            }, opDuration, function onCompleteHandler() {
               _ajSync(url, data, idSourceLayer, idFilterDataLayer, opAfterAction, opTypeMethodContent, opProcessData);

               if (opTypeMethodContent == 'TYPE_CONTENT_REPLACE_ALL') {
                  origHeightLayer = '100%';
                  $(layer).css({ opacity: 0.0 });
                  $(layer).css({ height: 0.0 });
               }
               else if ($(layer).height() > origHeightLayer) origHeightLayer = $(layer).height();
                              
               $(layer).animate({ opacity: 1.0, height: origHeightLayer }, opDuration, function onCompleteHandler() {
                  $(layer).css({ height: origHeightLayer });   
               });
            });
         }
      }
      else { 
         if (asynchronous) _ajAsync(url, data, idSourceLayer, idFilterDataLayer, opAfterAction, opTypeMethodContent, opProcessData);
         else _ajSync(url, data, idSourceLayer, idFilterDataLayer, opAfterAction, opTypeMethodContent, opProcessData);
      }
   }
}

function _ajAsync(url, data, idSourceLayer, idFilterDataLayer, afterAction, typeMethodContent, processData) {
   _ajCall(url, data, idSourceLayer, idFilterDataLayer, afterAction, typeMethodContent, processData, true);
}

function _ajSync(url, data, idSourceLayer, idFilterDataLayer, afterAction, typeMethodContent, processData) {
   _ajCall(url, data, idSourceLayer, idFilterDataLayer, afterAction, typeMethodContent, processData, false);
}

function _ajCall(url, data, idSourceLayer, idFilterDataLayer, afterAction, typeMethodContent, processData, asynchronous) {
   $("#aj_loading").show();
   
   $.ajax({
      url: url,
      data: data,          
      type: "POST", 
      cache: false,
      processData: processData,
      async: asynchronous,

      success: function(data) { 
         $("#aj_loading").hide();  
         if (data.search('<div id="aj:error" />') == -1) {
            if (data.search('<div id="aj:success_onlyAfterAction" />') == -1) {
               var sdata;
                 
               if ((idFilterDataLayer != null) && (typeMethodContent != 'TYPE_CONTENT_REPLACE_ALL')) {
                  sdata = $(data).filter('#' + idFilterDataLayer).html(); 
               } 
               else sdata = data;
                       
               if (typeMethodContent == 'TYPE_CONTENT_REPLACE_ALL') { 
                   var sdata_head = data.replace('<head', '<head><div id="head"').replace('</head>','</div></head>');
                   var nHeadStartContent = sdata_head.indexOf('>', sdata_head.indexOf('<div id="head"')) + 1;
                   var nHeadEndContent = sdata_head.indexOf('</div></head>') - 1;
                                               
                   var sdata_body = data.replace('<body', '<body><div id="body"').replace('</body>','</div></body>');
                   var nBodyStartContent = sdata_body.indexOf('>', sdata_body.indexOf('<div id="body"')) + 1;
                   var nBodyEndContent = sdata_body.indexOf('</div></body>') - 1;
                                  
                   $('head').html(sdata_head.substring(nHeadStartContent, nHeadEndContent));   
                   $('body').html(sdata_body.substring(nBodyStartContent, nBodyEndContent));     
               }
               else if (typeMethodContent == 'TYPE_CONTENT_REPLACE') { $('#' + idSourceLayer).html(sdata); }
               else if (typeMethodContent == 'TYPE_CONTENT_APPEND_TOP') $('#' + idSourceLayer).prepend(sdata);
               else if (typeMethodContent == 'TYPE_CONTENT_APPEND_LOWER') $('#' + idSourceLayer).append(sdata);

               if (data.search('<div id="aj:error_disableAfterAction" />') == -1) eval(afterAction);
            }
            else eval(afterAction);
         }
      },
      error: function(xhr, ajaxOptions, thrownError) {
         $("#aj_loading").hide();  
         // alert('<aj:error> call _ajCall function. Err Number ' + xhr.status + ': ' + xhr.responseText);
      }
   });
}