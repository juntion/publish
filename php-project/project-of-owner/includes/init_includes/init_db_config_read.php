<?php
use App\Services\Init\InitConfigureService;

//初始化全局configuration
$service = new InitConfigureService();
$service->createConfig();
