<?php

namespace IPS\teamspeak\modules\admin\groups;

/* To prevent PHP errors (extending class does not exist) revealing path */
if ( !defined( '\IPS\SUITE_UNIQUE_KEY' ) )
{
	header( ( isset( $_SERVER['SERVER_PROTOCOL'] ) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0' ) . ' 403 Forbidden' );
	exit;
}

use IPS\Application;
use IPS\Dispatcher;
use IPS\Helpers\Form;
use IPS\Helpers\Table;
use IPS\Http\Url;
use IPS\Member;
use IPS\Output;
use IPS\Request;
use IPS\teamspeak\Api\Group;
use IPS\teamspeak\Api\Permission;
use IPS\Theme;

/**
 * servergroups
 */
class _servergroups extends \IPS\Dispatcher\Controller
{
	/**
	 * Execute
	 *
	 * @return    void
	 */
	public function execute()
	{
		Dispatcher::i()->checkAcpPermission( 'servergroups_manage' );
		parent::execute();
		Application::load( 'teamspeak' )->isConfigured();
	}

	/**
	 * Show table of regular server groups.
	 *
	 * @return    void
	 */
	protected function manage()
	{
		/* Get server groups array */
		$tsGroup = Group::i();
		$serverGroups = $tsGroup->getServerGroups( $tsGroup->getInstance(), false, false, true );

		/* Create the table */
		$table = new Table\Custom( $serverGroups, Url::internal( 'app=teamspeak&module=groups&controller=servergroups' ) );
		$table->langPrefix = 'teamspeak_servergroup_';

		/* Column stuff */
		$table->include = array( 'sgid', 'name' );
		$table->mainColumn = 'name';

		/* Sort stuff */
		$table->sortBy = $table->sortBy ?: 'sgid';
		$table->sortDirection = $table->sortDirection ?: 'asc';

		/* Search */
		$table->quickSearch = 'name';
		$table->advancedSearch = array(
			'name' => Table\SEARCH_CONTAINS_TEXT
		);

		/* Row buttons */
		$table->rowButtons = function ( $row )
		{
			$return['edit'] = array(
				'icon' => 'pencil',
				'title' => 'edit',
				'link' => Url::internal( 'app=teamspeak&module=groups&controller=servergroups&do=edit&id=' ) .
					$row['sgid']
			);

			$return['delete'] = array(
				'icon' => 'times-circle',
				'title' => 'delete',
				'link' => Url::internal( 'app=teamspeak&module=groups&controller=servergroups&do=delete&id=' ) .
					$row['sgid'],
				'data' => array(
					'ipsdialog' => '',
					'ipsdialog-modal' => 'true',
					'ipsdialog-title' => Member::loggedIn()->language()->addToStack( 'teamspeak_delete_servergroup_title' )
				)
			);

			return $return;
		};

		/* Display */
		Output::i()->title = Member::loggedIn()->language()->addToStack( 'teamspeak_server_groups_title' );
		Output::i()->output = Theme::i()->getTemplate( 'global', 'core' )->block( 'title', (string) $table );
	}

	/**
	 * Edit given server group.
	 *
	 * @return void
	 */
	protected function edit()
	{
		/* Check if we have an ID */
		$id = Request::i()->id;

		if ( !$id )
		{
			Output::i()->error( 'teamspeak_id_missing', '3P104/1' );
		}

		/* Get permission class */
		$permissions = Permission::i();

		/* Build form for editing the server group */
		$form = new Form;
		$permissions->buildPermissionForm( $form, $id );

		if ( $values = $form->values() )
		{
			try
			{
				$permissions->updatePermissionsFromFormValues( $values, $id );

				Output::i()->redirect(
					Url::internal( 'app=teamspeak&module=groups&controller=servergroups' ), 'teamspeak_servergroup_edited'
				);
			}
			catch ( \Exception $e )
			{
				Output::i()->error( $e->getMessage(), '4P104/1' );
			}
		}

		/* Display */
		Output::i()->title = Member::loggedIn()->language()->addToStack( 'teamspeak_servergroup_edit_title' );
		Output::i()->output = $form;
	}

	/**
	 * Delete given server group.
	 *
	 * @return void
	 */
	protected function delete()
	{
		/* Check if we have an ID */
		$id = Request::i()->id;

		if ( !$id )
		{
			Output::i()->error( 'teamspeak_id_missing', '3P104/2' );
		}

		/* Get Group class */
		$group = Group::i();

		/* Build form for editing the server group */
		$form = new Form;
		$form->add( new Form\YesNo( 'force', 0 ) );

		if ( $values = $form->values() )
		{
			try
			{
				$group->deleteServerGroup( $id, intval( $values['force'] ) );

				$dataStore = \IPS\Data\Store::i();
				$cacheKey = 'teamspeak_server_groups_all_templates';
				unset( $dataStore->$cacheKey );

				Output::i()->redirect(
					Url::internal( 'app=teamspeak&module=groups&controller=servergroups' ), 'teamspeak_servergroup_deleted'
				);
			}
			catch ( \Exception $e )
			{
				Output::i()->error( $e->getMessage(), '4P104/2' );
			}
		}

		/* Display */
		Output::i()->title = Member::loggedIn()->language()->addToStack( 'teamspeak_delete_servergroup_title' );
		Output::i()->output = $form;
	}
}