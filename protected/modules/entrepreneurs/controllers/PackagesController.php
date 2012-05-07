<?php
Yii::import('ext.payment.purse.components.Purse');
Yii::import('serviceproviders.models.Packages');
class PackagesController extends Controller
{
	public $layout = 'column1';
	
	public function accessRules()
	{
		return array(
				array(
						'allow',
						'roles'=>array('entrepreneur'),
				),
				array(
						'deny',
						'users'=>array('*'),
				),
		);
	}
	
	public function actionIndex()
	{			
		$serviceCategories = Servicecategories::model()->with(array('ordinaryPackagesCount'))->findAll();

		$fpCount = Packages::model()->count("featured_priority >= ".Packages::HIGH);
		
		$this->render('index', array('serviceCategories'=>$serviceCategories, 'fpCount'=>$fpCount));
	}	
	
	public function actionFeaturedPackages($page)
	{	
		
		$criteria = new CDbCriteria();
		$criteria->select = array('id', 'title', 'description', 'picture', 'cost', 'cost_type', 'delivery', 'units_bought', 'discount', 'featured_priority');
		$criteria->with = 'currency';				
		$criteria->scopes = array('active', 'featured', 'latest', 'leastViewed');
		
		$count = Packages::model()->count($criteria);

		$pagination = new CPagination($count);
		$pagination->pageSize = 3;
		$pagination->applyLimit($criteria);
		
		$packages = Packages::model()->findAll($criteria);				
		
		$this->renderPartial('package_row', array('packages'=>$packages));
	}
	
	public function actionOrdinaryPackages($page, $id)
	{		
		$criteria = new CDbCriteria();
		$criteria->select = array('id', 'title', 'description', 'picture', 'cost', 'cost_type', 'delivery', 'units_bought', 'discount', 'featured_priority');
		$criteria->with = 'currency';
		$criteria->condition = 't.servicecategories_id = :id';
		$criteria->params = array(':id'=>$id);		
		$criteria->scopes = array('active', 'notFeatured', 'latest', 'leastViewed');
		
		$count = Packages::model()->count($criteria);

		$pagination = new CPagination($count);
		$pagination->pageSize = 3;
		$pagination->applyLimit($criteria);
		
		$packages = Packages::model()->findAll($criteria);				
		
		$this->renderPartial('package_row', array('packages'=>$packages));
	}
	
