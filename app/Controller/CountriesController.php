<?php
class CountriesController extends AppController {
	public function Country()
	{
	
	$Country= $this->Country->find('all');
	$this->set('Country', $Country);
	print_r($Country);
	}
	
}
?>