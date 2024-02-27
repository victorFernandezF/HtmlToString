<?php

function askUser(){
    echo "Input file (empty for default): ";
    $inputPath = readline();
    echo "Output file (empty for default): ";
    $outputPath = readline();
    echo "concatenation character (default +): ";
    $concatChar = readline();
    echo "\n";
    $directory = getcwd();
    $result['dir'] = $directory; 
    $result['input'] = $inputPath ? realPath($inputPath) : $directory."/input.txt";
    $result['output'] = $outputPath ? realPath($outputPath) :  $directory."/output.txt";
    $result['concat'] = $concatChar ? $concatChar : "+";
    return $result;
}

function createFile($filePath, $directory, $type){
    $file = new SplFileInfo($filePath);
    if (!$file->isFile()){
        if ($filePath == $directory."/input.txt" || $filePath == $directory."/output.txt")
            if (touch($filePath))
                exit("input.txt file has been created in $filePath . Pleas insert your HTML code in it.\n ");
            else
                throw new Exception("Error creating $type file. Try another one or use the default $type\n ", 1);
    }
    return $type == "input" ? new SplFileObject($filePath) : new SplFileObject($filePath, "w");
}

function makeConversion($input, $output, $datas){
    while (!$input->eof()) {
        $line = $input->fgets();
        $line = rtrim($line, "\r\n");
        $line = str_replace("'", "\"", $line);
        if (!$input->valid())
            $convertedLine = "'".$line."'";
        else 
            $convertedLine = "'".$line."'".$datas['concat']."\n";
        $output->fwrite($convertedLine);
    }
    $input = null;
    $output = null;
    exit("Conversion successfully.\nYour result is in ".$datas['output']."\n ");
}

try{
    $datas = askUser();
    $input = createFile($datas['input'], $datas['dir'], "input");
    if ($input->getSize() <= 0)
        throw new Exception("Error: input file is empty. Make sure you place your text in ".$datas['input']."\n ");
    $output = createFile($datas['output'], $datas['dir'], "output");
    makeConversion($input, $output, $datas);
}catch(Exception $e){
    echo $e->getMessage();
}

?>