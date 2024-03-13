<?php

/** Ask user for input path and concatenation character */
function askUser(){
    echo "\nWELCOME TO HTMLTOSTRING\n";
    echo " • Please provide the input file path (or leave it empty for the default):";
    $result['input'] = readline();
    echo " • Please provide the concatenation character (or leave it empty for the default [+]): ";
    $concatChar = readline();
    echo "\n";
    $directory = getcwd();
    $result['concat'] = $concatChar ? $concatChar : "+";
    return $result;
}

/** Open the input file. */
function openInputFile($filePath){
    $file = new SplFileInfo($filePath);
    if (!$file->isFile())
        throw new Exception("ERROR: File nont found ($filePath))");
    return new SplFileObject($filePath);
}

/** Create the output file. */
function createOutputFile($filePath){
    $file = new SplFileInfo($filePath);
    if ($file->isFile())
        unlink($filePath);

    if (!$file->isFile())
        if (!touch($filePath))
            throw new Exception("Error: fail to create output file.\n ");
    return new SplFileObject($filePath, "w");
}

function adaptSlashes($path){
    return str_replace("\\", "/", $path);
}

/** Cretae Default files.*/
function createDefaultFiles(){
    $inputPath = "./input.txt";
    $outputPath = "./output.txt";

    $input = new SplFileInfo($inputPath);
    $output = new SplFileInfo($outputPath);
    
    if ($output->isFile())
        unlink($outputPath);

    if (!$output->isFile())
        if (!touch($outputPath))
            throw new Exception("ERROR: fail to create output file.\n ", 1);
    
    if (!$input->isFile())
        if (touch($inputPath))
            die("input.txt file has been created in ($inputPath). Pleas insert your HTML code in it and execute the script again\n ");
    else
        throw new Exception("Error creating input file.\n ", 1); 

    $files['inputPath'] = $inputPath;
    $files['outputPath'] = $outputPath;
    $files['default'] = true;
    $files['input'] = new SplFileObject($inputPath);
    $files['output'] = new SplFileObject($outputPath, "w");
    return $files;
}

/** Conversion. Wrap each line in quotes and add the concat char at the end.*/
function makeConversion($files){
    while (!$files['input']->eof()) {
        $line = $files['input']->fgets();
        $line = rtrim($line, "\r\n");
        $line = str_replace("'", "\"", $line);
        if (!$files['input']->valid())
            $convertedLine = "'".$line."'";
        else 
            $convertedLine = "'".$line."'".$files['concat']."\n";
        $files['output']->fwrite($convertedLine);
    }
    $files['input'] = null;
    $files['output'] = null;
    return 0;
}

// Execution starts here.
try{
    $datas = askUser();
    if ($datas['input']){
        $inputPath = adaptSlashes($datas['input']);
        $files['inputPath'] = $inputPath;
        $files['input'] = openInputFile($inputPath);
        $files['outputPath'] = (dirname($inputPath)."/output.txt");
        $files['output'] = createOutputFile($files['outputPath']);
    } else {
       $files = createDefaultFiles();
       $input = $files['input'];
       $output = $files['output'];
    }
    $files['concat'] = $datas['concat'];
    if ($files['input']->getSize() <= 0)
        throw new Exception("  Input file is empty. Make sure you place your text in it.\n\n");
    if (makeConversion($files) != 0)
        throw new Eception("ERROR: fail to convert. Sorry try again\n");
    if (isset($files['default'])) unlink($files['inputPath']);
    die("SUCCESS.\n  Your result is in ".$files['outputPath']."\n\nThanks for using htmlToString.\n\n");
}catch(Exception $e){
    echo $e->getMessage();
}

?>