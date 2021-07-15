<?php

define('CONFIG_BASE_URL',Common::getEnv("CONFIG_BASE_URL",'https://'.$_SERVER['HTTP_HOST'].''));
define('CONFIG_PAGE_TITLE',Common::getEnv("CONFIG_PAGE_TITLE",'Some Blog'));
define('CONFIG_PAGE_DESCRIPTION',Common::getEnv("CONFIG_PAGE_DESCRIPTION",'With some generic description'));
