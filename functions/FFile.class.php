<?php      
class FFile {
   const FILE_JPG_EXTENSION = '.jpg';
   const FILE_JPEG_EXTENSION = '.jpeg';
   const FILE_BMP_EXTENSION = '.bmp';
   const FILE_PNG_EXTENSION = '.png';
   const FILE_GIF_EXTENSION = '.gif';
   const FILE_XML_EXTENSION = '.xml'; 
   const FILE_PDF_EXTENSION = '.pdf';
   const FILE_DOC_EXTENSION = '.doc';
   const FILE_DOCX_EXTENSION = '.docx';
   const FILE_PPT_EXTENSION = '.ppt';
   const FILE_PPTX_EXTENSION = '.pptx';
   const FILE_XLS_EXTENSION = '.xls';
   const FILE_XLSX_EXTENSION = '.xlsx';
   const FILE_TXT_EXTENSION = '.txt';
   const FILE_ZIP_EXTENSION = '.zip';
   const FILE_RAR_EXTENSION = '.rar';
   const FILE_EXE_EXTENSION = '.exe';
   const FILE_COM_EXTENSION = '.com';
   
   public static function isImageFromMimeType($sMimeType) {
      if (($sMimeType == 'image/bmp') || ($sMimeType == 'image/jpeg') || ($sMimeType == 'image/png') || ($sMimeType == 'image/gif') ||
         ($sMimeType == 'image/cgm') || ($sMimeType == 'image/cmu-raster') || ($sMimeType == 'image/g3fax') || ($sMimeType == 'image/ief') ||
         ($sMimeType == 'image/naplps') || ($sMimeType == 'image/targa') || ($sMimeType == 'image/tiff') || ($sMimeType == 'image/vnd.dwg') ||
         ($sMimeType == 'image/vnd.dxf') || ($sMimeType == 'image/vnd.fpx') || ($sMimeType == 'image/vnd.net.fpx') || ($sMimeType == 'image/vnd.svf') ||
         ($sMimeType == 'image/x-xbitmap') || ($sMimeType == 'image/x-cmu-raster') || ($sMimeType == 'image/x-pict') || ($sMimeType == 'image/x-portable-anymap') ||
         ($sMimeType == 'image/x-portable-bitmap') || ($sMimeType == 'image/x-portable-graymap') || ($sMimeType == 'image/x-portable-pixmap') || ($sMimeType == 'image/x-rgb') ||
         ($sMimeType == 'image/x-tiff') || ($sMimeType == 'image/x-win-bmp') || ($sMimeType == 'image/x-xbitmap') || ($sMimeType == 'image/x-xbm') ||
         ($sMimeType == 'image/x-xpixmap') || ($sMimeType == 'image/x-windowdump')) {
            return true;  
      }
      else return false;
   }
   
   public static function isCommonImageFromMimeType($sMimeType) {
      if (($sMimeType == 'image/bmp') || ($sMimeType == 'image/jpeg') || ($sMimeType == 'image/png') || ($sMimeType == 'image/gif')) return true;
      else return false;   
   }
   
   public static function resizeImageFile($sOriginalFileUrl, $sWidth, $sHeight, $sOutputFileUrl) {
      $oFileOutput = new imageLib($sOriginalFileUrl);
      $oFileOutput->resizeImage($sWidth, $sHeight);
      $oFileOutput->saveImage($sOutputFileUrl);
   }
   
   public static function saveImageFile($sOriginalFileUrl, $sOutputFileUrl) {
      $oFileOutput = new imageLib($sOriginalFileUrl);
      
      $oFileOutput->saveImage($sOutputFileUrl);
   }
   
   public static function moveFile($sFilename, $sOriginalFolder, $sDestinyFolder) {
      if (file_exists($sOriginalFolder . $sFilename) && file_exists($sDestinyFolder)) {
         rename($sOriginalFolder . $sFilename, $sDestinyFolder . $sFilename);
      }   
   }
   
   public static function getExtensionFromFileType($sFileType) { return '.' . strtolower($sFileType); } 
}
?>