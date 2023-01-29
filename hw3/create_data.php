<!Doctype html>
<html>
  <head>
    <link rel = "stylesheet" type ="text/css" href = "create_data.css">
    <title>Create Data</title>
  </head>
  <body>
    <h1>Data Generation</h1>
    <hr/>
    <?php
		/*File IO and data extraction
		5 different files and formats
		*/
		// $filetype = 0 for .txt and 1 for .csv
		function parseFile(string $filename, int $filetype, string $delimiter = "\r\n", string $homogenizer = Null){
			$parsedfile = array();
			// .txt file
			if($filetype == 0){
				$contents = file_get_contents($filename);
				if ($homogenizer != Null){
					$contents = str_replace($homogenizer,$delimiter,$contents);
				}
				$parsedfile = explode($delimiter,$contents);
				return $parsedfile;
			}
			// .csv file
			else if($filetype == 1){
				$file = fopen($filename,'r');
				$parsedfile = fgetcsv($file);
				fclose($file);
				return $parsedfile;
			}
			else return $parsedfile;
		}
		//domains.txt | "." is the deliminator
		$domains = parseFile("domains.txt", 0 , ".");
		
		//first_names.csv | excel spreadsheet
		$first_names = parseFile("first_names.csv", 1);
		
		//last_names.txt | newline is the delimiter
		$last_names = parseFile("last_names.txt",0);
		
		//street_names.txt | ":" and newline is the delimiter
		$street_names = parseFile("street_names.txt",0,":","\r\n");
		
		//street_types.txt | "..;" is the delimiter\
		$street_types = parseFile("street_types.txt",0,"..;");
		
		//Make an array fixing the domain names in domains
		$domain = array();
		foreach($domains as $element){
			$domain = $element
		}
		
		//Make an array uniqueIdentity() that is all of the combinations of first_names and last_names.
		$unique_identity = array();
		foreach($first_names as $first){
			foreach($last_names as $last){
				$unique_identity = $first." ".$last;
			}
		}
		
		echo count($unique_identity);
		//Make an array uniqueAddress() that is all of the combinations of street_name and street_type.
		$unique_address = array();
		foreach($street_names as $name){
			foreach($last_names as $type){
				$unique_address = $name." ".$type;
			}
		}
		
		echo count($unique_address);
		/*Generate Random Array of People*/
		function generateCustomers(array $unique_identity, array $unique_address, array $domains, int $amount{
			if(count($unique_identity) * count($unique_address) < $amount){
				throw new Exception('Out of bounds.');
			}
			$customer = array();
			$i = 0;
			while($i!=$amount){
				
				$i++;
			}
			return $customer
		}
		
		try{
			$customer = generateCustomers();
		} catch(Exception $e){
			echo "Exception: ".$e->getMessage()."\n";
		}
		
		/*Table Generation | generate randomized data for 25 people, people must be unique 
		and address must be unique*/
		// Print a heading above each array | use the pre tag and utilize print_r() for element generation
		
		//heading table
		echo "<table class = 'header_table'><tr><th>First Name</th><th>Last Name</th><th>Address</th><th>Email</th></th></table>";
    
		/*Export Data to customers.txt | 
		Format: first_name:last_name:street_name + street_type:email(domains + '.com') | deliminator is ':'
		*/
    ?>
  </body>
</html>
