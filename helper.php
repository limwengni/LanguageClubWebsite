<?php
//helper.php

//connect database
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "language";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function getGender($g){ //$g is basically f or m
    $gender = getGenderList();
    return $gender[$g];
}

function getGenderIcon(){
    $gender = getGenderList();
    if($gender === 'Male'){
        return 'fas fa-mars';
    } else{
        return 'fas fa-venus';
    }
    
}

function getGenderPronoun(){
    $gender = getGenderList();
    if($gender === 'Male'){
        return 'Mr';
    } else{
        return 'Ms';
    }
    
}

function getGenderList(){
    return ['M' => 'Male', 'F' => 'Female'];
}

function getProgram($p) {
    $program = getProgramList();
    if (array_key_exists($p, $program)) {
        return $program[$p];
    } else {
        return null;
    }
}

function getProgramList() {
    return ['Japanese' => 'Japanese',
        'Spanish' => 'Spanish',
        'French' => 'French'];
}

function getPayment($p) {
    $program = getBankList();
    if (array_key_exists($p, $program)) {
        return $program[$p];
    } else {
        return null;
    }
}


function getBankList() {
    return ['CIMB Bank' => 'CIMB Bank',
        'Public Bank' => 'Public Bank',
        'Maybank' => 'Maybank'];
}

/*
$servername = "sql213.epizy.com";
$username = "epiz_32481565";
$password = "SGwmP9vvRBIe6G2";
$dbname = "epiz_32481565_Foreign_language";
$conn = mysqli_connect($servername, $username, $password, $dbname);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
*/

