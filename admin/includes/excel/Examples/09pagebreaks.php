<?php
 error_reporting(E_ALL); ini_set('display_errors', TRUE); ini_set('display_startup_errors', TRUE); define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />'); date_default_timezone_set('Europe/London'); require_once dirname(__FILE__) . '/../Classes/PHPExcel.php'; echo date('H:i:s') , " Create new PHPExcel object" , EOL; $objPHPExcel = new PHPExcel(); echo date('H:i:s') , " Set document properties" , EOL; $objPHPExcel->getProperties()->setCreator("Maarten Balliauw") ->setLastModifiedBy("Maarten Balliauw") ->setTitle("Office 2007 XLSX Test Document") ->setSubject("Office 2007 XLSX Test Document") ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.") ->setKeywords("office 2007 openxml php") ->setCategory("Test result file"); echo date('H:i:s') , " Add data and page breaks" , EOL; $objPHPExcel->setActiveSheetIndex(0); $objPHPExcel->getActiveSheet()->setCellValue('A1', "Firstname") ->setCellValue('B1', "Lastname") ->setCellValue('C1', "Phone") ->setCellValue('D1', "Fax") ->setCellValue('E1', "Is Client ?"); for ($i = 2; $i <= 50; $i++) { $objPHPExcel->getActiveSheet()->setCellValue('A' . $i, "FName $i"); $objPHPExcel->getActiveSheet()->setCellValue('B' . $i, "LName $i"); $objPHPExcel->getActiveSheet()->setCellValue('C' . $i, "PhoneNo $i"); $objPHPExcel->getActiveSheet()->setCellValue('D' . $i, "FaxNo $i"); $objPHPExcel->getActiveSheet()->setCellValue('E' . $i, true); if ($i % 10 == 0) { $objPHPExcel->getActiveSheet()->setBreak( 'A' . $i, PHPExcel_Worksheet::BREAK_ROW ); } } $objPHPExcel->setActiveSheetIndex(0); $objPHPExcel->getActiveSheet()->setTitle('Printing Options'); $objPHPExcel->getActiveSheet() ->getHeaderFooter()->setOddHeader('&C&24&K0000FF&B&U&A'); $objPHPExcel->getActiveSheet() ->getHeaderFooter()->setEvenHeader('&C&24&K0000FF&B&U&A'); $objPHPExcel->getActiveSheet() ->getHeaderFooter()->setOddFooter('&R&D &T&C&F&LPage &P / &N'); $objPHPExcel->getActiveSheet() ->getHeaderFooter()->setEvenFooter('&L&D &T&C&F&RPage &P / &N'); echo date('H:i:s') , " Write to Excel2007 format" , EOL; $callStartTime = microtime(true); $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007'); $objWriter->save(str_replace('.php', '.xlsx', __FILE__)); $callEndTime = microtime(true); $callTime = $callEndTime - $callStartTime; echo date('H:i:s') , " File written to " , str_replace('.php', '.xlsx', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL; echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL; echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL; echo date('H:i:s') , " Write to Excel5 format" , EOL; $callStartTime = microtime(true); $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5'); $objWriter->save(str_replace('.php', '.xls', __FILE__)); $callEndTime = microtime(true); $callTime = $callEndTime - $callStartTime; echo date('H:i:s') , " File written to " , str_replace('.php', '.xls', pathinfo(__FILE__, PATHINFO_BASENAME)) , EOL; echo 'Call time to write Workbook was ' , sprintf('%.4f',$callTime) , " seconds" , EOL; echo date('H:i:s') , ' Current memory usage: ' , (memory_get_usage(true) / 1024 / 1024) , " MB" , EOL; echo date('H:i:s') , " Peak memory usage: " , (memory_get_peak_usage(true) / 1024 / 1024) , " MB" , EOL; echo date('H:i:s') , " Done writing files" , EOL; echo 'Files have been created in ' , getcwd() , EOL; 