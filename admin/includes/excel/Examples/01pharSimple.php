<?php
 error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE); date_default_timezone_set('Europe/London'); define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />'); require_once '../Build/PHPExcel.phar'; echo date('H:i:s') , " Create new PHPExcel object" , EOL; $objPHPExcel = new PHPExcel(); echo date('H:i:s') , " Set document properties" , EOL; $objPHPExcel->getProperties()->setCreator("Maarten Balliauw") ->setLastModifiedBy("Maarten Balliauw") ->setTitle("PHPExcel Test Document") ->setSubject("PHPExcel Test Document") ->setDescription("Test document for PHPExcel, generated using PHP classes.") ->setKeywords("office PHPExcel php") ->setCategory("Test result file"); echo date('H:i:s') , " Add some data" , EOL; $objPHPExcel->setActiveSheetIndex(0) ->setCellValue('A1', 'Hello') ->setCellValue('B2', 'world!') ->setCellValue('C1', 'Hello') ->setCellValue('D2', 'world!'); $objPHPExcel->setActiveSheetIndex(0) ->setCellValue('A4', 'Miscellaneous glyphs') ->setCellValue('A5', 'éàèùâêîôûëïüÿäöüç'); echo date('H:i:s') , " Rename worksheet" , EOL; $objPHPExcel->getActiveSheet()->setTitle('Simple'); $objPHPExcel->setActiveSheetIndex(0); echo date('H:i:s') , " Write to Excel2007 format" , EOL; $callStartTime = microtime(true); $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); $objWriter->save(str_replace('.php', '.xlsx', __FILE__)); $callEndTime = microtime(true); $callTime = $callEndTime - $callStartTime; echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL; echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL; echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL; echo date('H:i:s') , " Write to Excel5 format" , EOL; $callStartTime = microtime(true); $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); $objWriter->save(str_replace('.php', '.xls', __FILE__)); $callEndTime = microtime(true); $callTime = $callEndTime - $callStartTime; echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL; echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL; echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL; echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL; echo date('H:i:s') , " Done writing files" , EOL; echo 'Files have been created in ' , getcwd() , EOL; 