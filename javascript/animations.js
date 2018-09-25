// simple animations
function jquery_animation_bgcolor(elements, r, g, b, a, duration) {
    $(elements).animate({backgroundColor: 'rgba(' + r + ',' + g + ',' + b + ',' + a + ')'}, duration);   
}

function jquery_animation_bordercolor(sElements, nRed, nGreen, nBlue, nAlpha, nDuration) {
   $(sElements).animate({borderColor: 'rgba(' + nRed + ',' + nGreen + ',' + nBlue + ',' + nAlpha + ')'}, nDuration);  
}

function jquery_animation_fade(elements, fade, duration) {
    $(elements).fadeTo(duration, fade); 
}

function jquery_animation_fade_appear(elements, fade, duration) {
    $(elements).hide().fadeTo(duration, fade);  
}                                                            

function jquery_animation_fade_appear_disappear_cell(elements, value, fade, duration) {
    $(elements).clearQueue();
    
    if (value == true) {
       if ($(elements).css('display') == 'none') {
          $(elements).hide().fadeTo(duration, fade, function onCompleteHandler() {
             $(elements).css('display', 'table-cell');   
          });
       }
    }
    else {
       if (($(elements).css('display') == 'block') || ($(elements).css('display') == 'table-cell'))  {
          $(elements).fadeTo(duration, 0.0, function onCompleteHandler() { 
             $(elements).css('display', 'none');
          });
       }
    }  
}
           
function jquery_animation_fade_appear_disappear_block(elements, value, fade, duration, uncheck) {
    $(elements).clearQueue();
    
    if (uncheck == undefined) uncheck = false;
    else uncheck = true;
    
    if (value == true) {
       if ((uncheck) || ($(elements).css('display') == 'none')) { 
          $(elements).hide().fadeTo(duration, fade, function onCompleteHandler() {
             $(elements).css('display', 'block');   
          });
       }
    }
    else {
       if ((uncheck) || ($(elements).css('display') == 'block'))  { 
          $(elements).fadeTo(duration, 0.0, function onCompleteHandler() { 
             $(elements).css('display', 'none');
          });
       }
    }  
}

function jquery_animation_expand_collapse(elements, speed) {
   speed = typeof speed !== 'undefined' ? speed : 'slow';
        
   $(elements).slideToggle(speed);  
}

// collection elements to apply any animation when occurs specific event
function jquery_animation_bgcolor_onmouseover(elements, all_elements, r_onmouseover, g_onmouseover, b_onmouseover, a_onmouseover, duration_onmouseover, r_onmouseout, g_onmouseout, b_onmouseout, a_onmouseout, duration_onmouseout) {
    $(elements).each(function() {
        $(this).mouseover(function() {
            if (all_elements) {
                $(elements).clearQueue();
                jquery_animation_bgcolor(elements, r_onmouseover, g_onmouseover, b_onmouseover, a_onmouseover, duration_onmouseover);
            }
            else {
                $(this).clearQueue();
                jquery_animation_bgcolor(this, r_onmouseover, g_onmouseover, b_onmouseover, a_onmouseover, duration_onmouseover);                
            }
        });
        
        $(this).mouseout(function() {
            if (all_elements) {
                $(elements).clearQueue();
                jquery_animation_bgcolor(elements, r_onmouseout, g_onmouseout, b_onmouseout, a_onmouseout, duration_onmouseout);
            } 
            else {
                $(this).clearQueue();
                jquery_animation_bgcolor(this, r_onmouseout, g_onmouseout, b_onmouseout, a_onmouseout, duration_onmouseout);                
            }
        });
    });    
}

function jquery_animation_fade_onmouseover(elements, fade, fadein, fadein_duration, fadeout, fadeout_duration) {
    $(elements).each(function() {
        $(this).fadeTo(0, fade);
 
        $(this).mouseover(function() {
            $(this).clearQueue();
            jquery_animation_fade(this, fadein, fadein_duration);
        });
        
        $(this).mouseout(function() {
            $(this).clearQueue();
            jquery_animation_fade(this, fadeout, fadeout_duration);
        });
    });    
}

function jquery_animation_fade_others_onmouseover(elements, fade, fadein, fadein_duration, fadeout, fadeout_duration) {
    $(elements).each(function() {
        $(this).fadeTo(0, fade);
        
        $(this).mouseover(function() {
            for (var i = 0; i < $(elements).length; i++) {
              element = $(elements)[i];
              $(element).clearQueue();
              if (element != this) jquery_animation_fade(element, fadein, fadein_duration);
              else jquery_animation_fade(element, fade, fadein_duration);
            }
        });
        
        $(this).mouseout(function() {
            for (var i = 0; i < $(elements).length; i++) {
              element = $(elements)[i];
              $(element).clearQueue(); 
              if (element != this) jquery_animation_fade(element, fadeout, fadeout_duration);
              else jquery_animation_fade(element, fade, fadeout_duration);
            }
        });
    });    
}

// onload events
function jquery_animation_bgcolor_onload(elements, r, g, b, a, duration) {
    $(document).ready(function() {
        jquery_animation_bgcolor(elements, r, g, b, a, duration);
    });   
}

function jquery_animation_fade_appear_onload(elements, fade, duration) {
    $(document).ready(function() {
        jquery_animation_fade_appear(elements, fade, duration)    
    });    
}

function jquery_animation_fade_onmouseover_onload(elements, fade, fadein, fadein_duration, fadeout, fadeout_duration) {
    $(document).ready(function() {
        jquery_animation_fade_onmouseover(elements, fade, fadein, fadein_duration, fadeout, fadeout_duration);
    });
}

function jquery_animation_fade_onmouseover_others_onload(elements, fade, fadein, fadein_duration, fadeout, fadeout_duration) {
    $(document).ready(function() {
        jquery_animation_fade_others_onmouseover(elements, fade, fadein, fadein_duration, fadeout, fadeout_duration);
    });
}

function jquery_animation_bgcolor_onmouseover_onload(elements, all_elements, r_onmouseover, g_onmouseover, b_onmouseover, a_onmouseover, duration_onmouseover, r_onmouseout, g_onmouseout, b_onmouseout, a_onmouseout, duration_onmouseout) {
    $(document).ready(function() {
        jquery_animation_bgcolor_onmouseover(elements, all_elements, r_onmouseover, g_onmouseover, b_onmouseover, a_onmouseover, duration_onmouseover, r_onmouseout, g_onmouseout, b_onmouseout, a_onmouseout, duration_onmouseout);
    });    
}

function jquery_animation_bgcolor_onload(elements, r, g, b, a, duration) {
    $(document).ready(function() {
        jquery_animation_bgcolor(elements, r, g, b, a, duration);
    });    
}

function jquery_animation_change_all_content_onload(url, data, idlayer, type_decoration, duration) {
    $(window).load(function() {
        aj(url, data, idlayer, null, null, null, 'TYPE_CONTENT_REPLACE_ALL', type_decoration, duration, true, false);  
    });
}