<?php
/**
 * OrderHelper test case.
 */
class OrderHelperTest extends CDbTestCase {
	
	/**
	 *
	 * @var OrderHelper
	 */
	private $OrderHelper;
	
	public $fixtures = array(
				'serviceproviders'=>'Serviceproviders',
				'orders'=>'SpOrder',
			);
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();	 
		
		// TODO Auto-generated OrderHelperTest::setUp()
		
		$this->OrderHelper = new OrderHelper(/* parameters */);
		
	
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		// TODO Auto-generated OrderHelperTest::tearDown()
		
		$this->OrderHelper = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		// TODO Auto-generated constructor
	}
	
	/**
	 * Tests OrderHelper::takeOrders()
	 */
	public function testTakeOrders() {
				
		$orderConfig = array(
				'user_type'=>'SP', 
				'user_id'=>1,
				'orders'=>array(
						array(
							'item'=>SaleItems::PACKAGE_FEATURE,
							'description'=>"bla, bla, bla",
							'currency_id'=>3,
							'unit_price'=>200,
							'quantity'=>2,
							'discount'=>25,
						),
						array(
							'item'=>SaleItems::PACKAGE_FEATURE,
							'description'=>"bla, bla, bla",
							'currency_id'=>3,
							'unit_price'=>200,
							'quantity'=>2,
							'discount'=>25,
						),
						
					),
				);
		
		$sp = $this->serviceproviders('sp1');
		
		
		$order_ids = OrderHelper::takeOrders($orderConfig);
		
		$order1 = SpOrder::model()->findByPk($order_ids[0]);
		$order2 = SpOrder::model()->findByPk($order_ids[1]);
		
		$this->assertTrue($order1->item == $orderConfig['orders'][0]['item'], 'Cannot validate OrderHelper::takeOrders: Does not store order item correctly!');
		$this->assertTrue($order1->description == $orderConfig['orders'][0]['description'], 'Cannot validate OrderHelper::takeOrders: Does not store order description correctly!');
		$this->assertTrue($order1->currencies_id == $orderConfig['orders'][0]['currency_id'], 'Cannot validate OrderHelper::takeOrders: Does not store order currency correctly!');
		$this->assertTrue($order1->unit_price == $orderConfig['orders'][0]['unit_price'], 'Cannot validate OrderHelper::takeOrders: Does not store order unit price correctly!');
		$this->assertTrue($order1->qty == $orderConfig['orders'][0]['quantity'], 'Cannot validate OrderHelper::takeOrders: Does not store order quantity correctly!');
		$this->assertTrue($order1->discount == $orderConfig['orders'][0]['discount'], 'Cannot validate OrderHelper::takeOrders: Does not store order discount correctly!');
		
		$this->assertTrue($order2->item == $orderConfig['orders'][1]['item'], 'Cannot validate OrderHelper::takeOrders: Does not store order item correctly!');
		$this->assertTrue($order2->description == $orderConfig['orders'][1]['description'], 'Cannot validate OrderHelper::takeOrders: Does not store order description correctly!');
		$this->assertTrue($order2->currencies_id == $orderConfig['orders'][1]['currency_id'], 'Cannot validate OrderHelper::takeOrders: Does not store order currency correctly!');
		$this->assertTrue($order2->unit_price == $orderConfig['orders'][1]['unit_price'], 'Cannot validate OrderHelper::takeOrders: Does not store order unit price correctly!');
		$this->assertTrue($order2->qty == $orderConfig['orders'][1]['quantity'], 'Cannot validate OrderHelper::takeOrders: Does not store order quantity correctly!');
		$this->assertTrue($order2->discount == $orderConfig['orders'][1]['discount'], 'Cannot validate OrderHelper::takeOrders: Does not store order discount correctly!');
	
	}
	
	/**
	 * Tests OrderHelper::parsePOI()
	 */
	public function testParsePOI() {
		// TODO Auto-generated OrderHelperTest::testParsePOI()
		
		$poi = 'SP-2:4:6';
		
		$expected = array('user_type'=>'SP', 'order_ids'=>array(2,4,6), 'Cannot validate OrderHelper::parsePOI: returns unexpected results: Expected: $expected, Actual: $actual');
		
		OrderHelper::parsePOI($poi);
	
	}
	
	/**
	 * Tests OrderHelper::getPOI()
	 */
	public function testGetPOI() {
		// TODO Auto-generated OrderHelperTest::testGetPOI()		
		$user_type = 'SP';
		$order_ids = array(2,4,6);		
		
		$actual = OrderHelper::getPOI($user_type, $order_ids);
		$expected = 'SP-2:4:6';
		
		$this->assertEquals($expected, $actual, 'Cannot validate OrderHelper::getPOI: returns unexpected results: Expected: $expected, Actual: $actual');
	
	}

	
	/**
	 * Tests OrderHelper::getOrderTotal()
	 */
	public function testGetOrderTotal() {
		// TODO Auto-generated OrderHelperTest::testGetOrderTotal()				
		$orders = array(
				array(
						'quantity'=>4,
						'unit_price'=>50,
						'discount'=>25,
				),
				array(
						'quantity'=>2,
						'unit_price'=>50,
						'discount'=>25,
				),
		);
		$actual = OrderHelper::getOrderTotal($orders);
		$expected = 225;
		$this->assertEquals($expected, $actual, "Cannot validate OrderHelper::getOrderTotal: Expected = $expected, Actual = $actual");		
	
	}
	
	public function testGetOrderSummary()
	{
		$orders = array(
				array(
						'quantity'=>4,
						'unit_price'=>50,
						'discount'=>25,
						'item'=>SaleItems::PACKAGE_FEATURE,
						'description'=>'bla, bla, bla'
				),
				array(
						'quantity'=>2,
						'unit_price'=>50,
						'discount'=>25,
						'item'=>SaleItems::PACKAGE_FEATURE,
						'description'=>'bla, bla, bla'
				),
		);
		
		$summary = OrderHelper::getOrderSummary($orders);
		                                 
		$this->assertEquals(OrderHelper::getOrderTotal($orders), $summary['total'], "Cannot validate OrderHelper::getOrderSummary: Unexpected 'total' returned");
		$this->assertEquals('bla, bla, bla + bla, bla, bla', $summary['descriptions'], "Cannot validate OrderHelper::getOrderSummary: Unexpected 'descriptions' returned");
		$this->assertEquals(SaleItems::PACKAGE_FEATURE.' + '.SaleItems::PACKAGE_FEATURE, $summary['items'], "Cannot validate OrderHelper::getOrderSummary: Unexpected 'items' returned");
	}

}

