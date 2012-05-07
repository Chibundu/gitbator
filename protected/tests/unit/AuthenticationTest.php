<?php
/**
 * UserIdentity test case.
 */
class AuthenticationTest extends CDbTestCase {
	private $auth;
	/**
	 * @var UserIdentity
	 */
	private $UserIdentity;
	public $fixtures = array('teamMembers'=>'Teammembers');
	public $teamMember;
	
	/**
	 * Prepares the environment before running a test.
	 */	
	protected function setUp() {		
		parent::setUp ();	
		
		$this->teamMember = $this->teamMembers('teammember1');
		$this->UserIdentity = new UserIdentity($this->teamMember->email, 'excellence123');	

	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->UserIdentity = null;		
		parent::tearDown ();
	}
	
	/**
	 * Constructs the test case.
	 */
	public function __construct() {
		
	}
	
	/**
	 * Tests UserIdentity->authenticate()
	 */
	public function testAuthenticate() {
		 	
		$this->assertTrue($this->UserIdentity->authenticate(), 'Cannot validate that authentication is working well.');	
	}	
	
	
	
	
	
}

