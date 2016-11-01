<?php

$lang = array(

	/* !Admin */
	'__app_teamspeak'	=> "TeamSpeak Integration",

	/* !Menu */
	'menutab__teamspeak' => "TeamSpeak",
	'menutab__teamspeak_icon' => "phone",
	'menu__teamspeak_overview' => "Overview",
	'menu__teamspeak_overview_test' => "Test Connection",
	'menu__teamspeak_overview_settings' => "Settings",
	'menu__teamspeak_members' => "TeamSpeak Members",
	'menu__teamspeak_members_members' => 'UUIDs',
	'menu__teamspeak_teamspeak' => "TeamSpeak",
	'menu__teamspeak_teamspeak_server' => "Server",
	'menu__teamspeak_teamspeak_alert' => "Alert",
	'menu__teamspeak_teamspeak_clients' => "Clients",
	'menu__teamspeak_groups' => "Groups",
	'menu__teamspeak_groups_servergroups' => "Server Groups",

	/* !Titles */
	'teamspeak_test_title' => "Test TeamSpeak",
	'teamspeak_settings_title' => "TeamSpeak Settings",
	'teamspeak_members_title' => "Member UUIDs",
	'teamspeak_alert_title' => "TeamSpeak Alert",
	'teamspeak_clients_title' => "TeamSpeak Clients",
	'teamspeak_server_groups_title' => "Edit Server Groups",
	'teamspeak_servergroup_edit_title' => "Edit Server Group",

	/* UUID Table */
	'teamspeak_resync_all' => "Re-sync all",
	'teamspeak_members_resynced' => "Re-synced all members",
	'teamspeak_table_s_member_id' => "Member",
	'teamspeak_table_s_uuid' => "UUID",
	'teamspeak_table_s_date' => "Date",
	'teamspeak_table_name' => "Member",
	'resync' => "Resync",
	'teamspeak_member_resynced' => "Member has been re-synced successfully",
	'teamspeak_member_deleted' => "UUID has been unlinked successfully",

	/* Alert Form */
	'alert_message' => "Message",
	'teamspeak_alert' => "Alert",
	'teamspeak_alert_sent' => "Alert sent",

	/* Settings form */
	'teamspeak_basic_settings' => "Basic",
	'teamspeak_other_settings' => "Other",
	'teamspeak_server_ip' => "TeamSpeak IP/Host",
	'teamspeak_server_ip_desc' => "Your TeamSpeak server IP address or hostname.",
	'teamspeak_virtual_port' => "TeamSpeak Server Port",
	'teamspeak_virtual_port_desc' => "Your TeamSpeak Virtual Port, default is 9987.",
	'teamspeak_query_port' => "TeamSpeak Query Port",
	'teamspeak_query_port_desc' => "Your TeamSpeak Query Port, in most cases this is 10011. If unsure, ask your TeamSpeak host.",
	'teamspeak_file_transfer_port' => "TeamSpeak File Transfer Port",
	'teamspeak_file_transfer_port_desc' => "Your TeamSpeak File Transfer, in most cases this is 30033. If unsure, ask your TeamSpeak host",
	'teamspeak_query_admin' => "TeamSpeak QueryAdmin Name",
	'teamspeak_query_admin_desc' => "Your TeamSpeak Query Admin username, usually serveradmin.",
	'teamspeak_query_password' => "TeamSpeak QueryAdmin Password",
	'teamspeak_query_password_desc' => "Your TeamSpeak Query Admin password.",
	'teamspeak_query_nickname' => "TeamSpeak Nickname",
	'teamspeak_query_nickname_desc' => "Nickname for this APP, will be shown on the TS when automated actions take place.",
	'teamspeak_uuid_on_register' => "Show UUID on register form?",
	'teamspeak_uuid_on_register_desc' => "Display a textbox on register form for new members to enter their UUID?",
	'teamspeak_uuid_on_register_force' => "Require UUID on register form?",
	'teamspeak_uuid_on_register_force_desc' => "Make the UUID textbox on the register form required?",

	/* Server information form */
	'teamspeak_server_title' => "Edit TS Server",
	'teamspeak_server' => "Server",
	'teamspeak_name' => "Server Name",
	'teamspeak_welcomemessage' => "Welcome Message",
	'teamspeak_maxclients' => "Max. Clients",
	'teamspeak_reserved_slots' => "Reserved Slots",
	'teamspeak_transfer' => "Transfer",
	'teamspeak_download' => "Download",
	'teamspeak_max_download_total_bandwidth' => "Total Bandwidth",
	'teamspeak_max_download_total_bandwidth_desc' => "In Bytes.",
	'teamspeak_download_quota' => "Quota",
	'teamspeak_download_quota_desc' => "In Bytes.",
	'teamspeak_upload' => "Upload",
	'teamspeak_max_upload_total_bandwidth' => "Total Bandwidth",
	'teamspeak_max_upload_total_bandwidth_desc' => "In Bytes.",
	'teamspeak_upload_quota' => "Quota",
	'teamspeak_upload_quota_desc' => "In Bytes.",
	'teamspeak_anti_flood' => "Anti Flood",
	'teamspeak_antiflood_points_needed_ip_block' => "Points for IP Block",
	'teamspeak_antiflood_points_tick_reduce' => "Decrease for being good",
	'teamspeak_antiflood_points_needed_command_block' => "Points for Command Block",
	'teamspeak_security' => "Security",
	'teamspeak_needed_identity_security_level' => "Needed Security Level",
	'teamspeak_other' => "Other",
	'teamspeak_default_server_group' => "Default Server Group",
	'teamspeak_default_channel_group' => "Default Channel Group",
	'teamspeak_default_channel_admin_group' => "Default Channel Admin Group",

	/* Clients table */
	'teamspeak_client_nickname' => "Nickname",
	'teamspeak_clid' => "Client ID",
	'teamspeak_kick' => "Kick",
	'teamspeak_poke' => "Poke",
	'teamspeak_ban' => "Ban",
	'teamspeak_client_poked' => "Client has been poked",
	'teamspeak_client_kicked' => "Client has been kicked",
	'teamspeak_client_banned' => "Client has been banned",

	/* Kick Form */
	'teamspeak_kick_title' => "Kick Client",
	'teamspeak_kick_message' => "Kick Message",

	/* Poke Form */
	'teamspeak_poke_title' => "Poke Client",
	'teamspeak_poke_message' => "Poke Message",

	/* Ban Form */
	'teamspeak_ban_title' => "Ban Client",
	'teamspeak_ban_message' => "Ban Reason",
	'teamspeak_ban_date' => "Ban until",
	'teamspeak_indefinite' => "Permanently",

	/* Member Form */
	'teamspeak_resync_uuids' => "Re-sync TeamSpeak Groups",

	/* !Group Form */
	'group__teamspeak_ServerGroups' => "TeamSpeak",
	'teamspeak_group' => "TeamSpeak Group",
	'teamspeak_group_desc' => "Which TS Group should members that are in this group get?",
	'teamspeak_require_uuid' => "Force UUID?",
	'teamspeak_require_uuid_desc' => "Members of this group will be forced to enter at least one UUID.",

	/* !Restrictions */
	'r__server' => "Server",
	'r__server_manage' => "Can edit server information?",
	'r__alert' => "Alert",
	'r__alert_manage' => "Can send global alert to the server?",
	'r__test' => "Test",
	'r__test_manage' => "Can test connection?",

	/* !Errors */
	'teamspeak_id_missing' => "ID parameter is missing!",
	'teamspeak_resync_groups_failed' => "Re-syncing the groups failed!",
	'teamspeak_serverinfo_error' => "There was an error loading the server information, please check the system logs for more information!",
	'teamspeak_update_server_failed' => "There was an error updating the server information, please check the system logs for more information!",

	/* !Server Group Edit Form */
	'teamspeak_servergroup_sgid' => "Group ID",
	'teamspeak_servergroup_name' => "Group Name",
	'description' => "Description",
	'value' => "Value",
	'skip' => "Skip",
	'negated' => "Negated",
	'grant' => "Grant",

	/* !Front */

	/* !Navigation */
	'frontnavigation_teamspeak' => "TeamSpeak Sync",
	'module__teamspeak_teamspeak' => "TeamSpeak Sync",
	'page__teamspeak' => "TeamSpeak",

	/* Sync table */
	'teamspeak_no_uuids' => "You have no UUIDs linked",
	'teamspeak_add_uuid' => "Add UUID",
	'teamspeak_uuids' => "TeamSpeak UUIDs",
	'teamspeak_unlink_uuid' => "Unlink UUID",
	'teamspeak_added_uuid' => "Added UUID",
	'teamspeak_removed_uuid' => "Unlinked UUID",
	'teamspeak_you_are_forced_to_enter_one_uuid' => "The administrator requires you to link at least one account",

	/* Add UUID Form */
	's_uuid' => "UUID",
	's_uuid_desc' => "Press CTRL+I on TeamSpeak to get your UUID",

	/* Block manager Viewer */
	'teamspeak_viewer' => "TeamSpeak Viewer",
	'block_teamspeakViewer' => "Viewer",
	'block_teamspeakViewer_desc' => "Shows your TeamSpeak server and lets members connect to it through clicking on a channel.",

	/* Front Title */
	'teamspeak_front' => "TeamSpeak",

	/* Viewer Setting Form */
	'teamspeak_viewer_groups' => "Allowed Groups",
	'teamspeak_viewer_groups_desc' => "Which groups are allowed to see the TeamSpeak Viewer?",
	'cacheTime' => "Cache Time",
	'showConnectButton' => "Display connect button?",
	'showConnectButton_desc' => "If enabled there will be an additional button which you can click to connect to the TS server.",
	'showGuestOnly' => "Only show channels that are visible to guests?",
	'showGuestOnly_desc' => "If turned off, it will show all clients even if they are in channels that require a high subscribe power (which guests do not have).",
	'cacheTime_desc' => "In Seconds.",
	'hideEmptyChannels' => "Hide empty Channels?",
	'hideParentChannels' => "Hide Parent Channels?",
);
