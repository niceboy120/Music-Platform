<?php

class Create_Users_Table{

		
				
 	public function up()
	{
			
		Schema::create('users', function($table){

		 	$table->increments('id');
 			$table->string('username', 100);
 			$table->string('email', 100);
 			$table->string('password', 100);
 			$table->string('salt', 100);
 			$table->boolean('banned');
 			$table->boolean('activated');
 			$table->text('user_data');
 			$table->timestamps();
 		});
	}
				
}