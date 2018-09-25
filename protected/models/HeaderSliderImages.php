<?php

/**
 * This is the model class for table "header_slider_images".
 *
 * The followings are the available columns in table 'header_slider_images':
 * @property integer $id
 * @property string $image
 * @property integer $position
 */
class HeaderSliderImages extends CDropzoneActiveRecord {
   
   /**
    * Returns the static model of the specified AR class.
    * @param string $className active record class name.
    * @return HeaderSliderImages the static model class
    */
   public static function model($className=__CLASS__) {
      return parent::model($className);
   }

   /**
    * @return CDbConnection database connection
    */
   public function getDbConnection() {
      return Yii::app()->db_site;
   }

   /**
    * @return string the associated database table name
    */
   public function tableName() {
      return 'header_slider_images';
   }

   /**
    * @return array validation rules for model attributes.
    */
   public function rules() {
      // NOTE: you should only define rules for those attributes that
      // will receive user inputs.
      return array(
         array('image, position', 'required'),
         array('position', 'numerical', 'integerOnly'=>true),
         array('image', 'length', 'max'=>45),
         
         // The following rule is used by search().
         // Please remove those attributes that should not be searched.
         array('id, image, position', 'safe', 'on'=>'search'),
      );
   }

   /**
    * @return array relational rules.
    */
   public function relations() {
      // NOTE: you may need to adjust the relation name and the related
      // class name for the relations automatically generated below.
      return array();
   }

   /**
    * @return array customized attribute labels (name=>label)
    */
   public function attributeLabels() {
      return array(
         'id'=>'ID',
         'image'=>'Image',
         'position'=>'Position',
      );
   }

   /**
    * Retrieves a list of models based on the current search/filter conditions.
    * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
    */
   public function search() {
      // Warning: Please modify the following code to remove attributes that
      // should not be searched.

      $criteria = new CDbCriteria;

      $criteria->compare('id', $this->id);
      $criteria->compare('image', $this->image, true);
      $criteria->compare('position', $this->position);

      return new CActiveDataProvider($this, array(
         'criteria'=>$criteria,
      ));
   }
   
   public static function getHeaderSliderImage($nId) {
      return HeaderSliderImages::model()->find('id = ' . $nId);   
   }
   
   public static function getHeaderSliderImages() {
      return HeaderSliderImages::model()->findAll(array('order'=>'position ASC'));   
   }
   
   public static function getHeaderSliderImagesByPositions($nPositionMin, $nPositionMax) {
      return HeaderSliderImages::model()->findAll('position >= ' . $nPositionMin . ' AND position <= ' . $nPositionMax . ' ORDER BY position ASC');   
   }
   
   public static function getLastHeaderSliderImages() {
      return HeaderSliderImages::model()->find('true ORDER BY position DESC');   
   }
   
   /* Dropzone methods */
   public function isDropzoneAllowAccessRule() {
      //return ((Users::getIsMaster(Yii::app()->user->id)) || (Users::getIsAdmin(Yii::app()->user->id)) || (Users::getIsRestrictedUser(Yii::app()->user->id)) || (Users::getIsRestrictedUserLimited(Yii::app()->user->id)));
      return true;
   }
   
   public function getDropzoneImageElements() {
      $this->dropzoneImageElements['field_pk'] = 'id';
      $this->dropzoneImageElements['field_image'] = 'image';
      $this->dropzoneImageElements['path_images'] = FApplication::FOLDER_IMAGES_APPLICATION_SITE . 'header_slider/';
      $this->dropzoneImageElements['elements'] = HeaderSliderImages::model()->findAll('image IS NOT NULL ORDER BY position ASC');
      
      return $this->dropzoneImageElements; 
   }
   
   public function getDropzoneImageOutputFormat() {
      $this->dropzoneImageElements['file_output'] = FFile::FILE_JPG_EXTENSION;

      return $this->dropzoneImageElements;
   }
   
   public function changeDropzoneImageElements($idSource, $idDestiny) {
      $oHeaderSliderImageSource = HeaderSliderImages::getHeaderSliderImage($idSource);
      $oHeaderSliderImageDestiny = HeaderSliderImages::getHeaderSliderImage($idDestiny);
      
       if ((!is_null($oHeaderSliderImageSource)) && (!is_null($oHeaderSliderImageDestiny))) {
          if ($oHeaderSliderImageSource->position <= $oHeaderSliderImageDestiny->position) {
             $oHeaderSliderImagesToChange = $this->getHeaderSliderImagesByPositions($oHeaderSliderImageSource->position, $oHeaderSliderImageDestiny->position);
             
             foreach($oHeaderSliderImagesToChange as $oHeaderSliderImageToChange) {
                $oHeaderSliderImageToChange->position = $oHeaderSliderImageToChange->position - 1;
                $oHeaderSliderImageToChange->save();
             } 
             
             $oHeaderSliderImageSource->position = $oHeaderSliderImageDestiny->position;
             $oHeaderSliderImageSource->save();
          }
          else {
             $oHeaderSliderImagesToChange = $this->getHeaderSliderImagesByPositions($oHeaderSliderImageDestiny->position, $oHeaderSliderImageSource->position);
             
             foreach($oHeaderSliderImagesToChange as $oHeaderSliderImageToChange) {
                $oHeaderSliderImageToChange->position = $oHeaderSliderImageToChange->position + 1;
                $oHeaderSliderImageToChange->save();
             } 
             
             $oHeaderSliderImageSource->position = $oHeaderSliderImageDestiny->position;
             $oHeaderSliderImageSource->save();   
          }
       }     
   }
   
   public function changeDropzoneFieldValue($id, $field, $value) { } 
   
   public function deleteDropzoneImageElement($id) {
      $oHeaderSliderImage = HeaderSliderImages::getHeaderSliderImage($id);
      
      if (!is_null($oHeaderSliderImage)) $oHeaderSliderImage->delete();    
   }
   
   public function uploadDropzoneImageElement($sFilename) {
      $oHeaderSliderImage = new HeaderSliderImages();
                                              
      $oHeaderSliderImage->image = $sFilename;
      
      $oLastHeaderSliderImage = HeaderSliderImages::getLastHeaderSliderImages();
      if (!is_null($oLastHeaderSliderImage)) $oHeaderSliderImage->position = ($oLastHeaderSliderImage->position + 1); 
      else $oHeaderSliderImage->position = 1;
      
      $oHeaderSliderImage->save(); 
   }
}