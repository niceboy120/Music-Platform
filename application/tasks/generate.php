<?php

/**
 * @copyright  2012 TheHydroImpulse, Daniel Fagnan
 * @version  0.1
 * @todo  Add an overwite ability. Among other things.
 * @note Use this as you wish. Extend it, Mash it. Enjoy it.
 */


/**
 * Generate Task
 * Methods: Help, Controller, Model
 * 	Controller -> generates a new controller with empty methods if specified.
 *  Model  	   -> generates a migration for the new table, and a model file for the new table.
 *  Help       -> Displays the commands.
 */
class Generate_Task {

	public function run($arguments)
	{
		//Run the help;
		$this->help($arguments);
	}

	public function help($arguments)
	{
		// Print out the help;
		echo "\n\n======== Generate Help =========
				\n controller  => :name, (:methods) \n Creates a new controller.
				\n model 	   => :name, (colum_name:type[numeric_length])
				\n scaffolding => TODO
		      \n\n============ End ===============
		";
	}

	/**
	 * Generates a new controller.
	 * @param  Array $arguments Contains the name and methods.
	 * @return 
	 */
	public function controller($arguments)
	{
		// Make sure there are arguments. Minimum is the name.
		if(count($arguments) == 0)
		{
			// Exit;
			echo "Error: No arguments given.";
			return false;
		}

		// Create the new controller file name.
		$filename = $arguments[0]. ".php";
		// Create a CamelCase class name and it's suffix.
		$name = ucfirst($arguments[0]) . '_Controller';
		// Delete it from the array so 
		// we can loop through the rest of the 
		// arguments later.
		unset($arguments[0]);

		// Make sure there are more arguments.
		if(count($arguments) !== 0)
		{
			// Create the methods string.
			$methods = '';
			// Loop through the rest of the arguments.
			foreach($arguments as $m)
			{
				// Seperate the argument with a ":". Right Side == Action (e.i action, post, get, put) Left Side == Method name.
				$explode 	 = explode(':', $m);
				// Get the method_name as the first index.
				$method_name = $explode[0];
				// Get the action for the second index, by default it's action
				// if none are presented.
				$action      = (isset($explode[1])) ? $explode[1] : 'action';
				// Create the method with the action and method name.
				$methods .= "
				\n 		public function ".$action."_$method_name()
		{

		}
				";
			} // ./foreach
		} // ./if

		// Create the beginning of the controller file with the class extending the base_controller.
		// TODO: Add an option to extend a custom class???
		$controller = "<?php
			\nclass $name extends Base_Controller{ $methods
			\n}

		";

		// Create the new path for the controller, and append the filename we 
		// created earlier.
		$path = realpath(dirname(__FILE__) . '\\..\\controllers\\') . '\\' . $filename;
		// Check if the file exists or not.
		// TODO: Add an overwrite ability.
		if(!file_exists($path))
		{
			// Create the file.
			file_put_contents($path, $controller);
		}
		else
		{
			// Exit;
			echo "Controller already exists.";
			// TODO: Add an overwrite ability.
		}
	}