	public function actionSearch($text, $page = 1, $sort = "")
	{
		$buffer = explode(' ', $text);
		$n = count($buffer);
		
		$search = array();
		
		for($i = 0; $i < $n; $i++)
		{
			$word = $buffer[$i];
			if($word != ' '){
				$search[] = "%".trim($word)."%";
			}
		}		
		
		$sortStr = ""; 
		
		if($sort != "")
		{
			switch ($sort)
			{
				case "Price":
					$sortStr = "cost ASC, featured_priority DESC";	
					break;				
				case "Discount":
					$sortStr = "discount DESC, featured_priority DESC";
					break;
				case "Rating":
					$sortStr = "vote_up DESC, vote_down ASC, featured_priority DESC";
					break;
				case "Best Selling":
					$sortStr = "units_bought DESC, featured_priority DESC";
					break;
			}
			
			
		}
		
		$command = Yii::app()->db->createCommand();
		 
		 
		$command->select(array('count(p.id)'))
		->from('{{packages}} p')		
		->where(array('or like', 'p.title', $search));	 
		 $n = $command->queryScalar();
		 $pagination = new CPagination($n);
		 $pagination->setPageSize(6); 
		 $command->reset();
		 
		 if($sortStr == ""){
			 $packages = $command->select(array('p.id', 'title', 'picture', 'cost', 'cost_type', 'delivery', 'units_bought', 'discount', 'status', 'featured_priority', 'symbol'))
			 ->from('{{packages}} p')			
			 ->join('{{currencies}} c', 'c.id = p.currencies_id')
			 ->offset($pagination->offset)
			 ->limit($pagination->limit)
			 ->where(array('or like', 'p.title', $search))
			 ->queryAll();		
		 }
		 else
		 {
		 	$packages = $command->select(array('p.id', 'title', 'picture', 'cost', 'cost_type', 'delivery', 'units_bought', 'discount', 'status', 'featured_priority', 'symbol'))
		 	->from('{{packages}} p')		 	
		 	->join('{{currencies}} c', 'c.id = p.currencies_id')
		 	->offset($pagination->offset)
		 	->limit($pagination->limit)
		 	->order($sortStr)
		 	->where(array('or like', 'p.title', $search))
		 	->queryAll();
		 }
		 
		 $command->reset();
		 
		 $categories = $command->select("c.id, c.name")
		 ->from("{{servicecategories}} c")
		 ->where("(SELECT count(id) FROM {{packages}} p WHERE c.id=p.servicecategories_id) > 0")
		 ->queryAll();
		 
		$this->renderPartial('search_results', array('current_page'=>$page,'categories'=>$categories,'category_name'=>"", 'mode'=>'search','packages'=>$packages, 'pages'=>$pagination, 'numberOfResults'=>$n, 'search'=>$text, 'sortedBy'=>$sort, 'category_id'=>0)); 
	}
	/**
	 * Fetches All packages in a specified category
	 * @param int $id
	 * @param int $page
	 * @param string $sort
	 */
	public function actionCategory($id, $page = 1, $sort = "")
	{
		$sortStr = "";
		
		if($sort == "")
		{					
			$sort = "Price";
		}
		switch ($sort)
		{
			case "Price":
				$sortStr = "cost ASC, featured_priority DESC";
				break;
			case "Discount":
				$sortStr = "discount DESC, featured_priority DESC";
				break;
			case "Rating":
				$sortStr = "vote_up DESC, vote_down ASC, featured_priority DESC";
				break;
			case "Best Selling":
				$sortStr = "units_bought DESC, featured_priority DESC";
				break;
		}
		
		
		$command = Yii::app()->db->createCommand();
		
		$n = $command->select("count(p.id)")
		->from("{{packages}} p")
		->where("p.servicecategories_id = :id", array(':id'=>$id))
		->queryScalar();
		
		$pagination = new CPagination($n);
		$pagination->setPageSize(9);
		
		if($sortStr == "")
		{
			$sortStr = "featured_priority DESC, cost ASC, views DESC, vote_up DESC, vote_down ASC, discount DESC, units_bought DESC";
		}
		
		$command->reset();

		$packages = $command->select(array('p.id', 'title', 'picture', 'cost', 'cost_type', 'delivery', 'units_bought', 'discount', 'status', 'featured_priority', 'symbol'))
		 	->from('{{packages}} p')		 	
		 	->join('{{currencies}} c', 'c.id = p.currencies_id')
		 	->offset($pagination->offset)
		 	->limit($pagination->limit)
		 	->order($sortStr)
		 	->where("p.servicecategories_id = :id", array(':id'=>$id))
		 	->queryAll();		
		
		$command->reset();
		
		$category_name = $command->select("name")
		->from("{{servicecategories}}")
		->where("id=:id", array(":id"=>$id))
		->queryScalar();
		
		if($category_name == null)
		{
			$category_name = "";
		}		
		
		$command->reset();
		
		
		$categories = $command->select("c.id, c.name")
		->from("{{servicecategories}} c")
		->where("(SELECT count(id) FROM {{packages}} p WHERE c.id=p.servicecategories_id) > 0")
		->queryAll();		
		
		
		$this->render('search_results', array('categories'=>$categories,'current_page'=>$page,'category_name'=>$category_name,'mode'=>'category','packages'=>$packages, 'pages'=>$pagination, 'numberOfResults'=>$n, 'search'=>$category_name, 'sortedBy'=>$sort, 'category_id'=>$id));
		
	}
	
	
	public function actionAllFeaturedPackages($page = 1, $sort = "")
	{
		$sortStr = "";
	
		if($sort == "")
		{
			$sort = "Price";
		}
		switch ($sort)
		{
			case "Price":
				$sortStr = "cost ASC, featured_priority DESC";
				break;
			case "Discount":
				$sortStr = "discount DESC, featured_priority DESC";
				break;
			case "Rating":
				$sortStr = "vote_up DESC, vote_down ASC, featured_priority DESC";
				break;
			case "Best Selling":
				$sortStr = "units_bought DESC, featured_priority DESC";
				break;
		}
	
	
		$command = Yii::app()->db->createCommand();
	
		$n = $command->select("count(p.id)")
		->from("{{packages}} p")
		->where("p.featured_priority >=".Packages::HIGH)
		->queryScalar();
	
		$pagination = new CPagination($n);
		$pagination->setPageSize(9);
	
		if($sortStr == "")
		{
			$sortStr = "featured_priority DESC, cost ASC, views DESC, vote_up DESC, vote_down ASC, discount DESC, units_bought DESC";
		}
	
		$command->reset();
	
		$packages = $command->select(array('p.id', 'title', 'picture', 'cost', 'cost_type', 'delivery', 'units_bought', 'discount', 'status', 'featured_priority', 'symbol'))
		->from('{{packages}} p')
		->join('{{currencies}} c', 'c.id = p.currencies_id')
		->offset($pagination->offset)
		->limit($pagination->limit)
		->order($sortStr)
		->where("p.featured_priority >=".Packages::HIGH)
		->queryAll();
	
		$command->reset();
	
		$category_name = "";		
	
		$command->reset();	
	
		$categories = $command->select("c.id, c.name")
		->from("{{servicecategories}} c")
		->where("(SELECT count(id) FROM {{packages}} p WHERE c.id=p.servicecategories_id) > 0")
		->queryAll();
	
	
		$this->render('search_results', array('categories'=>$categories,'current_page'=>$page,'category_name'=>$category_name,'mode'=>'featured','packages'=>$packages, 'pages'=>$pagination, 'numberOfResults'=>$n, 'search'=>$category_name, 'sortedBy'=>$sort, 'category_id'=>0));
	
	}
	
