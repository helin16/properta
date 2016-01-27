<?php
namespace App\Modules\Abstracts\Models;

class Blueprint extends \Illuminate\Database\Schema\Blueprint {
	public $status_string_length = 50;
	public $type_string_length = 50;
	public function baseEntityIdColumn() {
		$this->increments('id');
	}

	/**
	 * Add creation and update timestamps to the table.
	 *
	 * @return void
	 */
	public function basicEntityColumns()
	{
		$this->boolean('active');
		$this->timestamp('created');
		$this->unsignedInteger('created_by');
		$this->timestamp('updated');
		$this->unsignedInteger('updated_by');

		$this->index(['active'], 'active');
		$this->index(['created'], 'created');
		$this->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
		$this->index(['updated'], 'updated');
		$this->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');
	}
}
