<?php

class Create_Tracks_Table {
	
	/**
	 * Make changes to the database.
	 *
	 * @return void
	 */
	public function up()
	{
		//
		Schema::create('tracks', function($table){

			// The autoincrement id.
			$table->increments('id');
			// The admin who posted the track.
			$table->integer('admin_id');
			// The many-to-many relationship.
			$table->integer('track_artist_id');
			// The tracks title.
			$table->string('title', 65);
			//A Key that will change daily or every hour.
			$table->string('key', 126); // <-- This becomes the new id!
			// The status of the file. (Free == 0, Purchase == 1)
			$table->integer('status');
			// The result of the status. 
			$table->string('result_purchase_url', 126);
			// The result of the status.
			$table->string('result_download_url', 126); // <-- This becomes the controller & model url for the track. This is a dynamic allocation. E.g (controller@model) -> download@index
			// The playing controller.
			$table->string('player_download_url', 126); // <-- This becomes the controller & model url for the track. This is a dynamic allocation. E.g (controller@model) -> download@index
			$table->timestamps();
		});
	}

	/**
	 * Revert the changes to the database.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}