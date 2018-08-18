<?php
 error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE); date_default_timezone_set('Europe/London'); define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />'); require_once dirname(__FILE__) . '/../Classes/PHPExcel.php'; echo date('H:i:s') , " Create new PHPExcel object" , EOL; $objPHPExcel = new PHPExcel(); echo date('H:i:s') , " Set document properties" , EOL; $objPHPExcel->getProperties()->setCreator("Maarten Balliauw") ->setLastModifiedBy("Maarten Balliauw") ->setTitle("Office 2007 XLSX Test Document") ->setSubject("Office 2007 XLSX Test Document") ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.") ->setKeywords("office 2007 openxml php") ->setCategory("Test result file"); echo date('H:i:s') , " Add some data" , EOL; $objPHPExcel->getActiveSheet()->setCellValue('A5', 'Sum:'); $objPHPExcel->getActiveSheet()->setCellValue('B1', 'Range #1') ->setCellValue('B2', 3) ->setCellValue('B3', 7) ->setCellValue('B4', 13) ->setCellValue('B5', '=SUM(B2:B4)'); echo date('H:i:s') , " Sum of Range #1 is " , $objPHPExcel->getActiveSheet()->getCell('B5')->getCalculatedValue() , EOL; $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Range #2') ->setCellValue('C2', 5) ->setCellValue('C3', 11) ->setCellValue('C4', 17) ->setCellValue('C5', '=SUM(C2:C4)'); echo date('H:i:s') , " Sum of Range #2 is " , $objPHPExcel->getActiveSheet()->getCell('C5')->getCalculatedValue() , EOL; $objPHPExcel->getActiveSheet()->setCellValue('A7', 'Total of both ranges:'); $objPHPExcel->getActiveSheet()->setCellValue('B7', '=SUM(B5:C5)'); echo date('H:i:s') , " Sum of both Ranges is " , $objPHPExcel->getActiveSheet()->getCell('B7')->getCalculatedValue() , EOL; $objPHPExcel->getActiveSheet()->setCellValue('A8', 'Minimum of both ranges:'); $objPHPExcel->getActiveSheet()->setCellValue('B8', '=MIN(B2:C4)'); echo date('H:i:s') , " Minimum value in either Range is " , $objPHPExcel->getActiveSheet()->getCell('B8')->getCalculatedValue() , EOL; $objPHPExcel->getActiveSheet()->setCellValue('A9', 'Maximum of both ranges:'); $objPHPExcel->getActiveSheet()->setCellValue('B9', '=MAX(B2:C4)'); echo date('H:i:s') , " Maximum value in either Range is " , $objPHPExcel->getActiveSheet()->getCell('B9')->getCalculatedValue() , EOL; $objPHPExcel->getActiveSheet()->setCellValue('A10', 'Average of both ranges:'); $objPHPExcel->getActiveSheet()->setCellValue('B10', '=AVERAGE(B2:C4)'); echo date('H:i:s') , " Average value of both Ranges is " , $objPHPExcel->getActiveSheet()->getCell('B10')->getCalculatedValue() , EOL; echo date('H:i:s') , " Rename worksheet" , EOL; $objPHPExcel->getActiveSheet()->setTitle('Formulas'); $objPHPExcel->setActiveSheetIndex(0); echo date('H:i:s') , " Write to Excel2007 format" , EOL; $callStartTime = microtime(true); $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); $objWriter->save(str_replace('.php', '.xlsx', __FILE__)); $callEndTime = microtime(true); $callTime = $callEndTime - $callStartTime; echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL; echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL; echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL; echo date('H:i:s') , " Write to Excel5 format" , EOL; $callStartTime = microtime(true); $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); $objWriter->save(str_replace('.php', '.xls', __FILE__)); $callEndTime = microtime(true); $callTime = $callEndTime - $callStartTime; echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL; echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL; echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL; echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL; echo date('H:i:s') , " Done writing files" , EOL; echo 'Files have been created in ' , getcwd() , EOL; 