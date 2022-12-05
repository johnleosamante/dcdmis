<?php
# personnel/logout/index.php

include_once('../../_includes_/function.php');
										
session_destroy();
header('location:' . GetSiteURL() . '/personnel/login');
?>