# HTML TO STRING

This is a little designed to convert HTML markup into a string representation by encapsulating each HTML element within single quotes and concatenating them (using + sign to concat) to form a well-formatted string. This conversion process allows developers to transform HTML content into a format that can be easily manipulated, processed, or stored as a string variable in a programming context.

The conversion script iterates through each HTML element, including the opening and closing tags, replace single quotes with double quotes. And wraps each HTML element with single quotes. The resulting string preserves the structure of the original HTML, maintaining the hierarchy and individual elements. This script provides a practical solution for scenarios where representing HTML as a string is beneficial, such as when integrating HTML content within JavaScript code or handling HTML data in a string format. Useful for email templates for example.

## Requirements
- php

## Clone Repository
 ~~~~
 haha
 ~~~~

## Usage
 - Clone the repository.
 - Navigate to the project directory: `cd htmlToStringConverter`.
 - Execute php htmlToStringConverter.php.
 - Insert an input file or leave it empty to use the default.     
 - Insert an output file or leave it empty to use the default.     
 - Insert a concatenation character or leave it empty to use the default (+).     
 
  If you use custom input/output with your conversion should be done.
  Else continue with next steps.

 - Place the HTML you want to convert in input file.
 - Execute php htmlToStringConverter.php again.
 - This should create an output file with the result.