<?php
/*
 ************************************************************************
 PagSeguro Config File
 ************************************************************************
 */

global $config;
$PagSeguroConfig = array();

$PagSeguroConfig['environment'] = $config['pagseguro']['environment']; // production, sandbox

$PagSeguroConfig['credentials'] = array();
$PagSeguroConfig['credentials']['email'] = $config['pagseguro']['email'];
$PagSeguroConfig['credentials']['token']['production'] = $config['pagseguro']['token']['production'];
$PagSeguroConfig['credentials']['token']['sandbox'] = $config['pagseguro']['token']['sandbox'];

$PagSeguroConfig['application'] = array();
$PagSeguroConfig['application']['charset'] = "UTF-8"; // UTF-8, ISO-8859-1

$PagSeguroConfig['log'] = array();
$PagSeguroConfig['log']['active'] = false;
$PagSeguroConfig['log']['fileLocation'] = "";
