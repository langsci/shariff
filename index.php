<?php

/**
 * @defgroup plugins_generic_shariff Shariff plugin
 */

/**
 * @file plugins/generic/shariff/index.php
 *
 * Copyright (c) 2015 Language Science Press
 * Distributed under the GNU GPL v2. For full terms see the file docs/COPYING.
 *
 * @ingroup plugins_generic_shariff
 * @brief Wrapper for the shariff social media plugin.
 *
 */


require_once('ShariffPlugin.inc.php');

return new ShariffPlugin();

?>
