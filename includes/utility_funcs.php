<?php

function sanitize($text) {
   return htmlspecialchars($text, ENT_COMPAT|ENT_HTML5, 'UTF-8', false);
}


//Function to Insert <p> Tags
function convertToParas($text) {
  $text = trim($text);
  $text = htmlspecialchars($text, ENT_COMPAT|ENT_HTML5, 'UTF-8', false);
  return '<p>' . preg_replace('/[\r\n]+/', "</p>\n<p>", $text) . "</p>\n";
}

//Extracting sentences (441)
function getFirst($text, $number=2) {
    // use regex to split into sentences
    $sentences = preg_split('/([.?!]["\']?\s)/', $text, $number+1, PREG_SPLIT_DELIM_CAPTURE);
    if (count($sentences) > $number * 2) {
        $remainder = array_pop($sentences);
    } else {
        $remainder = '';
    }
    $result = [];
    $result[0] = implode('', $sentences);
    $result[1] = $remainder;
    return $result;
}

//validating the input and formating the date correctly.(451)
function convertDateToISO($month, $day, $year) {
    $month = trim($month);
    $day = trim($day);
    $year = trim($year);
    $result[0] = false;
    if (empty($month) || empty($day) || empty($year)) {
        $result[1] = 'Please fill in all fields';
	} elseif (!is_numeric($month) || !is_numeric($day) || !is_numeric($year)) {
        $result[1] = 'Please use numbers only';
    } elseif (($month < 1 || $month > 12) || ($day < 1 || $day > 31) || ($year < 1000 || $year > 9999)) {
        $result[1] = 'Please use numbers within the correct range';
    } elseif (!checkdate($month,$day,$year)) {
        $result[1] = 'You have used an invalid date';
    } else {
        $result[0] = true;
        $result[1] = sprintf('%d-%02d-%02d', $year, $month, $day);
    }
    return $result;
}

function getFirstLetter($text) {
    // Remove any leading/trailing whitespace and ensure the text is not empty
    $trimmedText = trim($text);
    if (empty($trimmedText)) {
        return null; // or return an empty string, depending on your use case
    }

    // Split the text into an array of words
    $words = preg_split('/\s+/', $trimmedText);

    // Get the first word
    $firstWord = $words[0];

    // Get the first character from the first word
    $firstLetter = mb_substr($firstWord, 0, 1);

    return $firstLetter;
}

function removeFirstWord($text) {
    // Remove any leading/trailing whitespace and ensure the text is not empty
    $trimmedText = trim($text);
    if (empty($trimmedText)) {
        return $text; // If the input is empty or contains only whitespace, return it as is
    }

    // Split the text into an array of words
    $words = preg_split('/\s+/', $trimmedText);

    // Remove the first word from the array
    array_shift($words);

    // Reconstruct the sentence without the first word
    $newText = implode(' ', $words);

    return $newText;
}

function removeFirstLetter($text) {
    // Remove any leading/trailing whitespace and ensure the text is not empty
    $trimmedText = trim($text);
    if (empty($trimmedText)) {
        return $text; // If the input is empty or contains only whitespace, return it as is
    }

    // Get the substring starting from the second character (index 1) until the end of the text
    $newText = mb_substr($trimmedText, 1);

    return $newText;
}



// Function to calculate and format the time elapsed
function getTimeElapsed($timestamp) {
    $currentTimestamp = time(); // Current UNIX timestamp
    $commentTimestamp = strtotime($timestamp); // Convert the database timestamp to UNIX timestamp

    $timeElapsed = $currentTimestamp - $commentTimestamp;

    if ($timeElapsed < 60) {
        return $timeElapsed . 's'; // Seconds
    } elseif ($timeElapsed < 3600) {
        return floor($timeElapsed / 60) . 'min'; // Minutes
    } elseif ($timeElapsed < 86400) {
        return floor($timeElapsed / 3600) . 'h'; // Hours
    } elseif ($timeElapsed < 604800) {
        return floor($timeElapsed / 86400) . 'd'; // Days
    } elseif ($timeElapsed < 2592000) {
        return floor($timeElapsed /  604800) . 'w'; // Weeks
    } elseif ($timeElapsed < 31536000) {
        return floor($timeElapsed / 2592000) . 'mo'; // Months
    } else {
        return floor($timeElapsed / 31536000) . 'y'; // Years
    }
}



?>