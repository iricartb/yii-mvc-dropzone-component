<?php
require_once('protected/functions/FFile.class.php');
require_once('protected/functions/FString.class.php');
require_once('protected/functions/FWidget.class.php');

class DropzoneController extends Controller {
   
   public function actionChangeDropzoneImageElements($model, $parameter1, $parameter2) {
      $oDynamicModel = new $model;
      
      $bDropzoneAccessRule = $oDynamicModel->isDropzoneAllowAccessRule();
      
      if ($bDropzoneAccessRule) call_user_func_array(array($oDynamicModel, "changeDropzoneImageElements"), array($parameter1, $parameter2));   
   }
   
   public function actionChangeDropzoneFieldValue($model, $parameter, $field, $value) {
      $oDynamicModel = new $model;
      
      $bDropzoneAccessRule = $oDynamicModel->isDropzoneAllowAccessRule();
      
      if ($bDropzoneAccessRule) call_user_func_array(array($oDynamicModel, "changeDropzoneFieldValue"), array($parameter, $field, str_replace('%amp', '&', $value)));  
   } 
   
   public function actionDeleteDropzoneImageElement($model, $parameter) {
      $oDynamicModel = new $model;
      
      $bDropzoneAccessRule = $oDynamicModel->isDropzoneAllowAccessRule();
      
      if ($bDropzoneAccessRule) call_user_func_array(array($oDynamicModel, "deleteDropzoneImageElement"), array($parameter));   
   }
   
   public function actionUploadDropzoneImageElement($model, $path, $parameters) {
      $oDynamicModel = new $model;
      
      $bDropzoneAccessRule = $oDynamicModel->isDropzoneAllowAccessRule();
      
      if ($bDropzoneAccessRule) {
         $oFile = CUploadedFile::getInstanceByName('file');
         if ($oFile) { 
            $sOriginalFilename = sha1_file($oFile->tempName);
            $sOriginalFileExtension = '.' . strtolower($oFile->extensionName);
            $sOriginalFile = $sOriginalFilename . $sOriginalFileExtension;
            
            $sOriginalFileUrl = $path . $sOriginalFile;

            if ((FFile::isCommonImageFromMimeType($oFile->type)) && ($oFile->saveAs($sOriginalFileUrl))) {
               $oDropzoneOutputFormat = $oDynamicModel->getDropzoneImageOutputFormat();
               
               $sOutputFileExtension = $oDropzoneOutputFormat['file_output'];
               if (is_null($sOutputFileExtension)) {
                  $sOutputFile = $sOriginalFilename . $sOriginalFileExtension;      
               }
               else $sOutputFile = $sOriginalFilename . $sOutputFileExtension;
               
               $oDropzoneOutputSize = $oDropzoneOutputFormat['resize'];
               if (count($oDropzoneOutputSize) == 2) {
                  FFile::resizeImageFile($sOriginalFileUrl, $oDropzoneOutputSize[0], $oDropzoneOutputSize[1], $path . $sOutputFile);
               }
               else {
                  if (!is_null($sOutputFileExtension)) {
                     FFile::saveImageFile($sOriginalFileUrl, $path . $sOutputFile);
                   
                     if ($sOriginalFileExtension != $sOutputFileExtension) unlink($sOriginalFileUrl);
                  }
               }
               
               if (strlen($parameters) > 0) $parameters = $sOutputFile . ',' . $parameters;
               else $parameters = $sOutputFile;
                       
               call_user_func_array(array($oDynamicModel, "uploadDropzoneImageElement"), explode(",", $parameters));   
            }
         }
      }
   }
   
