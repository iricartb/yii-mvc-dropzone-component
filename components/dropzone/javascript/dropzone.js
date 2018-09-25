function dropzone_remove_element(elements) {
   $(elements).fadeOut('fast', function() { $(elements).remove(); });   
}