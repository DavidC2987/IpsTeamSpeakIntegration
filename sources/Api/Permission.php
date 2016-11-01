<?php

namespace IPS\teamspeak\Api;

/* To prevent PHP errors (extending class does not exist) revealing path */
use IPS\Helpers\Form;

if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

class _Permission extends \IPS\teamspeak\Api
{
	/*
	 * @brief Array containing IDs of permissions that have a number value.
	 */
	public static $numberValues = array(
		76, 77, 79, 80, 96, 97, 104, 121, 122, 129, 130, 136, 137, 138, 139, 140, 141, 142, 143, 146,
		147, 148, 149, 161, 162, 163, 164, 165, 166, 167, 171, 172, 173, 174, 175, 176, 193, 194, 196,
		197, 198, 199, 200, 201, 202, 203, 204, 205, 213, 214, 215, 219, 220, 221, 222, 224, 225, 233,
		234, 235, 236, 237, 238, 239, 240, 241, 242, 243, 244, 245, 246
	);

	/**
	 * Only here for auto-complete.
	 *
	 * @return Permission
	 */
	public static function i()
	{
		return parent::i();
	}

	/**
	 * Return $form with correct permission matrix.
	 *
	 * @param Form $form
	 * @param $serverGroupIp
	 * @return void
	 * @throws \Exception
	 */
	public function buildPermissionForm( Form &$form, $serverGroupIp )
	{
		$allPermission = $this->getPermissionList();
		$serverGroupPermission = $this->getServerGroupPerms( $serverGroupIp );

		$matrix = new \IPS\Helpers\Form\Matrix();
		$matrix->manageable = false;
		$rows = array();

		$matrix->columns = array(
			'label'	=> function( $key, $value, $data )
			{
				return $value;
			},
			'description' => function( $key, $value, $data )
			{
				return $value;
			},
			'value'	=> function( $key, $value, $data )
			{
				$permId = intval( explode( '[', $key )[0] );

				if ( in_array( $permId, static::$numberValues ) )
				{
					return new \IPS\Helpers\Form\Number( $key, $value, false, array( 'min' => -1 ) );
				}

				return new \IPS\Helpers\Form\YesNo( $key, $value );
			},
			'skip'	=> function( $key, $value, $data )
			{
				return new \IPS\Helpers\Form\YesNo( $key, $value );
			},
			'negated'	=> function( $key, $value, $data )
			{
				return new \IPS\Helpers\Form\YesNo( $key, $value );
			},
			'grant'	=> function( $key, $value, $data )
			{
				$key = $data['grantId'] . '[grant]';
				return new \IPS\Helpers\Form\Number( $key, $value );
			}
		);

		foreach ( $allPermission as $item )
		{
			if ( $item['pcount'] <= 0 )
			{
				continue;
			}

			foreach ( $item['permissions'] as $permission )
			{
				if ( isset( $serverGroupPermission[$permission['permid']] ) )
				{
					$rows[$permission['permid']] = array(
						'label' => $permission['permname'],
						'description' => $permission['permdesc'],
						'value' => $serverGroupPermission[$permission['permid']]['permvalue'],
						'skip' => $serverGroupPermission[$permission['permid']]['permskip'],
						'negated' => $serverGroupPermission[$permission['permid']]['permnegated'],
						'grant' => isset( $serverGroupPermission[$permission['grantpermid']] ) ? $serverGroupPermission[$permission['grantpermid']]['permvalue'] : 0,
						'grantId' => $permission['grantpermid']
					);
				}
				else
				{
					$rows[$permission['permid']] = array(
						'label' => $permission['permname'],
						'description' => $permission['permdesc'],
						'grantId' => $permission['grantpermid']
					);
				}
			}
		}

		$matrix->rows = $rows;
		$form->addMatrix( 'edit_server_group', $matrix );
	}

	/**
	 * Update permissions of given server group.
	 *
	 * @param array $values
	 * @param $serverGroupId
	 * @return bool
	 * @throws \Exception
	 */
	public function updatePermissionsFromFormValues( array $values, $serverGroupId )
	{
		$newArray = array();
		$grantPerm = $this->getGrantPermArray();

		foreach ( $values['edit_server_group'] as $permId => $permissions )
		{
			/* Set grant perm id with value */
			if ( isset( $grantPerm[$permId] ) )
			{
				$newArray[$grantPerm[$permId]] = array(
					intval( $permissions['grant'] ),
					0,
					0
				);
			}

			$newArray[$permId] = array(
				intval( $permissions['value'] ),
				intval( $permissions['skip'] ),
				intval( $permissions['negated'] )
			);
		}

		return $this->addPermissions( $serverGroupId, $newArray );
	}

	/**
	 * Get all permissions in the new format (with -new param).
	 *
	 * @return array
	 */
	protected function getPermissionList()
	{
		$ts = static::getInstance();
		$permission = $ts->permissionList( true );

		return $permission;
	}

	/**
	 * Get all permissions that are assigned to the given server group.
	 *
	 * @param int $serverGroupId
	 * @return array
	 * @throws \Exception
	 */
	protected function getServerGroupPerms( $serverGroupId )
	{
		$ts = static::getInstance();
		$permissions = $ts->serverGroupPermList( $serverGroupId );

		if ( $ts->succeeded( $permissions ) )
		{
			$permissions = $ts->getElement( 'data', $permissions );
			return $this->prepareServerGroupPermissionList( $permissions );
		}

		throw new \Exception( $this->arrayToString( $ts->getElement( 'errors', $permissions ) ) );
	}

	/**
	 * Add given permission to the given server group.
	 *
	 * @param $serverGroupId
	 * @param array $permissions
	 * @return bool
	 * @throws \Exception
	 */
	protected function addPermissions( $serverGroupId, array $permissions )
	{
		$ts = static::getInstance();
		$temp = $ts->serverGroupAddPerm( $serverGroupId, $permissions );

		if ( $ts->succeeded( $temp ) )
		{
			return true;
		}

		throw new \Exception( $this->arrayToString( $ts->getElement( 'errors', $temp ) ) );
	}

	/**
	 * Use permission IDs as keys.
	 *
	 * @param array $permissions
	 * @return array
	 */
	protected function prepareServerGroupPermissionList( array $permissions )
	{
		$newArray = array();

		foreach ( $permissions as $id => $permission )
		{
			$newArray[$permission['permid']] = $permission;
		}

		return $newArray;
	}

	/**
	 * Get array of grantPermId-permId relationship.
	 *
	 * @return array
	 */
	protected function getGrantPermArray()
	{
		$permissionList = $this->getPermissionList();
		$grantPermArray = array();

		foreach ( $permissionList as $permissions )
		{
			if ( $permissions['pcount'] <= 0 )
			{
				continue;
			}

			foreach ( $permissions['permissions'] as $permission )
			{
				$grantPermArray[$permission['permid']] = $permission['grantpermid'];
			}
		}

		return $grantPermArray;
	}
}