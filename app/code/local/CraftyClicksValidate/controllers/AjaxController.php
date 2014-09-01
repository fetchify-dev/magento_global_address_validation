<?php
class CraftyClicksValidate_AjaxController extends Mage_Core_Controller_Front_Action{

	public function updateAction(){
		$order_id = Mage::getSingleton('checkout/session')->getLastRealOrderId();
		//$_GET["order_id"];
		$order = Mage::getSingleton('sales/order')->loadByIncrementId($order_id);
		$shippingAddress = Mage::getModel('sales/order_address')->load($order->shipping_address_id);
		//var_dump($shippingAddress->_data);
		if(isset($_GET['street']) && isset($_GET['city']) && isset($_GET['postcode'])){

			$data = array(
				'street'	=> $_GET['street'],
				'city'	=> $_GET['city'],
				'postcode'	=> $_GET['postcode'],
				'region'	=> $_GET['region']
			);

			$states = Mage::getModel('directory/country')->load($shippingAddress->country_id)->getRegions()->toOptionArray();
			if(count($states)){
				$found = false;
				foreach($states as $region)
				{
					if($region['title'] == $_GET['region']){
						$data["region_id"] = $region['value'];
						$found = true;
					}
				}
				if(!$found){
					$data["region_id"] = 0;
				}
			}

			$shippingAddress->addData($data);

			$shippingAddress->implodeStreetAddress()->save();
			header("Status: 200");
		}

	}
}