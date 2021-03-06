<?php

namespace IPS\teamspeak\Api;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
    header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
    exit;
}

class _Permission extends \IPS\teamspeak\Api\AbstractConnection
{
    /*
     * @brief Array containing IDs of permissions that have a number value.
     */
    protected static $numberValues = array(
        76, 77, 79, 80, 96, 97, 104, 121, 122, 129, 130, 136, 137, 138, 139, 140, 141, 142, 143, 146,
        147, 148, 149, 161, 162, 163, 164, 165, 166, 167, 171, 172, 173, 174, 175, 176, 193, 194, 196,
        197, 198, 199, 200, 201, 202, 203, 204, 205, 213, 214, 215, 219, 220, 221, 222, 224, 225, 233,
        234, 235, 236, 237, 238, 239, 240, 241, 242, 243, 244, 245, 246
    );

    /*
     * @brief Array containing IDs of permissions that are not applicable to the Guests group.
     */
    protected static $noGuestPerms = array(
        145
    );

    /**
     * Return $form with correct permission matrix.
     *
     * @param \IPS\Helpers\Form $form
     * @param $serverGroupId
     * @return void
     * @throws \Exception
     */
    public function buildServerGroupPermissionForm( \IPS\Helpers\Form $form, $serverGroupId )
    {
        $allPermission = $this->getPermissionList();
        $serverGroupPermission = $this->getServerGroupPerms( $serverGroupId );

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
                $permId = (int) explode( '[', $key )[0];

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
     * Return $form with correct permission matrix.
     *
     * @param \IPS\Helpers\Form $form
     * @param $channelGroupId
     * @return void
     * @throws \Exception
     */
    public function buildChannelGroupPermissionForm( \IPS\Helpers\Form $form, $channelGroupId )
    {
        $allPermission = $this->getPermissionList();
        $channelGroupPermission = $this->getChannelGroupPerms( $channelGroupId );

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
                $permId = (int) explode( '[', $key )[0];

                if ( in_array( $permId, static::$numberValues ) )
                {
                    return new \IPS\Helpers\Form\Number( $key, $value, false, array( 'min' => -1 ) );
                }

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
                if ( isset( $channelGroupPermission[$permission['permid']] ) )
                {
                    $rows[$permission['permid']] = array(
                        'label' => $permission['permname'],
                        'description' => $permission['permdesc'],
                        'value' => $channelGroupPermission[$permission['permid']]['permvalue'],
                        'grant' => isset( $channelGroupPermission[$permission['grantpermid']] ) ? $channelGroupPermission[$permission['grantpermid']]['permvalue'] : 0,
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
        $form->addMatrix( 'edit_channel_group', $matrix );
    }

    /**
     * Update permissions of given server group.
     *
     * @param array $values
     * @param $serverGroupId
     * @return bool
     * @throws \Exception
     */
    public function updateServerGroupPermissionsFromFormValues( array $values, $serverGroupId )
    {
        $newPerms = array();
        $changedPerms = array();
        $grantPerm = $this->getGrantPermArray();
        $currentPerms = $this->getServerGroupPerms( $serverGroupId );

        foreach ( $values['edit_server_group'] as $permId => $permissions )
        {
            /* Set grant perm id with value */
            if ( isset( $grantPerm[$permId] ) )
            {
                $newPerms[$grantPerm[$permId]] = array(
                    (int) $permissions['grant'],
                    0,
                    0
                );
            }

            $newPerms[$permId] = array(
                (int) $permissions['value'],
                (int) $permissions['skip'],
                (int) $permissions['negated']
            );
        }


        $defaultIds = \IPS\teamspeak\Api\Group::getDefaultGroupIds( $this->instance );
        $defaultGroupId = $defaultIds['default_server_group'];

        foreach ( $newPerms as $permId => $newPerm )
        {
            if (( $serverGroupId == $defaultGroupId && in_array( $permId, static::$noGuestPerms ) ) || isset( $currentPerms[$permId] ) && $newPerm[0] == $currentPerms[$permId]['permvalue'] && $newPerm[1] == $currentPerms[$permId]['permnegated'] && $newPerm[2] == $currentPerms[$permId]['permskip'] )
            {
                continue;
            }

            $changedPerms[$permId] = $newPerm;
        }

        if ( empty( $changedPerms ) )
        {
            return true;
        }

        return $this->addPermissionsToServerGroup( $serverGroupId, $changedPerms );
    }

    /**
     * Update permissions of given channel group.
     *
     * @param array $values
     * @param $channelGroupId
     * @return bool
     * @throws \Exception
     */
    public function updateChannelGroupPermissionsFromFormValues( array $values, $channelGroupId )
    {
        $newPerms = array();
        $changedPerms = array();
        $grantPerm = $this->getGrantPermArray();
        $currentPerms = $this->getChannelGroupPerms( $channelGroupId );

        foreach ( $values['edit_channel_group'] as $permId => $permissions )
        {
            /* Set grant perm id with value */
            if ( isset( $grantPerm[$permId] ) )
            {
                $newPerms[$grantPerm[$permId]] = (int) $permissions['grant'];
            }

            $newPerms[$permId] = (int) $permissions['value'];
        }

        foreach ( $newPerms as $permId => $newPerm )
        {
            if ( isset( $currentPerms[$permId] ) && $newPerm == $currentPerms[$permId]['permvalue'] )
            {
                continue;
            }

            $changedPerms[$permId] = $newPerm;
        }

        if ( empty( $changedPerms ) )
        {
            return true;
        }

        return $this->addPermissionsToChannelGroup( $channelGroupId, $changedPerms );
    }

    /**
     * Get all permissions in the new format (with -new param).
     *
     * @return array
     */
    protected function getPermissionList()
    {
        return $this->instance->permissionList( true );
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
        $permissions = \IPS\teamspeak\Api\Util::getReturnValue( $this->instance, $this->instance->serverGroupPermList( $serverGroupId ) );

        return $this->prepareGroupPermissionList( $permissions );
    }

    /**
     * Get all permissions that are assigned to the given channel group.
     *
     * @param int $channelGroupId
     * @return array
     * @throws \Exception
     */
    protected function getChannelGroupPerms( $channelGroupId )
    {
        $permissions = \IPS\teamspeak\Api\Util::getReturnValue( $this->instance, $this->instance->channelGroupPermList( $channelGroupId ) );

        return $this->prepareGroupPermissionList( $permissions );
    }

    /**
     * Add given permission to the given server group.
     *
     * @param $serverGroupId
     * @param array $permissions
     * @return bool
     * @throws \Exception
     */
    protected function addPermissionsToServerGroup( $serverGroupId, array $permissions )
    {
        return \IPS\teamspeak\Api\Util::getReturnValue( $this->instance, $this->instance->serverGroupAddPerm( $serverGroupId, $permissions ), true );
    }

    /**
     * Add given permission to the given channel group.
     *
     * @param $channelGroupId
     * @param array $permissions
     * @return bool
     * @throws \Exception
     */
    protected function addPermissionsToChannelGroup( $channelGroupId, array $permissions )
    {
        return \IPS\teamspeak\Api\Util::getReturnValue( $this->instance, $this->instance->channelGroupAddPerm( $channelGroupId, $permissions ), true );
    }

    /**
     * Use permission IDs as keys.
     *
     * @param array $permissions
     * @return array
     */
    protected function prepareGroupPermissionList( array $permissions )
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