<?php
/*
 * Copyright 2007-2011 Charles du Jeu <contact (at) cdujeu.me>
 * This file is part of AjaXplorer.
 *
 * AjaXplorer is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * AjaXplorer is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with AjaXplorer.  If not, see <http://www.gnu.org/licenses/>.
 *
 * The latest code can be found at <http://www.ajaxplorer.info/>.
 */
defined('AJXP_EXEC') or die( 'Access not allowed');

/**
 * @package info.ajaxplorer.core
 * @class AJXP_VarsFilter
 * @static
 * Standard values filtering used in the core.
 */
class AJXP_VarsFilter {
	
	public static function filter($value){
		if(is_string($value) && strpos($value, "AJXP_USER")!==false){
			if(AuthService::usersEnabled()){
				$loggedUser = AuthService::getLoggedUser();
				if($loggedUser != null){
					$loggedUser = $loggedUser->getId();
					$value = str_replace("AJXP_USER", $loggedUser, $value);
				}else{
					return "";
				}
			}else{
				$value = str_replace("AJXP_USER", "shared", $value);
			}
		}
		if(is_string($value) && strpos($value, "AJXP_INSTALL_PATH") !== false){
			$value = str_replace("AJXP_INSTALL_PATH", AJXP_INSTALL_PATH, $value);
		}
		if(is_string($value) && strpos($value, "AJXP_DATA_PATH") !== false){
			$value = str_replace("AJXP_DATA_PATH", AJXP_DATA_PATH, $value);
		}
		AJXP_Controller::applyIncludeHook("vars.filter", array(&$value));		 
		return $value;
	}
}
?>