	/**
	 * Shuffles an array
	 * @return mixed returns the shuffled array; returns false if the supplied parameter was not an array
	 * @param array $elements
	 */
	public function shuffle($elements)
	{
		if(is_array($elements)){
			
			$sizeOfArray = count($elements);
			$maxIndex = $sizeOfArray - 1;
			
			$shuffled = array();
			
			for($i = 0; $i < $sizeOfArray; $i++)
			{
				
				$uniqueElementEntered = false;				
				
				while (!$uniqueElementEntered)
				{
					$j = rand(0, $maxIndex);
					
					if(!in_array($elements[$j], $shuffled))
					{
						$shuffled[] = $elements[$j];
						
						$uniqueElementEntered = true;
					}					
				}
				
			}		
			
			return $shuffled;
		}
		return false;
	}
	
	public function actionView($id)
	{
		Yii::import('serviceproviders.models.*');
		
		$package = Packages::model()->with('currency', 'serviceprovider')->findByPk($id);
		if($package){
		$sp = $package->serviceprovider;
		$name = $sp->displayName;		
		
		$spId = $package->serviceproviders_id;
		$category_id = $package->servicecategories_id;
		
		$command = Yii::app()->db->createCommand();		
		
		$unshuffled_other_packages = $command
		->select(array('p.id', 'title', 'description', 'picture', 'cost', 'cost_type', 'delivery', 'units_bought', 'discount', 'status', 'featured_priority', 'symbol'))
		->from('{{packages}} p')		 	
		->join('{{currencies}} c', 'c.id = p.currencies_id')
		->limit(12) 
		->where("p.serviceproviders_id = :id" ,array(":id"=>$spId))
		->order("p.created_on DESC")
		->queryAll();
		
		$command->reset();
		
		$unshuffled = $command->select(array('p.id', 'title', 'description', 'picture', 'cost', 'cost_type', 'delivery', 'units_bought', 'discount', 'status', 'featured_priority', 'symbol'))
		->from('{{packages}} p')
		->join('{{currencies}} c', 'c.id = p.currencies_id')		
		->limit(5)		
		->where("p.servicecategories_id = :id", array(':id'=>$category_id))
		->queryAll();
		
		
		$shuffled_other_packages = $this->shuffle($unshuffled_other_packages);
		$other_packages = array();
		
		if(isset($shuffled_other_packages[0]))
			$other_packages[] = $shuffled_other_packages[0];
		if(isset($shuffled_other_packages[1]))
			$other_packages[] = $shuffled_other_packages[1];
		if(isset($shuffled_other_packages[2]))
			$other_packages[] = $shuffled_other_packages[2];		
		  
		
		$shuffled = $this->shuffle($unshuffled);
		 $similar_services = array();
		 if(isset($shuffled[0]))
		 	$similar_services[] = $shuffled[0];
		 if(isset($shuffled[1]))
		 	$similar_services[] = $shuffled[1];
		}
		else 
		{
			throw new CHttpException(404, 'Invalid Request. The requested page does not exist.');
		}
		
		$this->render('view', array('name'=>$name, 'id'=>$spId, 'package_id'=>$id, 'package'=>$package, 'other_packages'=>$other_packages, 'similar_services'=>$similar_services));
	}
	
