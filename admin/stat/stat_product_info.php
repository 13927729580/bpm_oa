<?php
 define('IN_DAEM', true); include_once '../includes/init.php'; $countCatgroupIdAry = array(); $sql = "select B.catgroup_id,count(*) as COUNTNUM from xcatentry A,CATGPENREL B where A.catentry_id = B.catentry_id   group by B.catgroup_id"; $query = $db2->query($sql); while($row = $db2->fetch_array($query)) { foreach($row as $key=>$val) { $row[$key] = iconv('gb2312','utf-8',$val); } $countCatgroupIdAry[$row['CATGROUP_ID']] = $row['COUNTNUM']; } $depth0Ary = $depth1Ary = $depth2Ary = array(); $sql = "select * from db_menu where m_id IN
          (select distinct m_parentid FROM db_menu
          where m_id IN
            (select distinct m_parentid from db_menu where m_url = 'product/catalog.php' and level = '2')
          and level = '1')"; $query = $db->query($sql); while($row = $db->fetch_array($query)) { $depth0Ary[$row['m_id']] = $row['m_name']; } $userPerModuleAry = get_permission_infinite_classify_sort_by_mid(''); foreach($userPerModuleAry as $key=>$val) { if(!isset($depth0Ary[$key])) { unset($userPerModuleAry[$key]); } } foreach($userPerModuleAry as $k=>$v) { foreach($v['list'] as $kk=>$vv) { foreach($vv['list'] as $kkk=>$vvv) { $cond = ''; $checkRes = stristr($vvv['m_url'],'product/catalog.php?CATGROUP_ID_PARENT='); if(count($checkRes)>0 && !empty($checkRes)) { $CATGROUP_ID_PARENT = str_replace('product/catalog.php?CATGROUP_ID_PARENT=','',$vvv['m_url']); $cond = " and PC.IDENTIFIER = '".$CATGROUP_ID_PARENT."'"; } $catalogGBK = iconv('utf-8','gb2312', $vvv['m_name']); $sql = "SELECT CC.identifier CHILD_IDENTIFIER,A.NAME,A.CATGROUP_ID_PARENT,A.CATGROUP_ID,A.PARENTNAME,PC.IDENTIFIER PARENT_IDENTIFIER FROM (
                    SELECT CHILD.CATGROUP_ID,CHILD.NAME,CATGRPREL.CATGROUP_ID_PARENT,PARENT.NAME AS PARENTNAME, LEVEL
                    FROM CATGRPREL
                    LEFT JOIN CATGRPDESC CHILD ON ( CHILD.CATGROUP_ID=CATGRPREL.CATGROUP_ID_CHILD AND CHILD.LANGUAGE_ID=-7)
                    LEFT JOIN CATGRPDESC PARENT ON ( PARENT.CATGROUP_ID=CATGRPREL.CATGROUP_ID_PARENT AND PARENT.LANGUAGE_ID=-7)
                    START WITH CATGROUP_ID_PARENT IN (SELECT CATGROUP_ID FROM CATTOGRP)
                    CONNECT BY PRIOR CATGROUP_ID_CHILD = CATGROUP_ID_PARENT ORDER BY LEVEL ASC,CATGRPREL.CATGROUP_ID_PARENT DESC
                    )A
                    LEFT JOIN CATGROUP CC ON CC.CATGROUP_ID = A.catgroup_id LEFT JOIN CATGROUP PC ON PC.CATGROUP_ID = A.CATGROUP_ID_PARENT where PARENTNAME = '".$catalogGBK."'".$cond."
                    ORDER BY A.CATGROUP_ID_PARENT,A.CATGROUP_ID "; $query = $db2->query($sql); while($row = $db2->fetch_array($query)) { foreach($row as $key=>$val) { $row[$key] = iconv('gb2312','utf-8',$val); } $userPerModuleAry[$k]['list'][$kk]['list'][$kkk]['list'][$row['CATGROUP_ID']] = $row; $userPerModuleAry[$k]['list'][$kk]['list'][$kkk]['list'][$row['CATGROUP_ID']]['countNum'] = $countCatgroupIdAry[$row['CATGROUP_ID']]; } } } } foreach($userPerModuleAry as $k=>$v) { foreach ($v['list'] as $kk => $vv) { foreach ($vv['list'] as $kkk => $vvv) { $parentCountNum = 0; foreach ($vvv['list'] as $kkkk => $vvvv) { $parentCountNum += $vvvv['countNum']; } $userPerModuleAry[$k]['list'][$kk]['list'][$kkk]['countNum'] = $parentCountNum; } } } foreach($userPerModuleAry as $k=>$v) { foreach ($v['list'] as $kk => $vv) { $parentCountNum = 0; foreach ($vv['list'] as $kkk => $vvv) { $parentCountNum += $vvv['countNum']; } $userPerModuleAry[$k]['list'][$kk]['countNum'] = $parentCountNum; } } foreach($userPerModuleAry as $k=>$v) { $parentCountNum = 0; foreach ($v['list'] as $kk => $vv) { $parentCountNum += $vv['countNum']; } $userPerModuleAry[$k]['countNum'] = $parentCountNum; } $title = "各分类下的产品数量统计"; $xvalueTmpAry = $seriesAry = array(); foreach($userPerModuleAry as $key=>$val) { $xvalueAry[] = $val['m_name']; $xvalueTmpAry[] = empty($val['countNum']) ? 0 : $val['countNum']; } $seriesAry = array( '0'=>array( 'name'=>'产品数量统计', 'data'=>$xvalueTmpAry ) ); $xvalue = json_encode($xvalueAry); $series = json_encode($seriesAry); include template(); 