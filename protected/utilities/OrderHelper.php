<?php
Yii::import('serviceproviders.models.*');
/**
 * Utility function for order processing
 * @author Mbagwu Chibundu
 *
 */
class OrderHelper {
	/**
	 * Registers an order
	 * @param array $orderConfig defining the configuration for the orders. Must be specified according the the following example:
	 * array(
	 * 	'user_type'=>'SP',
	 *  'user_id'=>1,
	 *  'orders'=>array(
	 *  	'item'=>SaleItems::PACKAGE_FEATURE,
	 *		'description'=>'Upgrade of package "<b>'.$package->title.'</b>" to Premium.',
	 *		'quantity'=>1,								
	 *		'currency_id'=>3,		
	 *		'unit_price'=>200,
	 *		'discount'=>0,
	 *  ),
	 * );
	 * @return array of order ids that were taken
	 */
	public static function takeOrders($orderConfig)
	{		
		$db = Yii::app()->db;
		
		$user_type = $orderConfig['user_type'];
		$user_id = $orderConfig['user_id'];
		
		$table = '';
		$user_id_column = '';
		$exists = true;
		$status = 1;
		
		if($user_type == "SP")
		{
			$table = '{{spOrder}}';
			$user_id_column = "serviceproviders_id";
			$status = SpOrder::PENDING;
		}
		
			
		$command = $db->createCommand("INSERT INTO $table ($user_id_column, amount, status, qty, currencies_id, unit_price, discount, description, item) VALUES (:uId, :amount, :status, :qty, :cid, :unit_price, :discount, :description, :item)");
		
		
		$orders = $orderConfig['orders'];
		
		$order_ids = array();
		
		foreach ($orders as $order)
		{
				
			$quantity = $order['quantity'];
			$unit_price = $order['unit_price'];
			$discount = $order['discount'];
			$description = $order['description'];
			$currency_id = $order['currency_id'];
				
			$item = $order['item'];
			
				
			$tAmount = $quantity * $unit_price;
			$amount = $tAmount - (($tAmount * $discount)/100);
				
			$command->bindParam(':uId', $user_id, PDO::PARAM_INT);
				
			$command->bindParam(':amount', $amount, PDO::PARAM_STMT);
		
			$command->bindParam(':status', $status, PDO::PARAM_INT);
		
			$command->bindParam(':qty', $quantity, PDO::PARAM_INT);
		
			$command->bindParam(':cid', $currency_id, PDO::PARAM_INT);
				
			$command->bindParam(':unit_price', $unit_price, PDO::PARAM_STMT);
				
			$command->bindParam(':discount', $discount, PDO::PARAM_STMT);
				
			$command->bindParam(':description', $description, PDO::PARAM_STR);
				
			$command->bindParam(':item', $item, PDO::PARAM_STR);
				
				
		
			$command->execute();
			
			$order_ids[] = $db->getLastInsertId();
		}
	
		return $order_ids;
		
	}
	
	/**
	 * Parses POI and returns an array like the following example
	 * array(
	 * 	'user_type'=>'SP'
	 * 	'order_ids'=>array(1,2,3),
	 * )
	 * @param string $poi the Processed Order Identifier, a string in the format User_Type-id1:id2 
	 * e.g SP-1:2:3 means process orders 1,2 and 3 for Service Provider
	 */
	public static function parsePOI($poi)
	{
		$poiParts = explode("-", $poi);
		$user_type = $poiParts[0];
		$orderIds = $poiParts[1];
		
		return array(
				'user_type'=>$user_type,
				'order_ids'=>explode(":", $orderIds),
				);
	}
	
	
	/**
	 * This method returns formatted Processed Orders Info - basically a set of order ids for a particular user type.
	 * An example out put is SP-1:2:3, signifying orders 1, 2 and 3 of a service provider on the vcubator
	 * @param string $user_type, what type of user on the Vcubator: SP, ENT, MENT
	 * @param array $order_ids, an array of order ids.
	 */
	public static function getPOI($user_type, $order_ids)
	{
		return $user_type.'-'.implode(":", $order_ids);
	}
	
	/**
	 * Gets payer detais for a service provider
	 * @return array, two-dimensional array containing info on who is making the Order. The array below illustrates further:<br>
	 * array(                                                                 <br>
	 *			'email'=>'xyz@domain.com',                                    <br>
	 *			'firstname'=> 'John',                                         <br>
	 *			'lastname'=>'Smith',                                          <br>
	 *			'address'=>array(                                             <br>
	 *					'firstline'=>'10 Downing Street',                     <br>
	 *					'secondline'=>'Queens Drive',                         <br>
	 *					'city'=>'London',                                     <br>
	 *					'country_code'=>'GB',                                 <br>
	 *	 				'postalCode'=>'3233',                                 <br>
	 *			),                                                            <br>
	 *	);
	 */
	public static function getSPPayerDetails()
	{
		$teammember = Miscellaneous::getTeamMember();
		$address = Miscellaneous::getServiceProvider()->postalAddress;
	
		return array(
				'email'=>$teammember->email,
				'firstname'=> $teammember->firstname,
				'lastname'=>$teammember->lastname,
				'address'=>array(
						'firstline'=>$address->firstline,
						'secondline'=>$address->secondline,
						'city'=>$address->city,
						'country_code'=>$address->country,
						'postalCode'=>$address->postalCode,
				),
		);
	}
	
	/**
	 * Calculates the total amount a set of orders comes to after factoring in the discounts
	 * @param array $orders
	 * @throws Exception
	 */
	public static function getOrderTotal($orders)
	{
		if(is_array($orders))
		{			
			$total = 0;
			
			foreach ($orders as $order)
			{
				$quantity = $order['quantity']; 
				$unit_price =  $order['unit_price']; 
				$discount =  $order['discount'];
				
				$amount = $quantity * $unit_price;
				$total += ($amount - (($amount * $discount)/100));
			}
			
			return $total;
			
		}
		else 
		{
			throw new Exception("An array of Orders is expected", GenericException::UNEXPECTED_PARAMETER);
		}
	}
	
	public static function getOrderSummary($orders)
	{
		if(is_array($orders))
		{
			$total = 0;			
			$items = '';
			$descriptions = '';
			
			foreach ($orders as $order)
			{
				$quantity = $order['quantity'];
				$unit_price =  $order['unit_price'];
				$discount =  $order['discount'];
		
				$amount = $quantity * $unit_price;
				$total += ($amount - (($amount * $discount)/100));
				
				$items .= ' + '. $order['item'];
				$descriptions .= ' + '. $order['description'];
			}
				
			return array(
						'total'=>$total,
						'items'=>trim($items, '+ '),
						'descriptions'=>trim($descriptions, '+ '),
					);
				
		}
		else
		{
			throw new Exception("An array of Orders is expected", GenericException::UNEXPECTED_PARAMETER);
		}
	}

}

?>