	public function actionViewByProvider($id, $page = 1)
	{
		$command = Yii::app()->db->createCommand();
		
		$n = $command
		->select('count(id)')
		->from('{{packages}}')
		->where('serviceproviders_id = :id', array(':id'=>$id))
		->queryScalar();		
		
		if($n > 0)
		{
			$command->reset();
			
			$data = $command->select("s.displayName, s.overview, tl.profile_picture, a.city as city, a.country as country, v.identity as isVerified, s.created_on")
			->from('{{serviceproviders}} s')
			->join('{{teammembers}} tl', 's.id=tl.serviceproviders_id')
			->join('{{sp_addresses}} a', 's.id=a.serviceProviders_id')	
			->join('{{verifications}} v', 's.id=v.serviceproviders_id')		
			->where('s.id=:id', array(':id'=>$id))
			->queryRow();
			
			$displayName = "";
			$city = "";
			$country = "";
			$pofile_picture = "";			
			$isVerified = false;
			$created_on = 0;
			
			if(isset($data['displayName'])){
				$displayName = $data['displayName'];
			}
			if(isset($data['overview'])){
				$overview = $data['overview'];
			}
			if(isset($data['city'])){
				$city = $data['city'];
			}
			if(isset($data['country'])){
				$country = $data['country'];
			}
			if(isset($data['profile_picture'])){
				$profile_picture = $data['profile_picture'];
			}			
			if(isset($data['isVerified'])){
				$isVerified = (bool)$data['isVerified'];
			}
			if(isset($data['created_on'])){
				$created_on = $data['created_on'];
			}
			
			$member_since = date("jS M Y",$created_on);			
			$pagination = new CPagination($n);
			$pagination->setPageSize(6);

			$command->reset();
			$packages = $command->select(array('p.id', 'title', 'picture', 'cost', 'cost_type', 'delivery', 'units_bought', 'discount', 'status', 'featured_priority', 'symbol'))
			->from('{{packages}} p')
			->join('{{currencies}} c', 'c.id = p.currencies_id')		
			->limit($pagination->limit)		
			->offset($pagination->offset)
			->where("p.serviceproviders_id = :id", array(':id'=>$id))
			->queryAll();
			
			$command->reset();
			$stat = $command->select(array('SUM(vote_up) as positive_votes', 'SUM(vote_down) as negative_votes', 'SUM(units_bought) as sold'))
			->from('{{packages}}')
			->where('serviceproviders_id=:id', array(':id'=>$id))
			->queryRow();
			
			$command->reset();
			$skills = $command->select('s.name')
			->from('serviceproviders_skills ps')
			->join('{{skills s}}', 's.id=ps.tbl_skills_id')
			->where('ps.tbl_serviceproviders_id=:id', array(':id'=>$id))
			->queryAll();
			
			$command->reset();
			$services = $command->select('s.name')
			->from('{{providers_services}} ps')
			->join('{{services}} s', 's.id = ps.services_id')
			->where('ps.serviceproviders_id = :id', array(':id'=>$id))
			->queryAll();
			
			$skills_str = "";			
			foreach ($skills as $skill)
			{
				$skills_str.=$skill['name'].", ";
			}
			
			$skills_str = trim($skills_str, ", ");
			
			$services_str = "";
			foreach ($services as $service)
			{
				$services_str.=$service['name'].", ";
			}
				
			$services_str = trim($services_str, ", ");			
			
			$positive_votes = 0;
			$negative_votes = 0;
			$sold = 0;			
			
			if(isset($stat['positive_votes']))
			{
				$positive_votes = $stat['positive_votes'];
			}
			if(isset($stat['negative_votes']))
			{
				$negative_votes = $stat['negative_votes'];
			}
			if(isset($stat['sold']))
			{
				$sold = $stat['sold'];
			}
			
			$rating = round($positive_votes * 100/($positive_votes + $negative_votes));
			
		}
		else
		{
			throw new CHttpException(404, 'Invalid Request. Please do not repeat this request again.');
		}
		
		$this->render('provider_view', array('packages'=>$packages,
				'other_services'=>$services_str,
				'skills'=>$skills_str,
				'member_since'=>$member_since,
				'isVerified'=>$isVerified,
				'sold'=>$sold,
				'rating'=>$rating,
				'positive_votes'=>$positive_votes,
				'negative_votes'=>$negative_votes,
				'profile_picture'=>$profile_picture,
				'country'=>$country,
				'city'=>$city,
				'overview'=>$overview,
				'displayName'=>$displayName,
				'pages'=>$pagination
		));
	}
	
