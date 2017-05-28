<?php
	echo implode(',', ($_header) ). "\n";

	$fp = fopen('php://temp', 'w+');

	foreach ($data as $fields) {
		$row = $fields->toArray();
	    // Add row to CSV buffer
	    fputcsv($fp, $row);
	}

	rewind($fp); // Set the pointer back to the start
	$csv_contents = stream_get_contents($fp); // Fetch the contents of our CSV
	fclose($fp); // Close our pointer and free up memory and /tmp space

	// Handle/Output your final sanitised CSV contents
	echo $csv_contents;
?>