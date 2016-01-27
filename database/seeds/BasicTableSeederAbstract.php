<?php
abstract class BasicTableSeederAbstract extends \Illuminate\Database\Seeder {
	protected $_entityName = '';
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		factory($this->_entityName, 50)->create();
	}
}