	public function actionOrderPackage($id, $mode)
	{
		
		$command = Yii::app()->db->createCommand();
		
		$package = $command
		->select(array('title', 'description', 'cost', 'cost_type', 'symbol', 'currencies_id', 'discount'))
		->from('{{packages}} p')
		->join('{{currencies}} c', 'c.id=p.currencies_id')
		->where('p.id=:id', array(':id'=>$id))
		->queryRow();
		
		$command->reset();
		$user_id = $command
		->select("id")
		->from('{{users}}')
		->where('email=:email', array('email'=>Yii::app()->user->id))
		->queryScalar();
		
		$title = $package['title'];
		$description = $package['description'];
		$currency_id = $package['currencies_id'];
		$symbol = $package['symbol'];
		$unit_price = $package['cost'];
		$discount = $package['discount'];
		
		$orders = array(
						array(
							'item'=>$title,
							'description'=>$description,
							'quantity'=>1,
							'currency_id'=>$currency_id,
							'currency_symbol'=>$symbol,
							'unit_price'=>$unit_price,
							'discount'=>$discount
							)
						);
		
		$price = OrderHelper::getOrderTotal($orders);
	
		$orderConfig = array(
				'user_type'=>'ET',
				'user_id'=>$user_id,
				'orders'=>$orders,
				);
		
		
		
		
		$order_ids = OrderHelper::takeOrders($orderConfig);		
		$poi = OrderHelper::getPOI('ET', $order_ids);
		$payer_details = array();
		
		$ent = Miscellaneous::getEntrepreneur();
		
		if($mode == "purse")
		{				
			if($ent->purse > $price)
			{				
				$orderFulfillmentUrl = $this->createUrl('packages/pursePurchase', array('poi'=>$poi, 'ser_pack_id'=>$id));
			}
			else 
			{
				Yii::app()->user->setFlash('error', '<h3>Insufficient Funds</h3>You do not have sufficient funds in your V-purse to carry out this transaction.<p style = "padding-top: 5px;">'.CHtml::link('Load your V-purse &raquo;', array('payment/loadVPurse'), array('class'=>'btn')).'</p>');
				$this->redirect(array('packages/view', 'id'=>$id));					
			}				
			
		}
		else 
		{								
			$payer_details = OrderHelper::getSPPayerDetails();				
		}
		
		$this->render('order_summary', array('orderConfig'=>$orderConfig, 'mode'=>$mode, 'payer_details'=>$payer_details, 'orderFulfillmentUrl'=>$orderFulfillmentUrl));
	}
	
	private function getConversationData($id)
	{
		$criteria = new CDbCriteria();
		$criteria->select = '*';
		$criteria->condition = "etOrders_id=:order_id";
		$criteria->order = "create_time DESC";
		$criteria->params = array(':order_id'=>$id);
		
		$noi = PackageOrderMsg::model()->count($criteria);
			
		$pagination = new CPagination($noi);
			
		$pagination->setPageSize(5);
		
		return array('criteria' => $criteria, 'pages' => $pagination);
	}
	
	public function actionGetPagination($id, $page = 1)
	{
		$data = $this->getConversationData($id);		
		
		$this->renderPartial('pager', array('pages'=>$data['pages']));
	}
	
