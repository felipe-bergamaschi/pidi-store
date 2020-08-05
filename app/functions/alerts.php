<?php

const ERROR = NULL;
const SUCCESS = NULL;

function setError($msg)
{

	$_SESSION[ERROR] = $msg;

}

function getError()
{

	$msg = (isset($_SESSION[ERROR]) && $_SESSION[ERROR]) ? $_SESSION[ERROR] : '';

	clearError();

	return $msg;

}

function clearError()
{

	$_SESSION[ERROR] = NULL;

}

function setSuccess($msg)
{

	$_SESSION[SUCCESS] = $msg;

}

function getSuccess()
{

	$msg = (isset($_SESSION[SUCCESS]) && $_SESSION[SUCCESS]) ? $_SESSION[SUCCESS] : '';

	clearSuccess();

	return $msg;

}

function clearSuccess()
{

	$_SESSION[SUCCESS] = NULL;

}