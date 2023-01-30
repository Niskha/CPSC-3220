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
				$contents = trim($contents);
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
		$last_names = parseFile("last_names.txt",0,"\n");
		
		//street_names.txt | ":" and newline is the delimiter
		$street_names = parseFile("street_names.txt",0,":","\r\n");
		
		//street_types.txt | "..;" is the delimiter\
		$street_types = parseFile("street_types.txt",0,"..;");
		
		//Make an array fixing the domain names in domains
		
		$domain = array();
		for($i = 0; $i < (count($domains)-1);$i+=2){
			$domain[] = $domains[$i].".".$domains[$i+1];
		}
		
		//Make an array uniqueIdentity() that is all of the combinations of first_names and last_names.
		$unique_identity = array();
		foreach($first_names as $first){
			foreach($last_names as $last){
				$last = trim($last);
				$unique_identity[] = $first." ".$last;	
			}
		}

		//Make an array uniqueAddress() that is all of the combinations of street_name and street_type.
		$unique_address = array();
		foreach($street_names as $name){
			foreach($street_types as $type){
				$unique_address[] = $name." ".$type;
			}
		}
		
		/*Generate Random Array of People*/
		function generateCustomers(array $unique_identity, array $unique_address, array $domain, int $amount){
			//this should make sure that there is never more requested customer generation than possible to generate.
			if(count($unique_identity) < $amount){
				throw new Exception('Out of bounds.');
			}
			$max_identity = count($unique_identity)-1;
			$max_address = count($unique_address)-1;
			$customer = array();
			$i = 0;
			while($i!=$amount){
				//random selection
				//add identity to customer array
				$random_identity_index = rand(0,$max_identity--);
				$customer[] = [$unique_identity[$random_identity_index]];
				
				//add address to customer array
				$random_address_index = rand(0,$max_address--);
				$customer[] = [$unique_address[$random_address_index]];
				
				//add email address by concatinating identity and domain
				$domain_index = rand(0,count($domain)-1);
				$email = str_replace(" ",".",$unique_identity[$random_identity_index]);
				$customer[] = [$email."@".$domain[$domain_index]];
				//remove identity index 
				unset($unique_identity[$random_identity_index]);
				$unique_identity = array_values($unique_identity);
				//remove address index
				unset($unique_address[$random_address_index]);
				$unique_address = array_values($unique_address);
				$i++;
			}
			return $customer;
		}
		
		try{
			$customer = generateCustomers($unique_identity,$unique_address,$domain,25);
			foreach($customer as $data){
				foreach($data as $info){
					echo $info." ";
				}
			}
		} catch(Exception $e){
			echo "Exception: ".$e->getMessage();
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
