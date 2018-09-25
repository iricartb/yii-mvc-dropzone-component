<?php 
require_once('protected/functions/FString.class.php');
require_once('protected/functions/FWidget.class.php');
?>

<!DOCTYPE html>
<html>
   <head>
      <!-- disable jquery include automation for Yii -->
      <?php Yii::app()->clientScript->scriptMap=array('jquery.js'=>false,'jquery.min.js'=>false,); ?>

      <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/components/dropzone/css/dropzone.css" />

      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/jquery.min.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/ajax.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/javascript/animations.js"></script>
      <script type="text/javascript" src="<?php echo Yii::app()->request->baseUrl; ?>/components/dropzone/javascript/dropzone.js"></script>
      <title>Dropzone</title>    
   </head>
   
   <body>
      <?php echo FWidget::showDropzone('headerSliderImages', 'HeaderSliderImages', FString::STRING_EMPTY, FString::STRING_EMPTY, $this, FWidget::DROPZONE_TYPE_IMAGE, array(), FString::STRING_EMPTY, 'width:290px;'); ?>
   </body>
</html>