	public function actionGetConversations($n, $page = 1)
	{
		if(Yii::app()->request->isAjaxRequest){
			
			$data = $this->getConversationData($n);
			
			$criteria = $data['criteria'];
			$pages = $data['pages'];
						
			$pages->applyLimit($criteria);
			
			$messages = PackageOrderMsg::model()->findAll($criteria);			
			$msgCount = count($messages);
			
			if($msgCount == 1)
			{
				if($messages[0]->type == PackageOrderMsg::REQUIREMENT)
				{
					$msgCount = 0;					
				}	
			}		
			
			if($msgCount > 0)
			{
				foreach ($messages as $m)
				{
					$m->create_time = date('l, jS F Y \a\t g:i a', $m->create_time); 
				}
				echo CJSON::encode(array('messageType'=>'success', 'items'=>$messages));
			}
			else
			{
				echo CJSON::encode(array('messageType'=>'zero_count'));
			}
		}
		else
		{
			throw new CHttpException(404, 'Invalid Request. Please do not repeat this request again');
		}
	}
	
	public function actionPursePurchase($poi, $ser_pack_id, $page = 1)
	{			
		$orderData = OrderHelper::parsePOI($poi);
		$order_id = $orderData['order_ids'][0];
		
		if($orderData['user_type'] == 'ET')
		{
			$package = Packages::model()->findByPk($ser_pack_id);
			
			$order = EtOrders::model()->findByPk($order_id);
			
			$isReqSent = true;
						
			if(!$order)
				throw new CHttpException('404', 'Invalid Request!');
				
			$order_req = null; 
			$hasMessage = false;
			
			if($package)
			{					
				$etId = $order->users_id;
				$spId = $package->serviceproviders_id;
				$instructions = $package->instructions;
				$messages = PackageOrderMsg::model()->findAllByAttributes(array('etOrders_id'=>$order_id));
				$order_req = null;
				
				$delivery = $package->delivery;//in days
				
				$omc = 0; //Ordinary message count
				foreach ($messages as $m)
				{					
					if($m->type == PackageOrderMsg::REQUIREMENT)
					{
						$order_req = $m;
						$omc--;
					}
					$omc++;
				}
				
				if($omc > 0)
				{
					$hasMessage = true;
				}
				
				if($instructions)
				{					
					if(!$order_req)
					{
						$order_req = new PackageOrderMsg();
						$order_req->type = PackageOrderMsg::REQUIREMENT;
						$order_req->etOrders_id = $order_id;
						$order_req->save(false);
					}		
					
					if(!$order_req->message)
					{
						$isReqSent = false;
					}					
				}				
				
				$sp = Serviceproviders::model()->findByPk($spId);
				$teamLeader = $sp->teamLeader;
				$et = Users::model()->findByPk($etId);
				
				$tlName = $teamLeader->firstname." ".$teamLeader->lastname;
				$tlPic = $teamLeader->profile_picture;			
				$etName = $et->firstname." ".$et->lastname;
				$etPic = $et->pic;
				
				if(!$isReqSent){
					$success_message = '<h4>Your order was successful</h4> Thank you for your order! <br> Next, please enter any preference, requirement or instruction the service provider will need to fulfill your order.<br>The funds have been escrowed and will normally be released only when you mark this order as having been fulfilled. Please use this page to track your order or handle any communications with the service provider regarding this order. In the event that the job is delayed or not satisfactory done, you can also request arbitration at the bottom of the page.';
				}
				else
				{
					$success_message = '<h4>Your order was successful</h4> Thank you for your order! <br> The funds have been escrowed and will normally be released only when you mark this order as having been fulfilled. Please use this page to track your order or handle any communications with the service provider regarding this order. In the event that the job is delayed or not satisfactory done, you can also request arbitration at the bottom of the page.';
				}
				$purse = new Purse();
				
				if($purse->pay($order_id, 'ET', $success_message))
				{					
					$command = Yii::app()->db->createCommand();
					
					$command->insert('{{escrows}}',array(
						'amount'=>$order->amount,
						'payer'=>'ET-'.$etId,
						'payee'=>'SP-'.$spId,
						'currencies_id'=>$order->currencies_id,
						'status'=>Escrows::UNRELEASED,					
					));
					
					$command->reset();
					if(!$isReqSent)
					{						
						$command->insert('{{package_orders}}',array(
								'status'=>Packages::REQUIREMENTS_PENDING,
								'serviceproviders_id'=>$spId,
								'users_id'=>$etId,
								'orders_id'=>$order_id,
								'packages_id'=>$package->id,
						));
					}
					else
					{
						$command->insert('{{package_orders}}',array(
								'status'=>Packages::IN_PROGRESS,
								'serviceproviders_id'=>$spId,
								'users_id'=>$etId,
								'orders_id'=>$order_id,
								'start_count'=>time(),
								'packages_id'=>$package->id,
						));
					}
					
				}		

			   
				$package_order = PackageOrders::model()->find("orders_id=:order_id", array(":order_id"=>$order_id));
				
				$time_left = 0;
				
				$start = $package_order->start_count;
				
				$days = 0;
				$hours = 0;
				$minutes = 0;
				$seconds = 0;
				$already_due = false;
				if($start > 0)
				{					
					$day_in_seconds = 24 * 60 * 60; //number of seconds in a day
					$hour_in_seconds = 60 * 60;
					$minutes_in_seconds = 60;
					$end = $start + ($day_in_seconds * $delivery);
					$duration = $end - time();
					if($duration > 0)
					{							
						$days = floor($duration/$day_in_seconds);						
						$hrs_mins_sec = $duration % $day_in_seconds; // hours,minutes and seconds left						
						$hours = floor($hrs_mins_sec / $hour_in_seconds);
						$mins_sec = $hrs_mins_sec % $hour_in_seconds;
						$minutes = floor($mins_sec / $minutes_in_seconds);
						$seconds = $mins_sec % $minutes_in_seconds;			
					}
					else
					{
						$already_due = true;
					}						
				}
				
				$this->render('order_requirement',
					 array(	
					 		'duration'=>array(
					 				'isDue'=>$already_due,
					 				'time'=>array(
					 						'days'=>$days,
					 						'hours'=>$hours,
					 						'minutes'=>$minutes, 
					 						'seconds'=>$seconds)
					 				),				 	
					 		'order_req'=>$order_req,
							'order_id'=>$order_id,
							'package_pic'=>$package->picture,
							'package_title'=>$package->title,
							'status'=>$package_order->status,
							'spId'=>$spId,
							'spName'=>$sp->displayName,
							'instructions'=>$instructions,
					 		'etPic'=>$etPic,
					 		'etName'=>$etName,
					 		'tlName'=>$tlName,
					 		'tlPic'=>$tlPic,					 		 
							'dateOrdered'=>date('l, jS F Y \a\t g:i a', strtotime($order->create_time)),
					 		'isReqSent'=>$isReqSent,
					 		'hasMessage'=>$hasMessage,					 	
						));
				
				
				
			}
		}
		
		
		
	}
	
