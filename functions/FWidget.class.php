<?php    
require_once('protected/functions/FString.class.php');
  
class FWidget {
   const DROPZONE_TYPE_IMAGE = 'DROPZONE_TYPE_IMAGE';
      
   const DROPZONE_FOLDER_IMAGES = 'components/dropzone/images/';
   
   const MODEL_DROPZONE_ACTIVE_RECORD = 'CDropzoneActiveRecord';

   public static function showDropzone($sId, $sModel, $sParametersGetElements, $sParametersUploadElements, $oController, $sTypeDropzone = FWidget::DROPZONE_TYPE_IMAGE, $oAttachFields = array(), $sDropzoneStyle = FString::STRING_EMPTY, $sDropzoneElementStyle = FString::STRING_EMPTY) {
      if ($sDropzoneStyle != FString::STRING_EMPTY) $sDropzoneStyle = FString::STRING_SPACE . 'style="' . $sDropzoneStyle . '"';
      if ($sDropzoneElementStyle != FString::STRING_EMPTY) $sDropzoneElementStyle = FString::STRING_SPACE . 'style="' . $sDropzoneElementStyle . '"';
      
      $oDynamicModel = new $sModel;
      
      if ((is_subclass_of($oDynamicModel, FWidget::MODEL_DROPZONE_ACTIVE_RECORD)) && ($sTypeDropzone == FWidget::DROPZONE_TYPE_IMAGE)) {
         $sDropzoneBackgroundUrl = FWidget::DROPZONE_FOLDER_IMAGES . 'background.png';
      }
      else $sDropzoneBackgroundUrl = FString::STRING_EMPTY;
      
      $i = 1;      
      foreach($oAttachFields as $oAttachField) {
         if ($i != count($oAttachFields)) {
            $sAttachFields .= $oAttachField[0] . '@' . $oAttachField[1] . '@' . $oAttachField[2] . '@' . $oAttachField[3] . ','; 
         }
         else $sAttachFields .= $oAttachField[0] . '@' . $oAttachField[1] . '@' . $oAttachField[2] . '@' . $oAttachField[3]; 
         
         $i++;  
      }
      
      $sWidget = "<div id=\"dropzone_" . $sId . "\" class=\"dropzone\"" . $sDropzoneStyle . " style=\"background-image: url(" . $sDropzoneBackgroundUrl . ");\">
                     <div id=\"dropzone_elements_" . $sId . "\" class=\"dropzone_elements\">";
      
      if (is_subclass_of($oDynamicModel, FWidget::MODEL_DROPZONE_ACTIVE_RECORD)) {                  
         if ($sTypeDropzone == FWidget::DROPZONE_TYPE_IMAGE) {

            if ($sParametersGetElements != FString::STRING_EMPTY) $oElements = call_user_func_array(array($oDynamicModel, "getDropzoneImageElements"), explode(",", $sParametersGetElements));
            else $oElements = call_user_func_array(array($oDynamicModel, "getDropzoneImageElements"), array()); ?>
            
            <script type="text/javascript">
               $(document).ready(function($) {
                  aj('<?php echo $oController->createUrl('dropzone/getDropzoneImageElements&id=') . $sId . "&model=" . $sModel . "&style=" . $sDropzoneElementStyle . "&parameters=" . $sParametersGetElements . "&attachFields=" . $sAttachFields; ?>', null, '<?php echo 'dropzone_elements_' . $sId; ?>', null, null, null, 'TYPE_CONTENT_REPLACE', 'TYPE_DECORATION_NONE', 0, false, true);
               });
            </script>
            <?php
         }
      }
      
      $sWidget .= "</div>  
                </div>";
      
      if ((is_subclass_of($oDynamicModel, FWidget::MODEL_DROPZONE_ACTIVE_RECORD)) && ($sTypeDropzone == FWidget::DROPZONE_TYPE_IMAGE)) {
         $sWidget .= "<script type=\"text/javascript\">
                         function sendFileToServer" . $sId . "(formData) {
                            $.ajax({
                               url: '" . $oController->createUrl('dropzone/uploadDropzoneImageElement&model=') . $sModel . "&path=" . $oElements['path_images'] . "&parameters=" . $sParametersUploadElements . "',
                               type: 'POST',
                               contentType: false,
                               processData: false,
                               cache: false,
                               data: formData,
                               success: function(data) {
                                  aj('" . $oController->createUrl('dropzone/getDropzoneImageElements&id=') . $sId . "&model=" . $sModel . "&style=" . $sDropzoneElementStyle . "&parameters=" . $sParametersGetElements . "&attachFields=" . $sAttachFields . "', null, 'dropzone_elements_" . $sId . "', null, null, null, 'TYPE_CONTENT_REPLACE', 'TYPE_DECORATION_NONE', 0, false, true);   
                               }
                            });
                         }
                         
                         $(document).ready(function() {
                            var obj = $(\"#dropzone_" . $sId . "\");
                               
                            obj.on('dragover', function (e) {
                               e.stopPropagation();
                               e.preventDefault();
                            });
                            
                            obj.on('drop', function (e) { 
                               e.preventDefault();
                                   
                               var oFiles = e.originalEvent.dataTransfer.files; 
                          
                               for (var i = 0; i < oFiles.length; i++) {  
                                  var oFormData = new FormData();
                                  oFormData.append('file', oFiles[i]);

                                  sendFileToServer" . $sId . "(oFormData);
                               }
                            });
                         });   
                            
                         $(document).on('dragover', function (e) {
                            e.stopPropagation();
                            e.preventDefault();
                         });
                        
                         $(document).on('drop', function (e) {
                            e.stopPropagation();
                            e.preventDefault();
                         });
                      </script>";
      }
                       
      return $sWidget;   
   }              
}
?>