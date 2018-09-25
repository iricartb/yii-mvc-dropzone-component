<?php

class CDropzoneActiveRecord extends CActiveRecord {
   protected $dropzoneImageElements = array('field_pk'=>FString::STRING_EMPTY, 'field_image'=>FString::STRING_EMPTY, 'path_images'=>FString::STRING_EMPTY, 'elements'=>array(), 'resize'=>array(), 'file_output'=>FFile::FILE_JPG_EXTENSION);
   
   public function deleteDropzoneImageElement($id) { }
   
   public function changeDropzoneImageElements($idSource, $idDestiny) { }
   
   public function isDropzoneAllowAccessRule() { return true; }
   
   public function getDropzoneImageOutputFormat() { return $this->dropzoneImageElements; }
}