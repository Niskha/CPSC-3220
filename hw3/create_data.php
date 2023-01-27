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
					$contents = str_replace($homogenizer, $delimiter,$contents);
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
		$domains = array();
		$domains = parseFile("domains.txt", 0 , ".");
		
		//first_names.csv | excel spreadsheet
		$first_names = array();
		$first_names = parseFile("first_names.csv", 1);
		
		//last_names.txt | newline is the delimiter
		$last_names = array();
		$last_names = parseFile("last_names.txt",0);
		
		//street_names.txt | ":" and newline is the delimiter
		$street_names = array();
		$street_names = parseFile("street_names.txt",0,":","\r\n");
		
		//street_types.txt | "..;" is the delimiter\
		$street_types = array();
		$street_types = parseFile("street_types.txt",0,"..;");
		
		/*Table Generation | generate randomized data for 25 people, people must be unique 
		and address must be unique*/
		// Print a heading above each array | use the <pre></pre> tag and utilize print_r()
    
		/*Export Data to customers.txt | 
		Format: first_name:last_name:street_name + street_type:email(domains + '.com') | deliminator is ':'
		*/
    ?>
  </body>
</html>
