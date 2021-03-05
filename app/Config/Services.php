<?php

namespace Config;

use App\Entities\User;
use App\Models\UserModel;
use CodeIgniter\Config\Services as CoreServices;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends CoreServices
{

	/** @return User */
	public static function login($getShared = true)
	{
		if ($getShared) {
			return static::getSharedInstance('login');
		}

		return (new UserModel())->find(Services::session()->login ?: 0);
	}

	/** @return \App\Entities\Config */
	public static function config($getShared = true)
	{
		if ($getShared) {
			return static::getSharedInstance('config');
		}

		return Database::connect()->table('config')->get()->getRow(0, '\App\Entities\Config');
	}
}
