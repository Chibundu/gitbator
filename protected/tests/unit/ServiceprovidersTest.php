<?php
/**
 * Serviceproviders test case.
 */
class ServiceprovidersTest extends CDbTestCase {
	
	/**
	 * @var Serviceproviders
	 */
	private $Serviceproviders;
	public $fixtures = array('serviceProvider'=>'Serviceproviders');
	
	/**
	 * Prepares the environment before running a test.
	 */
	protected function setUp() {
		parent::setUp ();
		$this->Serviceproviders = $this->serviceProvider('sp1');	
	}
	
	/**
	 * Cleans up the environment after running a test.
	 */
	protected function tearDown() {
		$this->Serviceproviders = null;
		
		parent::tearDown ();
	}
	
	/**
	 * Tests Serviceproviders->storeSkills()	 * 
	 */
	public function testStoreSkills() {
		
		$skills = ",Photoshop, Fireworks, Dreamweaver,";		
		$skills_ = ",Fireworks, Dreamweaver, SomethingElse";		
		$this->Serviceproviders->skills = $skills;
		
		//ensures that duplicates were avoided - remember 'Fireworks' is already in the fixture table
		$expected = 2;
		$actual = $this->Serviceproviders->storeSkills();		
		$this->assertEquals($expected, $actual);		
		//we assert that the right number of skill exists for this provider
		$expected = 3;
		$sp = Serviceproviders::model()->findByPk($this->Serviceproviders->id);
		$this->assertEquals($expected, count($sp->skillSet));
		
		
		
	}	
	public function testGetSkillset()
	{		
		$this->assertEquals(3, count($this->Serviceproviders->skillSet));
	
	}
	//Tests that all skills relevant to a particular service provider are deleted neatly - i.e without affecting other providers' skills
	public function testDeleteAllSkills()
	{
		$anotherProvider = $this->serviceProvider('sp2');
		$this->assertEquals(4, count($anotherProvider->skillSet));
		$anotherProvider->deleteAllSkills();
		$anotherProvider = Serviceproviders::model()->findByPk($anotherProvider->id);
		$this->assertEquals(0, count($anotherProvider->skillSet));		
		//we ensure that all skills previously stored for sp1 are intact
		$expected = 3;
		$sp = Serviceproviders::model()->findByPk($this->Serviceproviders->id);
		$this->assertEquals($expected, count($sp->skillSet));
	}
	public function testGetSkills()
	{
		$this->Serviceproviders->skills = ",Photoshop, Fireworks, Dreamweaver,";
		$this->Serviceproviders->storeSkills();
		$sp = Serviceproviders::model()->findByPk($this->Serviceproviders->id);					
		
		$expected = "Photoshop, Fireworks, Dreamweaver";
		$actual = $sp->getSkills();		
		$this->assertEquals($expected, $actual,"Skills are not returned in the right format");
	}
	public function testGetServices()
	{
		$expected = "Web Programming, Web Design, Mobile Apps, Applications Development, Search Engine Optimization";
		$actual = $this->Serviceproviders->getServices();
		$this->assertEquals($expected, $actual,"Services are not returned in the proper format");
	}
	public function testStoreKeywords()
	{
		$keywords = ",Flash, Flex, Animations, ";	
		$keywords_ = ",Flash, Cartoons";	
		$this->Serviceproviders->keywords = $keywords;
		$this->Serviceproviders->storeKeywords();
		
		
		//tests to see that the right amount of keywords exist
		$expected = 3;
		$sp = Serviceproviders::model()->findByPk($this->Serviceproviders->id);
		$actual = count($sp->keywordSet);
		$this->assertEquals($expected, $actual);
		
		
		//test to see if duplicates are avoided(we use this method since there are no fixtures)
		$anotherProvider = $this->serviceProvider('sp2');
		$anotherProvider->keywords = $keywords_;
		$expected = 1;
		$actual = $anotherProvider->storeKeywords();
		
		$this->assertEquals($expected, $actual);		
		
		//ensure that we still have the right number of keywords associated with this user
		$anotherProvider = Serviceproviders::model()->findByPk($anotherProvider->id);
		$expected = 2;
		$this->assertEquals($expected, count($anotherProvider->keywordSet));
	}
	public function testGetKeywords()
	{
		$expected = "Flash, Flex, Animations";
		$actual =  $this->Serviceproviders->getKeywords();
		$this->assertEquals($expected, $actual);	
	}
	public function testDeleteKeywords()
	{
		$anotherProvider = $this->serviceProvider('sp2');
		$anotherProvider->keywords = "Flash,";
		$anotherProvider->storeKeywords();		
		$this->Serviceproviders->deleteKeywords();
		$expected = 0;
		$this->Serviceproviders->refresh();
		
		$actual = count($this->Serviceproviders->keywordSet);		
		$this->assertEquals($expected, $actual);
		
		$expected = 1;
		$anotherProvider->refresh();
		$actual = count($anotherProvider->keywordSet);		
		$this->assertEquals($expected, $actual, "My keyword suddenly vanished!");
		
	}
	
	public function testgetVerificationCount()
	{
		$this->assertTrue((bool)$this->Serviceproviders->verification->email);
		$this->assertFalse((bool)$this->Serviceproviders->verification->identity);
		$this->assertFalse((bool)$this->Serviceproviders->verification->phone);
		$this->assertEquals(0, count($this->Serviceproviders->verifiedQualifications));
		$this->assertEquals(0, count($this->Serviceproviders->unverifiedQualifications));
		
		$expected = 1;
		$actual = $this->Serviceproviders->getVerificationCount();
		$this->assertEquals($expected, $actual, "Expected: $expected, Actual : $actual");
	}
	
	public function testPaths()
	{
		$this->assertFileExists(Miscellaneous::getLogoPath());
		$this->assertFileExists(Miscellaneous::getProfilePicturePath());		
	}
}

