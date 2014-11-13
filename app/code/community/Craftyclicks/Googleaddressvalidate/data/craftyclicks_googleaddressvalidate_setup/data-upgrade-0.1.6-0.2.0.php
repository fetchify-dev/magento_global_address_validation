<?php
$configAccess = new Mage_Core_Model_Config();
$oldCfg = Mage::getStoreConfig('general');

if(isset($oldCfg['craftyclicksvalidate'])){
	//old plugin was set
	//transfer old config into new one.
	$values = array(
		"active",
		"loading_image",
		"title",
		"description_1",
		"description_2",
		"finish_text",
		"gmaps",
		"region_dropdown");
	$data = array();
	//check if every old cfg exists. (some older versions might not have all of these options)
	foreach($values as $val){
		if(isset($oldCfg['craftyclicksvalidate'][$val])){
			$data[$val] = $oldCfg['craftyclicksvalidate'][$val];
		}
	}
	foreach($data as $k=>$v){
		$configAccess->saveConfig('googleaddressvalidate/general/'.$k,$v, 'default', 0);
	}
}
?>