   public function actionGetDropzoneImageElements($id, $model, $style, $parameters, $attachFields) {
      $this->layout = null;
      $sElements = FString::STRING_EMPTY;
      
      $oDynamicModel = new $model; 
      
      $bDropzoneAccessRule = $oDynamicModel->isDropzoneAllowAccessRule();
      
      if ($bDropzoneAccessRule) {
         if (strlen($parameters > 0)) $oElements = call_user_func_array(array($oDynamicModel, "getDropzoneImageElements"), explode(",", $parameters));
         else $oElements = call_user_func_array(array($oDynamicModel, "getDropzoneImageElements"), array());
         
         foreach ($oElements['elements'] as $oElement) { 
            $sElements .= "<div id=\"dropzone_element_" . $id . "\" class=\"dropzone_element_" . $id . " column_draggable_" . $id ."\" onmouseover=\"jquery_animation_fade_onmouseover_others_onload('.dropzone_element_" . $id . "', 1.0, 0.4, 1000, 1.0, 1000);\" style=\"float:left; cursor:pointer;\">
                              <div id=\"dropzone_element_" . $id . '_' . eval('return $oElement->' . $oElements['field_pk'] . ';') . "\" class=\"dropzone_element\">
                                 <img src=\"" . FWidget::DROPZONE_FOLDER_IMAGES . "delete.png\" class=\"remove\" onclick=\"aj('" . $this->createUrl('dropzone/deleteDropzoneImageElement&model=') . $model . '&parameter=' . eval('return $oElement->' . $oElements['field_pk'] . ';') . "', null, 'dropzone_element_" . $id . '_' . eval('return $oElement->' . $oElements['field_pk'] . ';') . "', null, '" . Yii::t('system', 'SYS_DELETE_IMAGE_CONFIRMATION') . "', 'dropzone_remove_element(\'#dropzone_element_" . $id . '_' . eval('return $oElement->' . $oElements['field_pk'] . ';') . "\'); dropzone_remove_element(\'#dropzone_element_fields_" . $id . '_' . eval('return $oElement->' . $oElements['field_pk'] . ';') . "\');', 'TYPE_CONTENT_REPLACE_NONE', 'TYPE_DECORATION_NONE', 0, false, true);\">
                                 <img src=\"" . $oElements['path_images'] . eval('return $oElement->' . $oElements['field_image'] . ';') . "\"" . $style . ">
                              </div>";
            
            if (strlen($attachFields) > 0) {
               $sElements .= "<div id=\"dropzone_element_fields_" . $id . '_' . eval('return $oElement->' . $oElements['field_pk'] . ';') . "\" class=\"dropzone_element_fields\">";
               
               $oArrayAttachFields = explode(',', $attachFields);
               foreach($oArrayAttachFields as $oArrayAttachField) {
                  $oArrayAttachFieldParameters = explode('@', $oArrayAttachField);

                  $sElements .= "<div id=\"dropzone_element_field_" . eval('return $oElement->' . $oElements['field_pk'] . ';') . "\" class=\"dropzone_element_field\">";
               
                  $sElements .= "<div id=\"dropzone_element_field_name_" . eval('return $oElement->' . $oElements['field_pk'] . ';') . "\" class=\"dropzone_element_field_name\">";
                  $sElements .= $oArrayAttachFieldParameters[2]; 
                  $sElements .= "</div>"; 
                  
                  $sElements .= "<div id=\"dropzone_element_field_value_" . eval('return $oElement->' . $oElements['field_pk'] . ';') . "\" class=\"dropzone_element_field_value\">";
                  if (($oArrayAttachFieldParameters[1] != 'date') && ($oArrayAttachFieldParameters[1] != 'datetime')) {
                     $sElements .= "<input type=\"text\" value=\"" . eval('return $oElement->' . $oArrayAttachFieldParameters[0] . ';') . "\" style=\"". $oArrayAttachFieldParameters[3] . "\" onchange=\"aj('" . $this->createUrl('dropzone/changeDropzoneFieldValue&model=') . $model . '&parameter=' . eval('return $oElement->' . $oElements['field_pk'] . ';') . '&field=' . $oArrayAttachFieldParameters[0] . '&value=' . "'" . '+ this.value.replace(/&/g, \'%amp\')' . ", null, 'dropzone_element_" . $id . '_' . eval('return $oElement->' . $oElements['field_pk'] . ';') . "', null, null, null, 'TYPE_CONTENT_REPLACE_NONE', 'TYPE_DECORATION_NONE', 0, false, true);\">";      
                  }                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                             
                  else {
                     
                  }
                  $sElements .= "</div>"; 
                  
                  $sElements .= "</div>";  
               }
               
               $sElements .= '</div>';      
            }
              
            $sElements .= "</div>";                                   
         }
         
         $sElements .= "<script type=\"text/javascript\">
                          $(document).ready(function() {
                             var columns = $(\".column_draggable_" . $id . "\");

                             [].forEach.call(columns, function(column) {
                                column.addEventListener('dragstart', handleDragStart_" . $id . ", false);
                                column.addEventListener('drop', handleDrop_" . $id . ", false);
                             });
                          });
                          
                          var widgetDragStart = null;
                          
                          function handleDragStart_" . $id . "(e) {
                             widgetDragStart = '" . $id . "'; 
                             
                             e.dataTransfer.effectAllowed = 'move';
                             e.dataTransfer.setData('text/html', this.innerHTML);
                          }

                          function handleDrop_" . $id . "(e) {
                             if (widgetDragStart == '" . $id . "') {
                                var nSubstringDestinyStart = this.innerHTML.indexOf('dropzone_element_') + " . (18 + strlen($id)) . ";
                                var nSubstringDestinyEnd = this.innerHTML.substring(nSubstringDestinyStart).indexOf('\"');
                                
                                var sInnerHtmlSource = e.dataTransfer.getData('text/html');
                                var nSubstringSourceStart = sInnerHtmlSource.indexOf('dropzone_element_') + " . (18 + strlen($id)) . ";
                                var nSubstringSourceEnd = sInnerHtmlSource.substring(nSubstringSourceStart).indexOf('\"'); 
             
                                var nSource = sInnerHtmlSource.substring(nSubstringSourceStart, nSubstringSourceStart + nSubstringSourceEnd);
                                var nDestiny = this.innerHTML.substring(nSubstringDestinyStart, nSubstringDestinyStart + nSubstringDestinyEnd);
   
                                if (nSource != nDestiny) {    
                                   aj('" . $this->createUrl('dropzone/changeDropzoneImageElements&model=') . $model . '&parameter1=\'' . " + nSource + '&parameter2=' + nDestiny, null, null, null, null, null, 'TYPE_CONTENT_REPLACE_NONE', 'TYPE_DECORATION_NONE', 0, false, false);
                                   aj('" . $this->createUrl('dropzone/getDropzoneImageElements&id=') . $id . '&model=' . $model . '&style=' . $style . '&parameters=' . $parameters . '&attachFields=' . $attachFields . "', null, 'dropzone_elements_" . $id . "', null, null, null, 'TYPE_CONTENT_REPLACE', 'TYPE_DECORATION_NONE', 0, false, true);
                                }
                             } 
                             
                             widgetDragStart = null;   
                          }
                      </script>";
                            
         $this->renderText($sElements); 
      }      
   }
}