	/**
	 * Generates a new controller.
	 * @param  Array $arguments Contains the name and fields.
	 * @return 
	 */
	public function model($arguments)
	{
		// Check if there are any arguments.
		if(count($arguments) == 0)
		{
			// Exit;
			echo "Error: No arguments given.";
			return false;
		}

		// Create the filename with the first argument being the name of the model.
		$filename = $arguments[0]. ".php";
		// Create half of the migration filename. We will need to prefix it with  // the date and the path.
		$mfilename = 'create_' . Str::plural(strtolower($arguments[0])). "_table.php";
		// Get a CamelCase version of the name for the class name.
		$name = ucfirst($arguments[0]);
		// Get a plural definition of the name.
		$uname = Str::plural($arguments[0]);
		// Delete it from the array so we can loop through the rest of the arguments.
		unset($arguments[0]);

		// Create a new schema. With the plural name of the model for the table.
		$schema = '
		Schema::create(\''.$uname.'\', function($table){

		';

		// Create the migration beginning. With a class.
		$migration = "<?php

class Create_".$name."s_Table{

		";
		// Check to see if there are any arguments passed.
		if(count($arguments) !== 0)
		{
			// Set the fields variable.
			$fields = null;
			// Append an increment 'id'. This is set on ALL tables by default.
			$fields .= " 	\$table->increments('id');";
			//Loop through each arguments to set their schema and properties.
			foreach($arguments as $m)
			{
				// Seperate the argument by a ":". Left Side == Value, Right Side == Type.
				$explode 	 = explode(':', $m);
				// Set the field name to the first index.
				$field_name = $explode[0];
				// Set the type to the second index if it's available. Otherwise default to a 'string'.
				$type      = (isset($explode[1])) ? $explode[1] : 'string';
				// Getting the length:
				$length_explode = explode("[", $type);
				$type = $length_explode[0];
				/**
				 * If there's more than one index, that means they included a       * length delimeter.
				 */
				if(count($length_explode) > 1)
				{
					//Yup there's a length! But replace the last "]" with blank.
					$length = str_replace("]", "", $length_explode[1]);
					if(!is_numeric($length))
						unset($length);
				} // ./count

				// Check which type and use the following code.
				
				switch($type)
				{
					case "integer":
						$default_length = (isset($length) && is_numeric($length)) ? $length : 11;
						if(!isset($length))
							$fields .= "\n 			\$table->integer('$field_name');";
						else
							$fields .= "\n 			\$table->integer('$field_name', $length);";
					break;
					case "string":
						$default_length = (isset($length) && is_numeric($length)) ? $length : 100;
						if(!isset($length))
							$fields .= "\n 			\$table->string('$field_name', $default_length);";
						else
							$fields .= "\n 			\$table->string('$field_name', $default_length);";
					break;
					case "boolean":
						$fields .= "\n 			\$table->boolean('$field_name');";
					break;
					case "timestamp":
						$fields .= "\n 			\$table->timestamp('$field_name');";
					break;
					case "text":
						if(!isset($length))
							$fields .= "\n 			\$table->text('$field_name');";
						else
							$fields .= "\n 			\$table->text('$field_name', $length);";
					break;
					case "blob":
						$fields .= "\n 			\$table->blob('$field_name');";
					break;
					case "float":
						$fields .= "\n 			\$table->float('$field_name');";
					break;
					case "date":
						$fields .= "\n 			\$table->date('$field_name');";
					break;
				} // ./switch
				unset($length);
			} // ./foreach

			// Add the timestamps;
			$fields .= "\n 			\$table->timestamps();";

			// Append the fields set in the switch statement to the schema block.
			$schema .= $fields;
		} // ./if

		// Append the closing }, and ) for the closure, and function call.
		$schema .= "\n 		});";
	
		// Append the "up" method that now contains the newly
		// created schema.
		$migration .= "
				\n 	public function up()
	{
			$schema
	}
				";
		
		// Append the migration file with a closing "}", which ends the class.
		$migration .= "\n}";

		// Get the path to the migration folder, and create the new file name by 
		// prefixing the current date to the file.
		$mpath = realpath(dirname(__FILE__) . '\\..\\migrations\\') . '\\' . date('Y_m_d_His') . "_" . $mfilename;

		// Check if the file already exists, which will always return false
		// since the date and time will always be different. 
		// TODO: Find a better way???
		if(!file_exists($mpath))
		{
			// Write the new migration file.
			file_put_contents($mpath, $migration);
		}
		else
		{
			// The migration file has already been created.
			// This will always return FALSE right now.
			echo "The migration already exists.";
			// Close.
			return;
		}

		/**
		 * Next Step: Create the model file.
		 */

		// Start the file with a php tag and the opening class with the model name.
		$model = "<?php
			\nclass $name extends Eloquent{
			\n}

		";

		// Find the path to the models directory, and append the new file name.
		$path = realpath(dirname(__FILE__) . '\\..\\models\\') . '\\' . $filename;
		
		// Check if the model has already been created.
		// Return false if it has.
		// TODO: Maybe add an overwrite option??
		// TODO: Delete the previously created migration file, if the model
		// creation fails.
		if(!file_exists($path))
		{	
			// Create the new model file.
			file_put_contents($path, $model);
		}
		else
		{
			// Ooops.
			echo "Model already exists.";
			// TODO: Add the overwrite command???
		}

	}

}