<?php
try{
    $input = new SplFileInfo("./input.txt");
    $directory = getcwd();
    if (!$input->isFile())
        touch('input.txt');

    if ($input->getSize() <= 0)
        throw new Exception("Error: input file is empty. Make sure you place your text in $directory/input.\n");
    $output = new SplFileInfo("./output.txt");

    if (!$output->isFile())
        touch('output.txt');

    $input = new SplFileObject("./input.txt");
    $output = new SplFileObject("./output.txt", "w");
    while (!$input->eof()) {
        $line = $input->fgets();
        $line = rtrim($line, "\r\n");
        $line = str_replace("'", "\"", $line);
        if (!$input->valid())
            $convertedLine = "'".$line."'";
        else 
            $convertedLine = "'".$line."'+\n";
        $output->fwrite($convertedLine);
    }
    $input = null;
    $output = null;
    echo "Conversion successfully.\nYour result is in $directory/output.txt\n";
}catch(Exception $e){
    echo $e->getMessage();
}
?>