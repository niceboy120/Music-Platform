<?php

class Create_Tracks_Table{

		
				
 	public function up()
	{
			
		Schema::create('tracks', function($table){

		 	$table->increments('id');
 			$table->integer('admin');
 			$table->integer('status');
 			$table->string('title', 100);
 			$table->string('track_artist', 100);
 			$table->string('urlkey', 166);
 			$table->string('result_purchase_url', 100);
 			$table->string('result_download_url', 100);
 			$table->string('player_download_url', 100);
 			$table->timestamps();
 		});
	}
				
}