	public function actionGetOrderDeadline($n)
	{				
		$package_order = PackageOrders::model()->with('package')->find("orders_id=:order_id", array(":order_id"=>$n));
		
		$delivery = $package_order->package->delivery;
		
		$start = $package_order->start_count;		
		
		$days = 0;
		$hours = 0;
		$minutes = 0;
		$seconds = 0;
		$already_due = false;
		
		if($start > 0)
		{
			$day_in_seconds = 24 * 60 * 60; //number of seconds in a day
			$hour_in_seconds = 60 * 60;
			$minutes_in_seconds = 60;
			$end = $start + ($day_in_seconds * $delivery);
			$duration = $end - time();			
			if($duration > 0)
			{
				$days = floor($duration/$day_in_seconds);
				$hrs_mins_sec = $duration % $day_in_seconds; // hours,minutes and seconds left
				$hours = floor($hrs_mins_sec / $hour_in_seconds);
				$mins_sec = $hrs_mins_sec % $hour_in_seconds;
				$minutes = floor($mins_sec / $minutes_in_seconds);
				$seconds = $mins_sec % $minutes_in_seconds;
			}
			else
			{
				$already_due = true;
			}			
		}
		
		echo CJSON::encode(array('isDue'=>$already_due,
					 		'time'=>array(
					 			'days'=>$days,
					 			'hours'=>$hours,
					 			'minutes'=>$minutes, 
					 			'seconds'=>$seconds)
					 	));
		Yii::app()->end();
	}
	
