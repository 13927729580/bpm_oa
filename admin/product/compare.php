<?php
 define('IN_DAEM', true); include '../includes/init.php'; include_once '../product/product.func.php'; $action = $_GET['action']; $checked = rtrim($_GET['checked'],','); $checked = str_replace('on,', '', $checked); if(empty($checked)) { foreach($_SESSION['productCompareId'] as $key=>$val) { $checked .= $key.","; } $checked = rtrim($checked,','); } if($action == 'productCompare' && !empty($checked)) { $checkedAry = array(); $queryStr = ''; $tmpAry = explode(',',$checked); foreach($tmpAry as $key=>$val) { $depthTmpAry = explode('_',$val); $checkedAry[$depthTmpAry['0']] = str_replace(';',',',$depthTmpAry['1']); $queryStr .= "'".$depthTmpAry['0']."',"; } $queryStr = trim($queryStr,','); $paramDefineAry = array(); $sql = "select * from catentryattr c left join attr a on a.attr_id = c.attr_id where c.catentry_id in (".$queryStr.")"; $query = $db2->query($sql); while($row = $db2->fetch_array($query)) { foreach($row as $key=>$val) { $row[$key] = iconv('gb2312','utf-8',$val); } if(!isset($paramDefineAry[$row['CATENTRY_ID']])) { $paramDefineAry[$row['ATTR_ID']] = $row['IDENTIFIER']; } } unset($paramDefineAry['193']); unset($paramDefineAry['194']); $productTmpInfoAry = array(); $sql = "select * from catentryattr c left join attr a on a.attr_id = c.attr_id left join attrval av on av.attrval_id = c.attrval_id where c.catentry_id in (".$queryStr.")"; $query = $db2->query($sql); while($row = $db2->fetch_array($query)) { foreach($row as $key=>$val) { $row[$key] = iconv('gb2312','utf-8',$val); } $productTmpInfoAry[$row['CATENTRY_ID']][$row['ATTR_ID']] = $row; } } elseif($action == 'productCompareAdd') { $checkedInfoAry = explode(',',$checked); foreach($checkedInfoAry as $val) { $_SESSION['productCompareId'][$val] = 1; } echo json_encode(array('1'=>'添加成功!'));die; } elseif($action == 'productCompareTrash') { unset($_SESSION['productCompareId']); echo json_encode(array('1'=>'清空成功!'));die; } elseif($action == 'removeCompareProduct') { $removeCompareProduct = $_GET['removeCompareProduct']; $reffer = $_SERVER['HTTP_REFERER']; $refferAry = explode('?',$reffer); $findParamSign = stristr($refferAry['1'],'action=productCompare&checked='); if(count($findParamSign)>0 && !empty($findParamSign)) { $refferParamStr = str_replace('action=productCompare&checked=','',$refferAry['1']); $refferParamAry = explode(',',$refferParamStr); $tmpCompareAry = array(); foreach($refferParamAry as $key=>$val) { $tmpCompareAry[urldecode($val)] = 1; } $refferParamAry = $tmpCompareAry; } else { $refferParamAry = ''; } if(!empty($refferParamAry) && count($refferParamAry) >0) { unset($refferParamAry[$removeCompareProduct]); $_SESSION['productCompareId'] = $refferParamAry; } else { unset($_SESSION['productCompareId'][$removeCompareProduct]); } gourl('','./compare.php?action=productCompare'); } include template(); 