	public function actionCheckStatus($n)
	{
		$package_order = PackageOrders::model()->find("orders_id=:order_id", array(":order_id"=>$n));
		if(Yii::app()->request->isAjaxRequest && $package_order){
			$status = $package_order->status;		
			if($package_order->status == Packages::IN_PROGRESS)
			{
				echo '<span class="status label label-success">'. Packages::getStatusMessage($status) .'</span>';
			}
			else
			{
				echo '<span class="status label label-inverse">'. Packages::getStatusMessage($status) .'</span>';
			}
			Yii::app()->end();
		}
		
	}
	public function actionSendOrderMessage($id, $req_type)
	{
		//verify that the logged in user is the owner of the order
		$order = EtOrders::model()->findByPk($id);
		if($order)
		{
			$user = Miscellaneous::getEntrepreneur();			
			
			if(($user->id == $order->users_id) && ($req_type == "ajax"))
			{				
				$pom = new PackageOrderMsg();				
				$pom->etOrders_id = $id;
				$pom->message = $_POST['order_msg'];
				if(isset($_FILES['order_ar']))
				{
					$pom->scenario = 'upload';
					$_FILES['order_ar']['name'] = time()."_".$_FILES['order_ar']['name'];
					$pom->associated_resource = CUploadedFile::getInstanceByName('order_ar');
					$pom->associated_resource->saveAs(Yii::app()->basePath.'/../package_resources/'.$pom->associated_resource);
				}
				if($pom->save())
				{
					echo CJSON::encode(array("messageType"=>"success", "time"=>date('l, jS F Y \a\t g:i a', $pom->create_time))); 
					Yii::app()->end();
				}
				else
				{
					echo CJSON::encode(array("messageType"=>"error", "errors"=>$pom->errors));
					Yii::app()->end();
				}
			}
			else
			{
				throw new CHttpException(404, 'Invalid Request. Please do not repeat this request again');
			}
		}
		else 
			throw new CHttpException(404, 'Invalid Request. Please do not repeat this request again');
		
	}
	
	public function actionRequirement($id)
	{		
		$order_req = PackageOrderMsg::model()->with('order')->findByPk($id);
		
		if(!$order_req)
			throw new CHttpException(404, 'Invalid Request!');
		
		if(isset($_GET['req_type']) && $_GET['req_type'] == "ajax"){
			if(isset($_GET['c']))
			{
				if($_GET['c'] == "file_upload")
				{
					$order_req->scenario = 'upload';
					if(isset($_FILES['PackageOrderMsg']))
					{
						$_FILES['PackageOrderMsg']['name']['associated_resource'] = time()."_".$_FILES['PackageOrderMsg']['name']['associated_resource'];
					}
						
					$order_req->associated_resource = CUploadedFile::getInstance($order_req, 'associated_resource');
						
					if($order_req->validate(array('associated_resource'))){
						$order_req->save(false);
						
						$order_req->associated_resource->saveAs(Yii::app()->basePath . '/../package_resources/'.$order_req->associated_resource);
					
						echo CJSON::encode(array("messageType"=>"success"));						
					}
					else
					{
						echo CJSON::encode(array("messageType"=>"error", "errors"=>$order_req->errors));						
					}
					
					Yii::app()->end();
				}
				else if($_GET['c'] == "message")
				{
					if(isset($_POST['PackageOrderMsg']))
					{
						$order_req->attributes = $_POST['PackageOrderMsg'];
						if($order_req->save())
						{
							$order = $order_req->order;							
							if($order_req->message)
							{								
								$db = $order->getDbConnection();
								$command = $db->createCOmmand();
								$command->update('{{package_orders}}', 
										array(
											'status'=>Packages::IN_PROGRESS,
											'start_count'=>time(),
										),
										'orders_id=:order_id',										
											array(':order_id'=>$order->id)
										);
							}
							
							$time = date('l, jS F Y \a\t g:i a', $order_req->last_modified);							
							
							$po = PackageOrders::model()->with('package')->findByAttributes(array('orders_id'=>$order->id));
							
							echo CJSON::encode(array("messageType"=>"success", "last_modified"=>$time, "delivery"=>$po->package->delivery));
							
							Yii::app()->end();
						}
						else
						{
							echo CJSON::encode(array("messageType"=>"error", "errors"=>$order_req->errors));
							Yii::app()->end();
						}
					}					
				}
			
			}					
			
		}
		
	}
	// Uncomment the following methods and override them if needed

	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'accessControl',			
		);
	}
/**
	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}