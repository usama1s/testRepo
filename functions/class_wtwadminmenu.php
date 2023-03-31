<?php
class wtwadminmenu {
	/* wtwadminmenu class for the menu functions for Roomz Websites when browsed from admin.php */
	protected static $_instance = null;
	
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __construct() {

	}	
	
	/* declare public $wtwadminmenu variables */
	public $adminmenu = array();
	public $adminsubmenu = array();
	public $admindivs = array();
	public $adminforms = array();
	
	public function __call ($method, $arguments)  {
		if (isset($this->$method)) {
			call_user_func_array($this->$method, array_merge(array(&$this), $arguments));
		}
	}
	
	public function preloadAdminMenu() {
		/* admin menu is dynamically created and sorted before display */
		/* this allows plugins to add menu items tied to functions - then sorted and shown in proper order */
		global $wtwdb;
		global $wtw;
		$zsuccess = false;
		try {
			if (empty($wtwdb->getSessionUserID())) {
				header("Location: ".$wtw->domainurl."/"); 
				exit();
			} else {
				/* accessrequired - array of role names or null for all allowed */
				$updateroles = array("admin","developer","architect","graphics artist","host");
				$developerroles = array("admin","developer","host");
				$adminroles = array("admin");
				
				/* add admin menu item function: */
				/*	$zid = <div> id
					$ztitle = display name
					$zmenusort = int for sort order of menu (level 1)
					$zmenu = top level menu item
					$zsubmenusort = int for sort order of submenu (level 2)
					$zsubmenu = second level menu item (or '')
					$ziconurl = browse path to icon image (only applies to level 1 'menu')
					$zaccessrequired = array of roles that are granted access - null for all allowed
					$zjsfunction = javascript function to call for onclick event examples: WTW.show('divname');   or  myFunctionName('testthis');  or  MY.functionName();MY.secondFunction();
				*/
				$this->addAdminMenuItem('wtw_admindashboard', $this->__('Dashboard'), -100, 'wtw_dashboard', 0, '', '/content/system/images/menudashboard.png', null, "WTW.toggleAdminSubMenu(this);");
				$this->addAdminMenuItem('wtw_adminmenudashboard', $this->__('Admin Home'), -100, 'wtw_dashboard', 1, 'wtw_adminhome', '', null, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminmenufeedback', $this->__('Feedback'), -100, 'wtw_dashboard', 3, 'wtw_feedback', '', $adminroles, "WTW.openFullPageForm('feedback','Open Feedback','');");
				$this->addAdminMenuItem('wtw_adminmenuerrorlog', $this->__('Error Log'), -100, 'wtw_dashboard', 4, 'wtw_errorlog', '', $developerroles, "WTW.openFullPageForm('errorlog','Active Errors','');");
				
				$this->addAdminMenuItem('wtw_adminmedia', $this->__('Media Library'), -95, 'wtw_medialibrary', 0, '', '/content/system/images/menumedia.png', $updateroles, "WTW.toggleAdminSubMenu(this);");
				$this->addAdminMenuItem('wtw_adminmediaobjects', $this->__('3D Models'), -95, 'wtw_medialibrary', 1, 'wtw_viewobjects', '', $updateroles, "dGet('wtw_modelfilter').value='';dGet('wtw_tgroupuploadobjectid').value='';dGet('wtw_tgroupdiv').value='';WTW.openFullPageForm('medialibrary','');WTW.setImageMenu(4);");
				$this->addAdminMenuItem('wtw_adminmediafiles', $this->__('Files and Textures'), -95, 'wtw_medialibrary', 2, 'wtw_viewfiles', '', $updateroles, "WTW.openFullPageForm('medialibrary','');WTW.setImageMenu(2);");

				$this->addAdminMenuItem('wtw_admincommunities', $this->__('3D Communities'), -90, 'wtw_communities', 0, '', '/content/system/images/menucommunities.png', $updateroles, "WTW.toggleAdminMenuLevel('communities');");
				$this->addAdminMenuItem('wtw_adminselectcommunity', $this->__('Select 3D Community'), -90, 'wtw_communities', 1, 'wtw_selectcommunity', '', $updateroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminaddcommunity', $this->__('Add New 3D Community'), -90, 'wtw_communities', 2, 'wtw_addcommunity', '', $updateroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminsettingscommunity', $this->__('Options and Settings'), -90, 'wtw_communities', 3, 'wtw_communitysettings', '', $updateroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_admineditcommunity', $this->__('Edit 3D Community'), -90, 'wtw_communities', 4, 'wtw_editcommunity', '', $updateroles, "WTW.adminMenuItemSelected(this);");
				
				$this->addAdminMenuItem('wtw_adminbuildings', $this->__('3D Buildings'), -85, 'wtw_buildings', 0, '', '/content/system/images/menubuildings.png', $updateroles, "WTW.toggleAdminMenuLevel('buildings');");
				$this->addAdminMenuItem('wtw_adminselectbuilding', $this->__('Select 3D Building'), -85, 'wtw_buildings', 1, 'wtw_selectbuilding', '', $updateroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminaddbuilding', $this->__('Add New 3D Building'), -85, 'wtw_buildings', 2, 'wtw_addbuilding', '', $updateroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminsettingsbuilding', $this->__('Options and Settings'), -85, 'wtw_buildings', 3, 'wtw_buildingsettings', '', $updateroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_admineditbuilding', $this->__('Edit 3D Building'), -85, 'wtw_buildings', 4, 'wtw_editbuilding', '', $updateroles, "WTW.adminMenuItemSelected(this);");

				$this->addAdminMenuItem('wtw_adminthings', $this->__('3D Things'), -80, 'wtw_things', 0, '', '/content/system/images/menuthings.png', $updateroles, "WTW.toggleAdminMenuLevel('things');");
				$this->addAdminMenuItem('wtw_adminselectthing', $this->__('Select 3D Thing'), -80, 'wtw_things', 1, 'wtw_selectthing', '', $updateroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminaddthing', $this->__('Add New 3D Thing'), -80, 'wtw_things', 2, 'wtw_addthing', '', $updateroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminsettingsthing', $this->__('Options and Settings'), -80, 'wtw_things', 3, 'wtw_thingsettings', '', $updateroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_admineditthing', $this->__('Edit 3D Thing'), -80, 'wtw_things', 4, 'wtw_editthing', '', $updateroles, "WTW.adminMenuItemSelected(this);");

				$this->addAdminMenuItem('wtw_adminwebsites', $this->__('3D Websites'), -40, 'wtw_websites', 0, '', '/content/system/images/menuglobe.png', $developerroles, "WTW.toggleAdminSubMenu(this);");
				$this->addAdminMenuItem('wtw_adminmenuwebdomains', $this->__('Web Domains'), -40, 'wtw_websites', 1, 'wtw_adminwebdomains', '', $developerroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminmenuwebalias', $this->__('Web Aliases'), -40, 'wtw_websites', 2, 'wtw_adminwebalias', '', $developerroles, "WTW.adminMenuItemSelected(this);");
				
				$this->addAdminMenuItem('wtw_adminplugins', $this->__('3D Plugins'), 50, 'wtw_plugins', 0, '', '/content/system/images/menuplugin.png', $developerroles, "WTW.toggleAdminSubMenu(this);");
				$this->addAdminMenuItem('wtw_adminallplugins', $this->__('All 3D Plugins'), 50, 'wtw_plugins', 1, 'wtw_allplugins', '', $developerroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminactiveplugins', $this->__('Active 3D Plugins'), 50, 'wtw_plugins', 2, 'wtw_allplugins', '', $developerroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_admininactiveplugins', $this->__('Inactive 3D Plugins'), 50, 'wtw_plugins', 3, 'wtw_allplugins', '', $developerroles, "WTW.adminMenuItemSelected(this);");

				$wtwdb->checkOptionalUpgrades();
				if ($wtwdb->isUserInRole("Admin") || $wtwdb->isUserInRole("Developer")) {
					$zresultsinvoices = $wtwdb->query("
						select invoiceid
						from ".wtw_tableprefix."invoices
						where deleted=0
						limit 1;
					");
					$zresultsoptional = $wtwdb->query("
						select *
						from ".wtw_tableprefix."optionalupgradesapplied
						where deleted=0
							and hostuserid='';
					");
					if (count($zresultsoptional) > 0 && count($zresultsinvoices) > 0) {
						$this->addAdminMenuItem('wtw_adminmenuinvoices', 'Upgrades and Invoices', 400, 'wtw_invoices', 0, '', '/content/system/images/menuinvoices.png', array('admin','developer'), "WTW.toggleAdminSubMenu(this);");
						$this->addAdminMenuItem('wtw_adminoptionalupgrades', 'Optional Upgrades', 400, 'wtw_invoices', 1, 'wtw_admininvoices', '', array('admin','developer'), "WTW.openFullPageForm('fullpage','".$this->__('Optional Upgrades')."','wtw_optionalpage');");
						$this->addAdminMenuItem('wtw_admininvoices', 'Invoices', 400, 'wtw_invoices', 2, 'wtw_admininvoices', '', array('admin','developer'), "WTW.openFullPageForm('fullpage','".$this->__('Invoices')."','wtw_invoicepage');");
						$this->addAdminMenuItem('wtw_adminmyinvoices', 'My Invoices', 400, 'wtw_invoices', 3, 'wtw_adminmyinvoices', '', array('admin','developer'), "WTW.openFullPageForm('fullpage','".$this->__('My Invoices')."','wtw_myinvoicepage');");
					} else if (count($zresultsinvoices) > 0) {
						$this->addAdminMenuItem('wtw_adminmenuinvoices', 'Invoices', 400, 'wtw_invoices', 0, '', '/content/system/images/menuinvoices.png', array('admin','developer'), "WTW.toggleAdminSubMenu(this);");
						$this->addAdminMenuItem('wtw_admininvoices', 'Invoices', 400, 'wtw_invoices', 1, 'wtw_admininvoices', '', array('admin','developer'), "WTW.openFullPageForm('fullpage','".$this->__('Invoices')."','wtw_invoicepage');");
						$this->addAdminMenuItem('wtw_adminmyinvoices', 'My Invoices', 400, 'wtw_invoices', 2, 'wtw_adminmyinvoices', '', array('admin','developer'), "WTW.openFullPageForm('fullpage','".$this->__('My Invoices')."','wtw_myinvoicepage');");
					} else if (count($zresultsoptional) > 0) {
						$this->addAdminMenuItem('wtw_adminmenuinvoices', 'Upgrades', 400, 'wtw_invoices', 0, '', '/content/system/images/menuinvoices.png', array('admin','developer'), "WTW.toggleAdminSubMenu(this);");
						$this->addAdminMenuItem('wtw_adminoptionalupgrades', 'Optional Upgrades', 400, 'wtw_invoices', 1, 'wtw_admininvoices', '', array('admin','developer'), "WTW.openFullPageForm('fullpage','".$this->__('Optional Upgrades')."','wtw_optionalpage');");
					}
				} else {
					$zresultsinvoices = $wtwdb->query("
						select invoiceid
						from ".wtw_tableprefix."invoices
						where deleted=0
							and (hostuserid='".$wtwdb->userid."'
								or createuserid='".$wtwdb->userid."')
						limit 1;
					");
					$zresultsoptional = $wtwdb->query("
						select *
						from ".wtw_tableprefix."optionalupgradesapplied
						where deleted=0
							and (hostuserid='".$wtwdb->userid."'
								or createuserid='".$wtwdb->userid."');
					");
					if (count($zresultsoptional) > 0 && count($zresultsinvoices) > 0) {
						$this->addAdminMenuItem('wtw_adminmyinvoices2', 'Upgrades and Invoices', 400, 'wtw_invoices', 0, '', '/content/system/images/menuinvoices.png', array('architect','host'), "WTW.toggleAdminSubMenu(this);");
						$this->addAdminMenuItem('wtw_adminoptionalupgrades', 'Optional Upgrades', 400, 'wtw_invoices', 1, 'wtw_admininvoices', '', array('architect','host'), "WTW.openFullPageForm('fullpage','".$this->__('Optional Upgrades')."','wtw_optionalpage');");
						$this->addAdminMenuItem('wtw_adminmyinvoices', 'My Invoices', 400, 'wtw_invoices', 3, 'wtw_adminmyinvoices', '', array('architect','host'), "WTW.openFullPageForm('fullpage','".$this->__('My Invoices')."','wtw_myinvoicepage');");
					} else if (count($zresultsoptional) > 0) {
						$this->addAdminMenuItem('wtw_adminmyinvoices2', 'Upgrades', 400, 'wtw_invoices', 0, '', '/content/system/images/menuinvoices.png', array('architect','host'), "WTW.toggleAdminSubMenu(this);");
						$this->addAdminMenuItem('wtw_adminoptionalupgrades', 'Optional Upgrades', 400, 'wtw_invoices', 1, 'wtw_admininvoices', '', array('architect','host'), "WTW.openFullPageForm('fullpage','".$this->__('Optional Upgrades')."','wtw_optionalpage');");
					} else if (count($zresultsinvoices) > 0) {
						$this->addAdminMenuItem('wtw_adminmyinvoices2', 'My Invoices', 400, 'wtw_invoices', 0, 'wtw_myinvoices', '/content/system/images/menuinvoices.png', array('architect','host'), "WTW.openFullPageForm('fullpage','".$this->__('My Invoices')."','wtw_myinvoicepage');");
					}
				}

				$this->addAdminMenuItem('wtw_adminusers', $this->__('Users'), 500, 'wtw_users', 0, '', '/content/system/images/menuprofile.png', $adminroles, "WTW.toggleAdminSubMenu(this);");
				$this->addAdminMenuItem('wtw_adminuserlist', $this->__('All Users'), 500, 'wtw_users', 1, 'wtw_userlist', '', $adminroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminprivilegeduserlist', $this->__('Privileged Users'), 500, 'wtw_users', 2, 'wtw_userlist', '', $adminroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminlocaluserlist', $this->__('Local Users'), 500, 'wtw_users', 3, 'wtw_userlist', '', $adminroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminglobaluserlist', $this->__('Global Users'), 500, 'wtw_users', 4, 'wtw_userlist', '', $adminroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminvisitinguserlist', $this->__('Visiting Users'), 500, 'wtw_users', 5, 'wtw_userlist', '', $adminroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminuserroles', $this->__('User Roles'), 500, 'wtw_users', 10, 'wtw_roleslist', '', $adminroles, "WTW.adminMenuItemSelected(this);");
				
				$this->addAdminMenuItem('wtw_adminsettings', $this->__('Settings'), 900, 'wtw_settings', 0, '', '/content/system/images/menusettings.png', $adminroles, "WTW.toggleAdminSubMenu(this);");
				$this->addAdminMenuItem('wtw_adminserversettings', $this->__('Server Settings'), 900, 'wtw_settings', 1, 'wtw_serversettings', '', $adminroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminemailserver', $this->__('Email Server'), 900, 'wtw_settings', 2, 'wtw_emailserver', '', $adminroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminapikeys', $this->__('API Keys Access'), 900, 'wtw_settings', 6, 'wtw_apikeys', '', $adminroles, "WTW.adminMenuItemSelected(this);");
				
				$this->addAdminMenuItem('wtw_admindevtools', $this->__('Developer Tools'), 998, 'wtw_devtools', 0, '', '/content/system/images/menutools.png', $developerroles, "WTW.toggleAdminMenuLevel('tools');");
				$this->addAdminMenuItem('wtw_admindevtoolsnote', $this->__('Click F12 to view the Console then click one of the following:'), 998, 'wtw_devtools', 1, 'wtw_toolsnote', '', $developerroles, "WTW.log('');");
				$this->addAdminMenuItem('wtw_adminlistmeshes', $this->__('List Current Meshes'), 998, 'wtw_devtools', 10, 'wtw_listmeshes', '', $developerroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminlisttransformnodes', $this->__('List Transform Nodes'), 998, 'wtw_devtools', 15, 'wtw_listtransformnodes', '', $developerroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminlistcgs', $this->__('List Connecting Grids'), 998, 'wtw_devtools', 20, 'wtw_listcgs', '', $developerroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminlistazs', $this->__('List Action Zones'), 998, 'wtw_devtools', 25, 'wtw_listazs', '', $developerroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminlistcommmolds', $this->__('List Community Molds'), 998, 'wtw_devtools', 30, 'wtw_listcommmolds', '', $developerroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminlistbuildmolds', $this->__('List Building Molds'), 998, 'wtw_devtools', 35, 'wtw_listbuildmolds', '', $developerroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminlistthingmolds', $this->__('List Thing Molds'), 998, 'wtw_devtools', 40, 'wtw_listthingmolds', '', $developerroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminlistautomations', $this->__('List Automations'), 998, 'wtw_devtools', 45, 'wtw_listautomations', '', $developerroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminlistloadeduploads', $this->__('List Loaded Uploads'), 998, 'wtw_devtools', 50, 'wtw_listloadeduploads', '', $developerroles, "WTW.adminMenuItemSelected(this);");
				$this->addAdminMenuItem('wtw_adminlistmyavatarlocation', $this->__('My Avatar Location'), 998, 'wtw_devtools', 55, 'wtw_listmyavatarlocation', '', $developerroles, "WTW.adminMenuItemSelected(this);");

				if (!empty($wtw->communityid) || !empty($wtw->buildingid) || !empty($wtw->thingid) || !empty($wtw->avatarid)) {
					$this->addAdminMenuItem('wtw_admincloseproject', $this->__('Close 3D Project'), 999, 'wtw_admincloseproject', 0, '', '/content/system/images/menuclosedoor.png', $updateroles, "WTW.adminMenuItemSelected(this);");
				}
				$this->addAdminMenuItem('wtw_adminexit', $this->__('Exit Admin'), 1000, 'wtw_adminexit', 0, '', '/content/system/images/menuexit.png', null, "WTW.adminMenuItemSelected(this);");

			}
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwadminmenu.php-addAdminMenuItem=".$e->getMessage());
		}
		return $zsuccess;
	}

	public function preloadAdminSubMenu() {
		/* submenus are called as toggle on/off under main menu items */
		global $wtwdb;
		global $wtw;
		$zsuccess = false;
		try {
			/* accessrequired - array of role names or null for all allowed */
			$zupdateroles = array("admin","developer","architect","graphics artist","host");
			$zdeveloperroles = array("admin","developer");
			
			/* add admin sub menu item function: */
			/*	$zmenu = name for group of menu items
				$zid = <div> id
				$ztitle = display name
				$zsubmenusort = int for sort order of submenu
				$zaccessrequired = array of roles that are granted access - null for all allowed
				$zjsfunction = javascript function to call for onclick event examples: WTW.show('divname');   or  myFunctionName('testthis');  or  MY.functionName();MY.secondFunction();
			*/

			$this->addAdminSubMenuItem('buildingoptions', 'wtw_adminbuildinginfo', '<p>3D Building <u>I</u>nformation</p><span>(ctrl+i)</span>', 5, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('buildingoptions', 'wtw_adminbuildingrequirements', '<p><u>R</u>atings and Requirements</p><span>(ctrl+r)</span>', 6, $zupdateroles, "WTW.openFullPageForm('fullpage','Ratings and Requirements', 'wtw_requirementspage');WTW.openRequirements();");
			$this->addAdminSubMenuItem('buildingoptions', 'wtw_adminbuildingstart', '<p>Set <u>S</u>tarting Position</p><span>(ctrl+s)</span>', 10, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('buildingoptions', 'wtw_adminbuildingaccess', '<p><u>P</u>ermissions</p><span>(ctrl+p)</span>', 15, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('buildingoptions', 'wtw_adminbuildingsnapshot', '<p>3D Building Sn<u>a</u>pshot</p><span>(ctrl+a)</span>', 20, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('buildingoptions', '', '<hr class="wtw-menuhr" />', 50, $zupdateroles, "");
			$this->addAdminSubMenuItem('buildingoptions', 'wtw_adminbuildingcopy', '<p><u>C</u>opy 3D Building</p><span>(ctrl+c)</span>', 55, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('buildingoptions', 'wtw_adminbuildingshare', '<p>S<u>h</u>are 3D Building</p><span>(ctrl+h)</span>', 60, $zupdateroles, "WTW.adminMenuItemSelected(this);"); 
			$this->addAdminSubMenuItem('buildingoptions', 'wtw_adminbuildingdelete', '<p>Delete 3D Building</p><span>(ctrl+del)</span>', 100, $zupdateroles, "WTW.adminMenuItemSelected(this);");

			$this->addAdminSubMenuItem('editbuilding', 'wtw_adminbuildingaddblock', '<p>Add 3D Building <u>B</u>lock</p><span>(ctrl+b)</span>', 10, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editbuilding', 'wtw_adminbuildingaddweb', '<p>Add 3D Web <u>O</u>bject</p><span>(ctrl+o)</span>', 20, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editbuilding', 'wtw_adminbuildingaddmodel', '<p>Add 3D <u>M</u>odel</p><span>(ctrl+m)</span>', 25, $zupdateroles, "WTW.openAddNewMold('building','babylonfile');");
			$this->addAdminSubMenuItem('editbuilding', 'wtw_adminbuildingaddthing', '<p>Add 3D T<u>h</u>ing</p><span>(ctrl+h)</span>', 30, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editbuilding', 'wtw_adminbuildingactionzones', '<p>Add or Edit <u>A</u>ctions</p><span>(ctrl+a)</span>', 40, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editbuilding', '', '<hr class="wtw-menuhr" />', 999, $zupdateroles, "");
			$this->addAdminSubMenuItem('editbuilding', 'wtw_adminbuildingrecover', '<p><u>R</u>ecover Deleted Items</p><span>(ctrl+r)</span> ', 1000, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			
			$this->addAdminSubMenuItem('editmold', 'wtw_createduplicatemold', '<p>Create a Duplicate Item</p><span>(ctrl+p)</span>', 50, $zupdateroles, "WTW.adminMenuItemSelected(this);");

			$this->addAdminSubMenuItem('communityoptions', 'wtw_admincommunityinfo', '<p>3D Community <u>I</u>nformation</p><span>(ctrl+i)</span>', 5, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('communityoptions', 'wtw_admincommunityrequirements', '<p><u>R</u>atings and Requirements</p><span>(ctrl+r)</span>', 6, $zupdateroles, "WTW.openFullPageForm('fullpage','Ratings and Requirements', 'wtw_requirementspage');WTW.openRequirements();");
			$this->addAdminSubMenuItem('communityoptions', 'wtw_admincommunitystart', '<p>Set <u>S</u>tarting Position</p><span>(ctrl+s)</span>', 10, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('communityoptions', 'wtw_admincommunityfirstbuilding', '<p>Set <u>F</u>irst 3D Building</p><span>(ctrl+f)</span>', 15, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('communityoptions', 'wtw_admincommunitygravity', '<p>3D Community <u>G</u>ravity</p><span>(ctrl+g)</span>', 20, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('communityoptions', 'wtw_admincommunityaccess', '<p><u>P</u>ermissions</p><span>(ctrl+p)</span>', 25, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('communityoptions', 'wtw_admincommunitysnapshot', '<p>3D Community Sn<u>a</u>pshot</p><span>(ctrl+a)</span>', 30, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('communityoptions', '', '<hr class="wtw-menuhr" />', 50, $zupdateroles, "");
			$this->addAdminSubMenuItem('communityoptions', 'wtw_admincommunitycopy', '<p><u>C</u>opy 3D Community</p><span>(ctrl+c)</span>', 55, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('communityoptions', 'wtw_admincommunityshare', '<p>S<u>h</u>are 3D Community</p><span>(ctrl+h)</span>', 60, $zupdateroles, "WTW.adminMenuItemSelected(this);"); 
			$this->addAdminSubMenuItem('communityoptions', 'wtw_admincommunitydelete', '<p>Delete 3D Community</p><span>(ctrl+del)</span>', 100, $zupdateroles, "WTW.adminMenuItemSelected(this);");

			$this->addAdminSubMenuItem('editcommunity', 'wtw_admincommunityaddblock', '<p>Add 3D Building <u>B</u>lock</p><span>(ctrl+b)</span>', 10, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editcommunity', 'wtw_admincommunityaddweb', '<p>Add 3D Web <u>O</u>bject</p><span>(ctrl+o)</span>', 20, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editcommunity', 'wtw_admincommunityaddmodel', '<p>Add 3D <u>M</u>odel</p><span>(ctrl+m)</span>', 25, $zupdateroles, "WTW.openAddNewMold('community','babylonfile');");
			$this->addAdminSubMenuItem('editcommunity', 'wtw_admincommunityaddbuilding', '<p>Add 3D B<b>u</b>ilding</p><span>(ctrl+u)</span>', 30, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editcommunity', 'wtw_admincommunityaddthing', '<p>Add 3D T<u>h</u>ing</p><span>(ctrl+h)</span>', 30, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editcommunity', 'wtw_admincommunityactionzones', '<p>Add or Edit <u>A</u>ctions</p><span>(ctrl+a)</span>', 40, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editcommunity', '', '<hr class="wtw-menuhr" />', 60, $zupdateroles, "");
			$this->addAdminSubMenuItem('editcommunity', 'wtw_admincommunitylandscape', '<p>Edit <u>L</u>andscape and Scene</p><span>(ctrl+l)</span>', 65, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editcommunity', '', '<hr class="wtw-menuhr" />', 100, $zupdateroles, "");
			$this->addAdminSubMenuItem('editcommunity', 'wtw_admincommunityrecover', '<p><u>R</u>ecover Deleted Items</p><span>(ctrl+r)</span>', 1000, $zupdateroles, "WTW.adminMenuItemSelected(this);");

			$this->addAdminSubMenuItem('editlandscape', 'wtw_adminlandscapesky', '<p>Sky</p>', 10, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editlandscape', 'wtw_adminlandscapeground', '<p>Extended Ground</p>', 20, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editlandscape', 'wtw_adminlandscapewater', '<p>Water, Waves, and Wind</p>', 30, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editlandscape', 'wtw_adminlandscapegravity', '<p>Gravity</p>', 40, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editlandscape', 'wtw_adminlandscapeterrain', '<p>Add Ground Terrain</p>', 50, $zupdateroles, "WTW.adminMenuItemSelected(this);");

			$this->addAdminSubMenuItem('thingoptions', 'wtw_adminthinginfo', '<p>3D Thing <u>I</u>nformation</p><span>(ctrl+i)</span>', 5, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('thingoptions', 'wtw_adminthingrequirements', '<p><u>R</u>atings and Requirements</p><span>(ctrl+r)</span>', 6, $zupdateroles, "WTW.openFullPageForm('fullpage','Ratings and Requirements', 'wtw_requirementspage');WTW.openRequirements();");
			$this->addAdminSubMenuItem('thingoptions', 'wtw_adminthingstart', '<p>Set <u>S</u>tarting Position</p><span>(ctrl+s)</span>', 10, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('thingoptions', 'wtw_adminthingaccess', '<p><u>P</u>ermissions</p><span>(ctrl+p)</span>', 15, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('thingoptions', 'wtw_adminthingsnapshot', '<p>3D Thing Sn<u>a</u>pshot</p><span>(ctrl+a)</span>', 20, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('thingoptions', '', '<hr class="wtw-menuhr" />', 50, $zupdateroles, "");
			$this->addAdminSubMenuItem('thingoptions', 'wtw_adminthingcopy', '<p><u>C</u>opy 3D Thing</p><span>(ctrl+c)</span>', 55, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('thingoptions', 'wtw_adminthingshare', '<p>S<u>h</u>are 3D Thing</p><span>(ctrl+h)</span>', 60, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('thingoptions', 'wtw_adminthingdelete', '<p>Delete 3D Thing</p><span>(ctrl+del)</span>', 100, $zupdateroles, "WTW.adminMenuItemSelected(this);");

			$this->addAdminSubMenuItem('editthing', 'wtw_adminthingaddblock', '<p>Add 3D Building <u>B</u>lock</p><span>(ctrl+b)</span>', 10, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editthing', 'wtw_adminthingaddweb', '<p>Add 3D Web <u>O</u>bject</p><span>(ctrl+o)</span>', 20, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editthing', 'wtw_adminthingaddmodel', '<p>Add 3D <u>M</u>odel</p><span>(ctrl+m)</span>', 30, $zupdateroles, "WTW.openAddNewMold('thing','babylonfile');");
			$this->addAdminSubMenuItem('editthing', 'wtw_adminthingactions', '<p>Add or Edit <u>A</u>ctions</p><span>(ctrl+a)</span>', 40, $zupdateroles, "WTW.adminMenuItemSelected(this);");
			$this->addAdminSubMenuItem('editthing', '', '<hr class="wtw-menuhr" />', 100, $zupdateroles, "");
			$this->addAdminSubMenuItem('editthing', 'wtw_adminthingrecover', '<p><u>R</u>ecover Deleted Items</p><span>(ctrl+r)</span>', 1000, $zupdateroles, "WTW.adminMenuItemSelected(this);");
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwadminmenu.php-preloadAdminSubMenu=".$e->getMessage());
		}
		return $zsuccess;
	}

	public function addAdminMenuItem($zid, $ztitle, $zmenusort, $zmenu, $zsubmenusort, $zsubmenu, $ziconurl, $zaccessrequired, $zjsfunction) {
		/* add admin menu item function: */
		/*	$zid = <div> id
			$ztitle = display name
			$zmenusort = int for sort order of menu (level 1)
			$zmenu = top level menu item
			$zsubmenusort = int for sort order of submenu (level 2)
			$zsubmenu = second level menu item (or '')
			$ziconurl = browse path to icon image (only applies to level 1 'menu')
			$zaccessrequired = array of roles that are granted access - null for all allowed
			$zjsfunction = javascript function to call for onclick event examples: WTW.show('divname');   or  myFunctionName('testthis');  or  MY.functionName();MY.secondFunction();
		*/
		global $wtwdb;
		$zsuccess = false;
		try {
			/* check if loaded to avoid duplicate ids */
			$zfound = false;
			foreach ($this->adminmenu as $zadminmenuitems) {
				if ($wtwdb->hasValue($zadminmenuitems["id"])) {
					if ($zadminmenuitems["id"] == $zid) {
						$zfound = true;
					}
				}
			}
			if ($zfound == false) {
				/* add menu item to the array */
				$zmenuitem = array(
					'menu' => $zmenu, 
					'id' => $zid,
					'title' => $ztitle,
					'menusort' => $zmenusort, 
					'submenusort' => $zsubmenusort, 
					'submenu' => $zsubmenu, 
					'iconurl' => $ziconurl, 
					'accessrequired' => $zaccessrequired, 
					'jsfunction' => $zjsfunction
				);
				$this->adminmenu[count($this->adminmenu)] = $zmenuitem;
				$zsuccess = true;
			}
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwadminmenu.php-addAdminMenuItem=".$e->getMessage());
		}
		return $zsuccess;
	}
	
	public function getAdminMenu() {
		/* get admin menu array, sort, and return html text for display on admin.php page */
		global $wtw;
		global $wtwdb;
		$zadminmenu = "";
		try {
			$adminmenuarray = $this->adminmenu;
			/* make sure submenu items have matching menu sort index */
			array_multisort(array_column($adminmenuarray, 'menu'),  SORT_ASC,
                array_column($adminmenuarray, 'submenusort'), SORT_ASC,
                $adminmenuarray);
			$ztempmenu = "";
			$ztempmenusort = "";
			foreach ($adminmenuarray as $zmenuitem) {
				if ($ztempmenu != $zmenuitem["menu"]) {
					$ztempmenusort = $zmenuitem["menusort"];
				} else {
					$zmenuitem["menusort"] = $ztempmenusort;
				}
			} 
			/* sort menu and submenus */
			array_multisort(array_column($adminmenuarray, 'menusort'),  SORT_ASC,
                array_column($adminmenuarray, 'submenusort'), SORT_ASC,
                $adminmenuarray);
			/* display menu */
			$ztempmenu = "";
			$ztempid = "";
			/* read each value, validate data, and create html menu items */
			foreach ($adminmenuarray as $zmenuitem) {
				$zid = $zmenuitem["id"];
				$ztitle = $zmenuitem["title"];
				$zmenusort = $zmenuitem["menusort"];
				$zmenu = $zmenuitem["menu"];
				$zsubmenusort = $zmenuitem["submenusort"];
				$zsubmenu = $zmenuitem["submenu"];
				$ziconurl = $zmenuitem["iconurl"];
				$zaccessrequired = $zmenuitem["accessrequired"]; /* array of allowed roles */
				$zjsfunction = $zmenuitem["jsfunction"];
				if ($wtwdb->hasPermission($zaccessrequired)) {
					/* check for invalid entries */
					if (!isset($zid) || empty($zid)) {
						$zid = $wtwdb->getRandomString(5,1);
					}
					if (!isset($ztitle) || empty($ztitle)) {
						$ztitle = 'Menu Item';
					}
					if (!isset($ziconurl) || empty($ziconurl)) {
						$ziconurl = "/content/system/images/menuarrow.png";
					}
					if (!isset($zjsfunction) || empty($zjsfunction)) {
						$zjsfunction = '';
					}
					if ($ztempmenu != $zmenu) {
						if (!empty($ztempmenu)) {
							$zadminmenu .= "</div>";
						}
						$ztempid = $zid;
						$zadminmenu .= "<div id=\"".$zid."\" class=\"wtw-adminmenu\" onclick=\"WTW.adminOpenSubmenu(this);".$zjsfunction."\">";
						$zadminmenu .= "<div class='img'>";
						$zadminmenu .= "<img src=\"".$ziconurl."\" alt=\"".$ztitle."\" title=\"".$ztitle."\" class='wtw-menulefticon' />";
						$zadminmenu .= "</div>";
						$zadminmenu .= "<div id=\"".$zid."badge\" class=\"wtw-badge\"></div>";
						$zadminmenu .= "<div class='text'>".$ztitle."</div>";
						$zadminmenu .= "</div>";
						/* prep for submenu items */
						$zadminmenu .= "<div id=\"".$zid."div\" class=\"wtw-adminmenudiv\" >";
					}
					if ($wtwdb->hasValue($zsubmenu)) {
						$zadminmenu .= "<div id=\"".$zid."\" class=\"wtw-adminsubmenu\" onclick=\"".$zjsfunction."\"><div id=\"".$zid."badge\" class=\"wtw-badge\"></div>".$ztitle."</div>";
					}
					$ztempmenu = $zmenu;
				}
			}
			if (count($this->adminmenu) > 0) {
				$zadminmenu .= "</div>";
			}
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwadminmenu.php-getAdminMenu=".$e->getMessage());
		}
		return $zadminmenu;
	}

	public function addAdminSubMenuItem($zmenu, $zid, $ztitle, $zsubmenusort, $zaccessrequired, $zjsfunction) {
		/* add admin sub menu item function: */
		/*	$zmenu = name for group of menu items
			$zid = <div> id
			$ztitle = display name
			$zsubmenusort = int for sort order of submenu
			$zaccessrequired = array of roles that are granted access - null for all allowed
			$zjsfunction = javascript function to call for onclick event examples: WTW.show('divname');   or  myFunctionName('testthis');  or  MY.functionName();MY.secondFunction();
		*/
		global $wtwdb;
		$zsuccess = false;
		try {
			/* check if loaded to avoid duplicate ids */
			$zfound = false;
			foreach ($this->adminsubmenu as $zadminsubmenuitems) {
				if ($wtwdb->hasValue($zadminsubmenuitems["id"])) {
					if ($zadminsubmenuitems["id"] == $zid) {
						$zfound = true;
					}
				}
			}
			if ($zfound == false) {
				/* add submenu item to the array */
				$zsubmenuitem = array(
					'menu' => $zmenu, 
					'id' => $zid,
					'title' => $ztitle,
					'submenusort' => $zsubmenusort, 
					'accessrequired' => $zaccessrequired, 
					'jsfunction' => $zjsfunction
				);
				$this->adminsubmenu[count($this->adminsubmenu)] = $zsubmenuitem;
				$zsuccess = true;
			}
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwadminmenu.php-addAdminSubMenuItem=".$e->getMessage());
		}
		return $zsuccess;
	}
	
	public function getAdminSubMenu($zselectmenu) {
		/* get admin menu array, sort, and return html text for display on admin.php page */
		global $wtw;
		global $wtwdb;
		$zadminsubmenu = "";
		try {
			$adminmenuarray = $this->adminsubmenu;
			/* make sure submenu items have matching menu sort index */
			array_multisort(array_column($adminmenuarray, 'menu'),  SORT_ASC,
                array_column($adminmenuarray, 'submenusort'), SORT_ASC,
                $adminmenuarray);
			/* read each value, validate data, and create html menu items */
			foreach ($adminmenuarray as $zmenuitem) {
				$zmenu = $zmenuitem["menu"];
				$zid = $zmenuitem["id"];
				$ztitle = $zmenuitem["title"];
				$zsubmenusort = $zmenuitem["submenusort"];
				$zaccessrequired = $zmenuitem["accessrequired"]; /* array of allowed roles */
				$zjsfunction = $zmenuitem["jsfunction"];
				if ($wtwdb->hasPermission($zaccessrequired) && $zmenu == $zselectmenu) {
					/* check for invalid entries */
					if (!isset($zid) || empty($zid)) {
						$zid = $wtwdb->getRandomString(5,1);
					}
					if (!isset($ztitle) || empty($ztitle)) {
						$ztitle = 'Menu Item';
					}
					if (!isset($zjsfunction) || empty($zjsfunction)) {
						$zjsfunction = '';
					}
					$zadminsubmenu .= "<div id=\"".$zid."\" class=\"wtw-menulevel2\" onclick=\"WTW.adminOpenSubmenuForm(this);".$zjsfunction."\">".$ztitle."</div>";
				}
			}
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwadminmenu.php-getAdminSubMenu=".$e->getMessage());
		}
		return $zadminsubmenu;
	}

	public function addAdminMenuForm($zformid, $ztitle, $zformdata, $zaccessrequired) {
		/* some menu items display a complete form */
		/* this allows forms to be added dynamically from plugins */
		global $wtwdb;
		$zsuccess = false;
		try {
			/* check for duplicate ids */
			$zfound = false;
			foreach ($this->adminforms as $zadminform) {
				if ($wtwdb->hasValue($zadminform["formid"])) {
					if ($zadminform["formid"] == $zformid) {
						$zfound = true;
					}
				}
			}
			if ($zfound == false) {
				/* add form to array of forms */
				$zform = array(
					'formid' => $zformid,
					'title' => $ztitle,
					'formdata' => $zformdata,
					'accessrequired' => $zaccessrequired
				);
				$this->adminforms[count($this->adminforms)] = $zform;
				$zsuccess = true;
			}
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-addAdminMenuForm=".$e->getMessage());
		}
		return $zsuccess;
	}	
	
	public function getAdminMenuForms() {
		/* retrieve the admin menu forms to be displayed in html on the admin.php page */
		/* forms start with display:none and visibility:hidden until called */
		global $wtwdb;
		$zmenuforms = "";
		try {
			foreach ($this->adminforms as $zform) {
				$zformid = $zform["formid"];
				$ztitle = $zform["title"];
				$zaccessrequired = $zform["accessrequired"]; /* array of allowed roles */
				$zformdata = $zform["formdata"];
				if ($wtwdb->hasPermission($zaccessrequired) || !isset($zaccessrequired) || empty($zaccessrequired)) {
					/* check for invalid entries */
					if (!isset($zformid) || empty($zformid)) {
						$zformid = $wtwdb->getRandomString(6,1);
					}
					if (!isset($zformdata) || empty($zformdata)) {
						$zformdata = '';
					}
					/* this wraps your form data with a title and close form links */
					if ($wtwdb->hasValue($zformdata)) {
						$zmenuforms .= "<div id=\"".$zformid."\" class=\"wtw-adminmenuform wtw-hide\">";
						$zmenuforms .= "	<div class='submenu-header'>";
						$zmenuforms .= "		<div id=\"wtw_bback ".$zformid."\" alt=\"Back\" title=\"Back\" class=\"wtw-backbutton\" onclick=\"WTW.adminMenuItemSelected(this);\">Back</div>";
						$zmenuforms .= "		<div class=\"wtw-menuheader\">".$ztitle."</div>";
						$zmenuforms .= "	</div>";
						$zmenuforms .= $zformdata;
						$zmenuforms .= "</div>";
					}
				}
			}			
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-getAdminMenuForms=".$e->getMessage());
		}
		return $zmenuforms;
	}	

	public function addAdminMenuDiv($zformlocation, $zdivid, $zdivdata, $zaccessrequired) {
		/* this allows a div to be added to an admin menu item */
		global $wtwdb;
		$zsuccess = false;
		try {
			/* check for duplicate ids */
			$zfound = false;
			foreach ($this->admindivs as $zadminform) {
				if ($wtwdb->hasValue($zadminform["divid"])) {
					if ($zadminform["divid"] == $zdivid) {
						$zfound = true;
					}
				}
			}
			if ($zfound == false) {
				/* add admin div area to the array of admin divs */
				$zdiv = array(
					'formlocation' => $zformlocation,
					'divid' => $zdivid,
					'divdata' => $zdivdata,
					'accessrequired' => $zaccessrequired
				);
				
				$this->admindivs[count($this->admindivs)] = $zdiv;
				$zsuccess = true;
			}
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-addAdminMenuDiv=".$e->getMessage());
		}
		return $zsuccess;
	}	

	public function getAdminMenuDivs($zformlocation) {
		/* get html for the admin menu divs by form location (where in the menu it will reside) */
		global $wtwdb;
		$zmenudivs = "";
		try {
			foreach ($this->admindivs as $zdiv) {
				$zdivformlocation = $zdiv["formlocation"];
				if ($zdivformlocation == $zformlocation) {
					$zdivid = $zdiv["divid"];
					$zaccessrequired = $zdiv["accessrequired"]; /* array of allowed roles */
					$zdivdata = $zdiv["divdata"];
					if ($wtwdb->hasPermission($zaccessrequired) || !isset($zaccessrequired) || empty($zaccessrequired)) {
						/* check for invalid entries */
						if (!isset($zdivid) || empty($zdivid)) {
							$zdivid = $wtwdb->getRandomString(6,1);
						}
						if (!isset($zdivdata) || empty($zdivdata)) {
							$zdivdata = '';
						}
						if ($wtwdb->hasValue($zdivdata)) {
							$zmenudivs .= $zdivdata;
						}
					}
				}
			}
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-getAdminMenuDivs=".$e->getMessage());
		}
		return $zmenudivs;
	}	

	public function getAdminMenuLayout() {
		/* get html for the admin menu layout */
		global $wtwdb;
		$zmenu = '';
		try {
			$zmenu .= "<div id='wtw_adminmenubutton' class='wtw-mainmenubutton ' onclick=\"WTW.toggleAdminMenu(this.id, 'left');WTW.blockPassThrough();\" onmouseover=\"WTW.hide('wtw_itooltip');\">\r\n";
			$zmenu .= "<div id='wtw_adminmenuleft' class='wtw-arrowleft ' style='display:none;'></div>\r\n";
			$zmenu .= "<div class='wtw-menubuttontext ' style='display:none;'>".$this->__("Admin")."</div>\r\n";
			$zmenu .= "<div id='wtw_adminmenuright' class='wtw-arrowright ' style='display:none;'></div>\r\n";
			$zmenu .= "</div>\r\n";
			$zmenu .= "<div id='wtw_adminmenu' class='wtw-mainmenu' onmouseover=\"WTW.hide('wtw_itooltip');\" onclick='WTW.blockPassThrough();'>\r\n";
			$zmenu .= "		<div id='wtw_adminmenu3d' class='wtw-mainmenu3d'>\r\n";
			$zmenu .= "			<div id='wtw_adminmenuscroll' class='wtw-mainmenuscroll'>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu1' class='wtw-adminmenuform wtw-show'>\r\n";
			$zmenu .= "					<div class='wtw-menuheader'>";
			$zmenu .= "						<img src='/content/plugins/wtw-3dinternet/assets/images/menuworld.png' />";
			$zmenu .= "						<span>".$this->__('Admin Menu')."</span>";
			$zmenu .= "					</div>";
			$zmenu .= 						$this->getAdminMenu()."\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu2' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback2' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Select 3D Building')."</div>";
			$zmenu .= "					</div>";
			$zmenu .= "					<div id='wtw_loadingbuildingid' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>";
			$zmenu .= "					<div id='wtw_listbuildings'></div>\r\n";
			$zmenu .= "					<div class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu4' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback4' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Options and Settings')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= 						$this->getAdminSubMenu('buildingoptions')."\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel4' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Done')."<span>(ctrl+d)</span></div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu5' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback5' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('3D Building Information')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div id='wtw_loadingbuildingform' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= 						$this->getAdminWebMenu('wtw_adminmenu5b', 'building');
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel5' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu6' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback6' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Edit 3D Building')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='wtw-menulevel0text'><strong>Right Click</strong> an Item on your scene to <strong>Edit</strong> the Item or select from the following:</div>\r\n";
			$zmenu .= 						$this->getAdminSubMenu('editbuilding')."\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel6' class='wtw-greenbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Done Editing')."<span>(ctrl+d)</span></div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu9' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback9' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>Share My3D Buildingas Template</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<a href='https://www.Roomz.com/wiki/share-3d-objects/' title='Help' alt='Help' class='wtw-helplink' target='_blank'>?</a>\r\n";
			$zmenu .= "					<div id='wtw_loadingsharebuildingform' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= 						$this->getAdminShareMenu('wtw_adminmenu9b', 'building');
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_bsharebuildingtemp' class='wtw-greenbuttonbig' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Share 3D Building as Template')."</div>\r\n";
			$zmenu .= "					<div id='wtw_adminmenubuildsharecancel' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu10' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback10' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Add 3D Building Block')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<a href='https://www.Roomz.com/wiki/create-a-3d-building-3d-building-blocks/' title='Help' alt='Help' class='wtw-helplink' target='_blank'>?</a>\r\n";
			$zmenu .= "					<div id='wtw_moldsbuttonlist'></div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel10' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu11' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback11' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div id='wtw_editmoldformtitle' class='wtw-menuheader'>".$this->__('Edit 3D Building Block')."</div>";
			$zmenu .= "					</div>";
			$zmenu .= 						$this->getAdminMoldMenu(); 
			$zmenu .= 						$this->getAdminSubMenu('editmold')."\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_bsavethismold' class='wtw-greenbutton' onclick='WTW.submitMoldForm(1);WTW.hideAdminMenu();WTW.backToEdit();'>".$this->__('Save Mold')."<span>(ctrl+s)</span></div>\r\n";
			$zmenu .= "					<div class='two-btns'>";
			$zmenu .= "						<div id='wtw_bdelmold' class='wtw-redbutton' onclick='WTW.submitMoldForm(0);'>".$this->__('Delete Mold')."<span>(ctrl+d)</span></div>\r\n";
			$zmenu .= "						<div id='wtw_bcancelmold' class='wtw-greenbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu12' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback12' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Add 3D Web Object')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<a href='https://www.Roomz.com/wiki/3d-web-objects/' title='Help' alt='Help' class='wtw-helplink' target='_blank'>?</a>\r\n";
			$zmenu .= "					<div id='wtw_webmoldsbuttonlist'></div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel12' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu13' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback13' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Add 3D Thing')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<a href='https://www.Roomz.com/wiki/add-3d-things-to-3d-buildings-or-3d-communities/' title='Help' alt='Help' class='wtw-helplink' target='_blank'>?</a>\r\n";
			$zmenu .= "					<div id='wtw_loadingthingbuttonlist' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= 					$this->getAdminMenuDivs('add3dthing');
			$zmenu .= "					<div id='wtw_thingbuttonlist'></div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel13' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu14' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback14' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div id='wtw_editconnectinggridsformtitle' class='wtw-menuheader'>".$this->__('Edit 3D Building Location')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= 						$this->getAdminConnectingGridMenu();
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_beditconnectinggrid' class='wtw-greenbutton' onclick='WTW.submitConnectingGridsForm(1);'>".$this->__('Save Location')."</div>\r\n";
			$zmenu .= "					<div class='two-btns'>";
			$zmenu .= "						<div id='wtw_bdelconnectinggrid' class='wtw-redbutton' onclick=\"WTW.openConfirmation('Delete Building from this Community');\">".$this->__('Delete 3D Building')."</div>\r\n";
			$zmenu .= "						<div id='wtw_cancel14' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu15' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback15' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Add or Edit Actions')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div id='wtw_editexistingactionzonediv'>\r\n";
			$zmenu .= "						<div class='select-input-field'>\r\n";
			$zmenu .= "							<p class='wtw-marginbottom'>".$this->__('Select Action Zone to Edit');
			$zmenu .= "								<a href='https://www.Roomz.com/wiki/introduction-to-action-zones/' title='Help' alt='Help' class='wtw-helplink' target='_blank'>?</a>\r\n";
			$zmenu .= "							</p>";
			$zmenu .= "							<select id='wtw_selectactionzoneid' class='wtw-pointer'>";
			$zmenu .= "								<option value='0'>".$this->__('Select Action Zone')."</option>";
			$zmenu .= "							</select>";
			$zmenu .= "						</div>";
			$zmenu .= "						<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "						<h2 class='wtw-marginbottom'>".$this->__('Add New Action Zone')."</h2>\r\n";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "					<div id='wtw_actionzonesbuttonlist'></div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel15' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu16' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback16' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Recover Deleted Items')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<h2 class='wtw-marginbottom'>".$this->__('Deleted Items')."</h2>\r\n";
			$zmenu .= "					<div id='wtw_deleteditemslist'></div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel16' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu20' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback20' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div id='wtw_editactionzoneformtitle' class='wtw-menuheader'>".$this->__('Edit Action Zone')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= 						$this->getAdminActionzoneMenu();
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_beditactionzone' class='wtw-greenbuttonbig' onclick='WTW.submitActionZoneForm(1);'>".$this->__('Save Action Zone')."</div>\r\n";
			$zmenu .= "					<div class='two-btns'>";
			$zmenu .= "						<div id='wtw_bdelactionzone' class='wtw-redbutton' onclick='WTW.submitActionZoneForm(0);'>".$this->__('Delete Action Zone')."</div>\r\n";
			$zmenu .= "						<div id='wtw_cancel20' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu22' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback22' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Select 3D Community')."</div>";
			$zmenu .= "					</div>";
			$zmenu .= "					<div id='wtw_loadingcommunityid' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= "					<div id='wtw_listcommunities'></div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel22' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu24' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback24' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Options and Settings')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= 						$this->getAdminSubMenu('communityoptions')."\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_adminmenucommdone' class='wtw-greenbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Done')."<span>(ctrl+d)</span></div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu25' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback25' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('3D Community Information')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div id='wtw_loadingcommunityform' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= 						$this->getAdminWebMenu('wtw_adminmenu25b', 'community');
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel25' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu26' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback26' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Edit 3D Community')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='wtw-menulevel0text'><strong>Right Click</strong> an Item on your scene to <strong>Edit</strong> the Item or select from the following:</div>\r\n";
			$zmenu .= 						$this->getAdminSubMenu('editcommunity')."\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_adminmenucommdoneediting' class='wtw-greenbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Done Editing')."<span>(ctrl+d)</span></div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu27' class='wtw-adminmenuform wtw-hide' style='color:#FFF7DA;'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback27' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Add 3D Building')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div id='wtw_loadingbuildingbuttonlist' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= 					$this->getAdminMenuDivs('add3dbuilding');
			$zmenu .= "					<div id='wtw_buildingbuttonlist'></div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel27' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu28' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback28' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Set First 3D Building')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= 						$this->getAdminFirstBuildingMenu();
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_beditfirstbuilding' class='wtw-greenbuttonbig' onclick='WTW.submitFirstBuildingForm(1);'>".$this->__('Save Location')."</div>\r\n";
			$zmenu .= "					<div id='wtw_cancel28' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu29' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback29' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>Share My3D Communityas Template</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<a href='https://www.Roomz.com/wiki/share-3d-objects/' title='Help' alt='Help' class='wtw-helplink' target='_blank'>?</a>\r\n";
			$zmenu .= "					<div id='wtw_loadingsharecommunityform' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= 						$this->getAdminShareMenu('wtw_adminmenu29b', 'community');
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_bsharecommunitytemp' class='wtw-greenbuttonbig' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Share 3D Community as Template')."</div>\r\n";
			$zmenu .= "					<div id='wtw_cancel29' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu30' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback30' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Edit Landscape and Scene')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='wtw-menulevel0text'><strong>Right Click</strong> a Terrain (Mountains, Islands, etc...) on your scene to <strong>Edit</strong> the Terrain or select from the following:</div>\r\n";
			$zmenu .= 						$this->getAdminSubMenu('editlandscape')."\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel30' class='wtw-greenbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Done with Scene')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu32' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback32' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Select 3D Thing')."</div>";
			$zmenu .= "					</div>";
			$zmenu .= "					<div id='wtw_loadingthingid' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= "					<div id='wtw_listthings'></div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu34' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback34' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Options and Settings')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= 						$this->getAdminSubMenu('thingoptions')."\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_adminmenuthingdone' class='wtw-greenbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Done')."<span>(ctrl+d)</span></div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu35' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback35' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('3D Thing Information')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div id='wtw_loadingthingform' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= 						$this->getAdminWebMenu('wtw_adminmenu35b', 'thing');
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel35' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu36' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback36' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Edit 3D Thing')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='wtw-menulevel0text'><strong>Right Click</strong> an Item on your scene to <strong>Edit</strong> the Item or select from the following:</div>\r\n";
			$zmenu .= 						$this->getAdminSubMenu('editthing')."\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_adminmenuthingdoneediting' class='wtw-greenbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Done Editing')."<span>(ctrl+d)</span></div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu39' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback39' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>Share My3D Thingas Template</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<a href='https://www.Roomz.com/wiki/share-3d-objects/' title='Help' alt='Help' class='wtw-helplink' target='_blank'>?</a>\r\n";
			$zmenu .= "					<div id='wtw_loadingsharethingform' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= 						$this->getAdminShareMenu('wtw_adminmenu39b', 'thing');
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_bsharethingtemplate' class='wtw-greenbuttonbig' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Share 3D Thing as Template')."</div>\r\n";
			$zmenu .= "					<div id='wtw_cancel39' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu40' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback40' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Sky Settings')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<a href='https://www.Roomz.com/wiki/3d-community-sky-settings/' title='Help' alt='Help' class='wtw-helplink' target='_blank'>?</a>\r\n";
			$zmenu .= "					<div id='wtw_loadingskysettingsform' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= 						$this->getAdminSkyDomeMenu();
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_bsaveeditskydome' class='wtw-greenbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Save Sky')."</div>\r\n";
			$zmenu .= "					<div id='wtw_cancel40' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu41' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback41' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Ground Settings')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<a href='https://www.Roomz.com/wiki/3d-community-ground-settings/' title='Help' alt='Help' class='wtw-helplink' target='_blank'>?</a>\r\n";
			$zmenu .= "					<div id='wtw_loadinggroundsettingsform' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= 						$this->getAdminGroundSettingsMenu();
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_bsaveground' class='wtw-greenbuttonbig' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Save Ground')."</div>\r\n";
			$zmenu .= "					<div id='wtw_cancel41' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu42' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback42' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Water, Waves, and Wind')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<a href='https://www.Roomz.com/wiki/3d-community-water-depth/' title='Help' alt='Help' class='wtw-helplink' target='_blank'>?</a>\r\n";
			$zmenu .= "					<div id='wtw_loadingwaterdepthform' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= 						$this->getAdminWaterDepthMenu();
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_bsavewaterdepth' class='wtw-greenbuttonbig' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Save Water Settings')."</div>\r\n";
			$zmenu .= "					<div id='wtw_cancel42' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu44' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback44' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Set Default Start Position')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='wtw-menulevel0text wtw-leftalign'>Move to the location and view angle you would like for the default start position in your 3D Website then click <strong>Use Current Position</strong> to Save the <strong>Default Start Location</strong>Note: Avatars will appear in a random distance (within 10 units) from the start position. Additional Spawn Zones of any size can be added under the <strong>Add / Edit Action Zones</strong></div>\r\n";
			$zmenu .= "					<div id='wtw_startsaved' class='wtw-greenmessage'>".$this->__('Starting Position Saved')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_setstartposition' class='wtw-greenbuttonbig' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Use Current Position')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_spawnadvancedoptslink' onclick=\"WTW.toggleAdvanced(this, 'wtw_spawnadvancedopts');\" class='wtw-showhideadvanced'>Advanced Options</div>\r\n";
			$zmenu .= "					<div id='wtw_spawnadvancedopts' class='wtw-advanced'>";
			$zmenu .= "						\r\n";
			$zmenu .= "						<div class='select-input-field'>\r\n";
			$zmenu .= "							<p class='wtw-center'>Select Default Spawn Zone</p>\r\n";
			$zmenu .= "							<select id='wtw_tdefaultspawnzone' class='wtw-pointer'></select>\r\n";
			$zmenu .= "						</div>\r\n";
			$zmenu .= "						<div id='wtw_savespawnzone' class='wtw-greenbuttonbig' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Save Spawn Zone')."</div>\r\n";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "					<div id='wtw_cancel44' class='wtw-greenbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Done')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu45' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback45' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('3D Community Gravity')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='wtw-one-items single'>";			
			$zmenu .= "						<h2>".$this->__('Amount of Gravity');
			$zmenu .= "							<a href='https://www.Roomz.com/wiki/3d-community-gravity/' title='Help' alt='Help' class='wtw-helplink' target='_blank'>?</a>";
			$zmenu .= "						</h2>";
			$zmenu .= "						<div class='wtw-onecol'>";
			$zmenu .= "							<input type='text' id='wtw_tcommgravity' maxlength='16' class='wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setGravity();\" />\r\n";			
			$zmenu .= "							<div class='item-input-down'>";
			$zmenu .= "								<input type='button' id='wtw_bcommgravity4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tcommgravity', -1);\" onmouseup='WTW.changeStop();WTW.setGravity();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-down1'>";
			$zmenu .= "								<input type='button' id='wtw_bcommgravity3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tcommgravity', -.01);\" onmouseup='WTW.changeStop();WTW.setGravity();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up1'>";
			$zmenu .= "								<input type='button' id='wtw_bcommgravity2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tcommgravity', .01);\" onmouseup='WTW.changeStop();WTW.setGravity();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up'>";
			$zmenu .= "								<input type='button' id='wtw_bcommgravity1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tcommgravity', 1);\" onmouseup='WTW.changeStop();WTW.setGravity();' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "						</div>";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='wtw-menulevel0text wtw-leftalign'>This <strong>Gravity</strong> setting will control the Gravity applied to the Avatars browsing in your <strong>production 3D Community</strong>.Note that the <strong>3D Editor</strong> has a gravity setting that allows you to turn Gravity Off or On when you are editing and does not affect production.Hint: Earth's Gravity is 9.8</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_savecommgravity' class='wtw-greenbuttonbig' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Save Gravity')."</div>\r\n";
			$zmenu .= "					<div id='wtw_cancel45' class='wtw-greenbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Done')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu60' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback60' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('Permissions')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div id='wtw_loadinguserdevaccessform' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= 						$this->getAdminUserDevAccessMenu();
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel60' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu61' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback61' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div class='wtw-menuheader'>".$this->__('3D Community Browse Access')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div id='wtw_loadinguserdevaccessform2' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= 						$this->getAdminUserAccessMenu();
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel61' class='wtw-yellowbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Cancel')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_adminmenu69' class='wtw-adminmenuform wtw-hide'>\r\n";
			$zmenu .= "					<div class='submenu-header'>";
			$zmenu .= "						<div id='wtw_bback69' alt='Back' title='Back' class='wtw-backbutton' onclick='WTW.adminMenuItemSelected(this);'>Back</div>\r\n";
			$zmenu .= "						<div id='wtw_snapshottitle' class='wtw-menuheader'>".$this->__('3D Community Snapshot')."</div>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div id='wtw_loadingupdatesnapshot' class='wtw-loadingnoticecentered'><div></div><div></div><div></div></div>\r\n";
			$zmenu .= 						$this->getAdminSnapshotMenu();
			$zmenu .= "					\r\n";
			$zmenu .= "					<div id='wtw_cancel69' class='wtw-greenbutton' onclick='WTW.adminMenuItemSelected(this);'>".$this->__('Done')."</div>\r\n";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";

			$zmenu .= 				$this->getAdminMenuForms()."\r\n";
			$zmenu .= "			</div>\r\n";
			if ($wtwdb->hasPermission(array('admin','developer','architect','graphics artist','host'))) { 
				$zmenu .= "			<div id='wtw_quickeditorsettings' class='wtw-quickeditorsettings hide'>";
				$zmenu .= "				<div class='wtw-quicktitle' onclick='WTW.toggleQuickEditorSettings()'>".$this->__('Quick Editor Settings')."</div>";
				$zmenu .= "				<div class='wtw-quickcontainer switches-list'>\r\n";
				$zmenu .= "					<div class='switch'>";
				$zmenu .= "						<p> Avatar Camera </p>";
				$zmenu .= "						<div id='wtw_bavatarcamera' onclick='WTW.setQuickEditorAvatarCamera(0);' class='wtw-quickbar' title='Camera is Attached to Avatar' alt='Camera is Attached to Avatar'></div>\r\n";
				$zmenu .= "					</div>";
				$zmenu .= "					<div class='switch'>";
				$zmenu .= "						<p> Focus </p>";
				$zmenu .= "						<div id='wtw_bfocus' onclick='WTW.setQuickEditorFocus(0);' class='wtw-quickbar' title='Focus Highlight is On' alt='Focus Highlight is On'></div>\r\n";
				$zmenu .= "					</div>";
				$zmenu .= "					<div class='switch'>";
				$zmenu .= "						<p> Merged </p>";
				$zmenu .= "						<div id='wtw_bmerged' onclick='WTW.setQuickEditorMerged(1);' class='wtw-quickbaroff' title='Merged Shapes are Hidden' alt='Merged Shapes are Hidden'></div>";
				$zmenu .= "					</div>";
				$zmenu .= "					<div class='switch'>";
				$zmenu .= "						<p> Zones </p>";
				$zmenu .= "						<div id='wtw_bzones' onclick='WTW.setQuickEditorZones(1);' class='wtw-quickbaroff' title='Action Zones are Hidden' alt='Action Zones are Hidden'></div>";
				$zmenu .= "					</div>";
				$zmenu .= "					<div class='switch'>";
				$zmenu .= "						<p> Load All </p>";
				$zmenu .= "						<div id='wtw_bloadall' onclick='WTW.setQuickEditorLoadAll(1);' class='wtw-quickbaroff' title='Load Active Action Zones' alt='Load Active Action Zones'></div>";
				$zmenu .= "					</div>";
				$zmenu .= "					<div class='switch'>";
				$zmenu .= "						<p> Lines </p>";
				$zmenu .= "						<div id='wtw_blines' onclick='WTW.setQuickEditorLines(0);' class='wtw-quickbar' title='Alignment Lines are Shown' alt='Alignment Lines are Shown'></div>";
				$zmenu .= "					</div>";
				$zmenu .= "				</div>\r\n";
				$zmenu .= "			</div>\r\n";
			}
			$zmenu .= "		</div>\r\n";
			$zmenu .= "</div>\r\n";		
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-getAdminMenuLayout=".$e->getMessage());
		}
		return $zmenu;
	}
	
	public function getAdminSnapshotMenu() {
		/* get html for the admin snapshot menu */
		/* admin menu form for Updating a default snapshot of the 3D Item, this is used as the preview for when someone shares a link */
		global $wtwdb;
		$zmenu = '';
		try {
			$zmenu .= "<div id='wtw_adminmenu69b' class='wtw-hide' onclick='WTW.blockPassThrough();'>\r\n";
			$zmenu .= "		<img id='wtw_defaultsnapshot' class='wtw-snapshot' />\r\n";
			$zmenu .= "		\r\n";
			$zmenu .= "		<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "		<ul>\r\n";
			$zmenu .= "		<li class='wtw-grayleft'>Walk and position the view to your desired location and angle</li>\r\n";
			$zmenu .= "		<li class='wtw-grayleft'>Click the <strong>Set Default Snapshot</strong> button to update the picture.</li>\r\n";
			$zmenu .= "		</ul>\r\n";
			$zmenu .= "		<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "		<div id='wtw_bupdatesnapshot' class='wtw-greenbuttonbig' onclick='WTW.adminMenuItemSelected(this);'>Set Default Snapshot</div>\r\n";
			$zmenu .= "</div>\r\n";
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-getAdminSnapshotMenu=".$e->getMessage());
		}
		return $zmenu;
	}

	public function getAdminFirstBuildingMenu() {
		/* get html for the admin snapshot menu */
		/* admin menu form for editing the first 3D Building placement, which sets the position, scaling, and rotation for the first 3D Building in a 3D Community that gets added by automated processes and wizards */
		global $wtwdb;
		$zmenu = '';
		try {
			$zmenu .= "<div id='wtw_adminmenu28b' class='wtw-smallprintbackground wtw-hide' onclick='WTW.blockPassThrough();'>\r\n";
			$zmenu .= "     <div class='wtw-menulevel0text wtw-leftalign'>This option sets the position, scaling, and rotation for the <b>first 3D Building</b> that gets added to this 3D Community by automated processes and wizards (like your original Roomz install).</div>\r\n";
			$zmenu .= "		<div class='wtw-one-items'>";
			$zmenu .= "			<h2>3D Building Position</h2>";
			$zmenu .= "			<div class='wtw-onecol'>";
			$zmenu .= "				<input type='text' id='wtw_tfirstbuildpositionx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setFirstBuilding();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingxp4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildpositionx', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingxp3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildpositionx', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingxp2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildpositionx', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingxp1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildpositionx', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='wtw-onecol'>";
			$zmenu .= "				<input type='text' id='wtw_tfirstbuildpositiony' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setFirstBuilding();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingyp4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildpositiony', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingyp3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildpositiony', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingyp2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildpositiony', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingyp1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildpositiony', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='wtw-onecol wtw-nowrap'>";
			$zmenu .= "				<input type='text' id='wtw_tfirstbuildpositionz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setFirstBuilding();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingzp4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildpositionz', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingzp3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildpositionz', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingzp2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildpositionz', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingzp1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildpositionz', 1);\" onmouseup='WTW.changeStop();' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "		</div>";
			$zmenu .= "		<div class='wtw-one-items'>";
			$zmenu .= "			<h2>3D Building Scale <span>(Size)</span></h2>";
			$zmenu .= "			<div class='wtw-onecol'>";
			$zmenu .= "				<input type='text' id='wtw_tfirstbuildscalingx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setFirstBuilding();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingxl4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildscalingx', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingxl3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildscalingx', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingxl2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildscalingx', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingxl1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildscalingx', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-onecol'>";
			$zmenu .= "				<input type='text' id='wtw_tfirstbuildscalingy' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setFirstBuilding();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtwbfirstbuildingyl4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildscalingy', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingyl3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildscalingy', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingyl2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildscalingy', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingyl1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildscalingy', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-onecol'>";
			$zmenu .= "				<input type='text' id='wtw_tfirstbuildscalingz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setFirstBuilding();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingzl4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildscalingz', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingzl3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildscalingz', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingzl2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildscalingz', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingzl1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildscalingz', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "		</div>";
			$zmenu .= "		<div class='wtw-one-items'>";
			$zmenu .= "			<h2>3D Building Rotation</h2>";
			$zmenu .= "			<div class='wtw-onecol'>";
			$zmenu .= "				<input type='text' id='wtw_tfirstbuildrotationx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setFirstBuilding();\" />";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingxr4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildrotationx', -1);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingxr3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildrotationx', -.01);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingxr2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildrotationx', .01);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingxr1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildrotationx', 1);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='wtw-onecol'>";
			$zmenu .= "				<input type='text' id='wtw_tfirstbuildrotationy' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setFirstBuilding();\" />";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingyr4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildrotationy', -1);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingyr3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildrotationy', -.01);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingyr2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildrotationy', .01);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingyr1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildrotationy', 1);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='wtw-onecol'>";
			$zmenu .= "				<input type='text' id='wtw_tfirstbuildrotationz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setFirstBuilding();\" />";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingzr4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildrotationz', -1);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingzr3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildrotationz', -.01);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingzr2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildrotationz', .01);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_bfirstbuildingzr1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tfirstbuildrotationz', 1);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "		</div>";
			$zmenu .= "</div>";
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-getAdminFirstBuildingMenu=".$e->getMessage());
		}
		return $zmenu;
	}	

	public function getAdminConnectingGridMenu() {
		/* get html for the admin snapshot menu */
		/* admin menu form for editing a Connecting Grid, which sets the position, scaling, and rotation of 3D Communities, Buildings, and Things */
		global $wtwdb;
		$zmenu = '';
		try {
			$zmenu .= "<div id='wtw_adminmenu14b' class='wtw-smallprintbackground wtw-hide' onclick='WTW.blockPassThrough();'>\r\n";
			$zmenu .= "		<h2 id='wtw_buildingnametitle'></h2>\r\n";
			$zmenu .= "		<div class='wtw-one-items'>";
			$zmenu .= "			<h2 id='wtw_buildingpositiontitle'>Position</h2>";
			$zmenu .= "			<div class='wtw-onecol single-item'>";
			$zmenu .= "				<input type='text' id='wtw_tconngridpositionx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewConnectingGrid();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingxp4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridpositionx', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingxp3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridpositionx', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingxp2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridpositionx', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingxp1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridpositionx', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='wtw-onecol single-item'>";
			$zmenu .= "				<input type='text' id='wtw_tconngridpositiony' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewConnectingGrid();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingyp4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridpositiony', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingyp3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridpositiony', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingyp2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridpositiony', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingyp1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridpositiony', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-onecol wtw-nowrap single-item'>";
			$zmenu .= "				<input type='text' id='wtw_tconngridpositionz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewConnectingGrid();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingzp4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridpositionz', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingzp3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridpositionz', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingzp2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridpositionz', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingzp1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridpositionz', 1);\" onmouseup='WTW.changeStop();' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "		</div>";
			$zmenu .= "		<div class='wtw-one-items'>";
			$zmenu .= "			<h2 id='wtw_buildingscaletitle'>3D Building Scale (Size)</h2>";
			$zmenu .= "			<div class='wtw-onecol single-item'>";
			$zmenu .= "				<input type='text' id='wtw_tconngridscalingz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewConnectingGrid();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingzl4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridscalingz', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingzl3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridscalingz', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingzl2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridscalingz', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingzl1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridscalingz', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='wtw-onecol single-item'>";
			$zmenu .= "				<input type='text' id='wtw_tconngridscalingx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewConnectingGrid();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingxl4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridscalingx', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingxl3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridscalingx', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingxl2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridscalingx', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingxl1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridscalingx', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='wtw-onecol single-item'>";
			$zmenu .= "				<input type='text' id='wtw_tconngridscalingy' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewConnectingGrid();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingyl4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridscalingy', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingyl3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridscalingy', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingyl2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridscalingy', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingyl1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridscalingy', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "		</div>";
			$zmenu .= "		<div class='wtw-one-items'>";
			$zmenu .= "			<h2 id='wtw_buildingrotationtitle'>3D Building Rotation</h2>";
			$zmenu .= "			<div class='wtw-onecol single-item'>";
			$zmenu .= "				<input type='text' id='wtw_tconngridrotationx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewConnectingGrid();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingxr4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridrotationx', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingxr3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridrotationx', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingxr2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridrotationx', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingxr1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridrotationx', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='wtw-onecol single-item'>";
			$zmenu .= "				<input type='text' id='wtw_tconngridrotationy' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewConnectingGrid();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingyr4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridrotationy', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingyr3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridrotationy', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingyr2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridrotationy', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingyr1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridrotationy', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='wtw-onecol single-item'>";
			$zmenu .= "				<input type='text'id='wtw_tconngridrotationz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewConnectingGrid();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingzr4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridrotationz', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingzr3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridrotationz', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingzr2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tconngridrotationz', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditbuildingzr1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tconngridrotationz', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "		</div>";
			$zmenu .= "		<div id='wtw_cgadvancedoptslink' onclick=\"WTW.toggleAdvanced(this, 'wtw_cgadvancedopts');\" class='wtw-showhideadvanced'>Advanced Options</div>\r\n";
			$zmenu .= "		<div id='wtw_cgadvancedopts' class='wtw-advanced'>";
			$zmenu .= "			<div class='select-input-field'>\r\n";
			$zmenu .= "				<p class='wtw-marginbottom'>Shape Visibility Distance <span>(Load Zone)</span></p>\r\n";
			$zmenu .= "				<select id='wtw_taltloadactionzoneid' class='wtw-pointer'></select>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "			<div class='input-field'>";
			$zmenu .= "				<p>Alt Tag for 3D Web</p>\r\n";
			$zmenu .= "				<input type='text' id='wtw_tconngridalttag' maxlength='255' onclick=\"WTW.checkKey(this, 'displayname', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'displayname', 0, 0);\" onblur=\"WTW.checkKey(this, 'displayname', 0, 1);\" />\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_beditthisbuilding' class='wtw-greenbuttonbig' onclick='WTW.editBuilding();'>Open 3D Building in Editor</div>\r\n";
			$zmenu .= "</div>\r\n";
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-getAdminConnectingGridMenu=".$e->getMessage());
		}
		return $zmenu;
	}

	public function getAdminActionzoneMenu() {
		/* get html for the admin snapshot menu */
		/* admin menu form for editing action zones, which apply actions based on avatar position (basically in or out of an action zone) */
		global $wtwdb;
		$zmenu = '';
		try {
			$zmenu .= "<div id='wtw_adminmenu20b' class='wtw-smallprintbackground wtw-hide' onclick='WTW.blockPassThrough();'>\r\n";
			$zmenu .= "		<div class='wtw-onecol flex-vertical'>\r\n";
			$zmenu .= "			<select id='wtw_tactionzonetypelist'  class='wtw-pointer wtw-hide'></select>\r\n";
			$zmenu .= "			<h4>Action Zone Friendly Name</h4>\r\n";
			$zmenu .= "			<input type='text' id='wtw_tactionzonename' maxlength='255' class='wtw-secondcolcontent wtw-smallprintinput' style='width:250px;min-width:250px;' onclick=\"WTW.checkKey(this, 'displayname', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'displayname', 0, 0);\" onblur=\"WTW.checkKey(this, 'displayname', 0, 1);\" />\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_actionzoneswingdoordiv'>\r\n";
			$zmenu .= "			<div id='wtw_rotatedirectiondiv'>\r\n";
			$zmenu .= "				<h4>Swing Direction</h4>\r\n";
			$zmenu .= "				<div class='wtw-onecol flex-vertical'>\r\n";
			$zmenu .= "					<input type='button' id='wtw_bactionzonereverserotatedirection' class='wtw-smallprint' value='Reverse Swing Direction' onclick='WTW.reverserotatedirection();' />\r\n";
			$zmenu .= "					<select id='wtw_tactionzonerotatedirection' onchange='WTW.setNewActionZone();' class='wtw-smallprintinput' style='display:none;visibility:hidden;'>\r\n";
			$zmenu .= "						<option value='1'>clockwise</option>\r\n";
			$zmenu .= "						<option value='-1'>counter-clockwise</option>\r\n";
			$zmenu .= "					</select>\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-one-items two-arrows-only single'>";
			$zmenu .= "				<h2 id='wtw_swingdistancediv'>Swing Distance <span id='wtw_swingdistancedegreesdiv'>(Degrees)</span></h2>";
			$zmenu .= "				<div class='wtw-onecol'>\r\n";
			$zmenu .= "					<input type='text' id='wtw_tactionzonerotatedegrees' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_bazeditswing2' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonerotatedegrees', -1);\" onmouseup=\"WTW.changeStop();WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_bazeditswing1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonerotatedegrees', 1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_actionzonerotatespeeddiv'>";
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "				<h2>Rotation Speed</h2>";
			$zmenu .= "				<div class='wtw-onecol'>\r\n";
			$zmenu .= "					<input type='text' id='wtw_tactionzonerotatespeed' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_brotatespeed4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonerotatespeed', -1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_brotatespeed3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonerotatespeed', -.01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_brotatespeed2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonerotatespeed', .01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_brotatespeed1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonerotatespeed', 1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_actionzoneaxisdiv'>\r\n";
			$zmenu .= "			<div class='wtw-one-items'>";
			$zmenu .= "				<h2 id='wtw_axispositiontitle'>Axis Position</h2>";
			$zmenu .= "				<div id='wtw_axispositionx' class='wtw-onecol'>";
			$zmenu .= "					<input type='text' id='wtw_taxispositionx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisxp4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_taxispositionx', -1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisxp3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_taxispositionx', -.01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisxp2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_taxispositionx', .01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisxp1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_taxispositionx', 1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_axispositiony' class='wtw-onecol'>";
			$zmenu .= "					<input type='text' id='wtw_taxispositiony' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisyp4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_taxispositiony', -1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisyp3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_taxispositiony', -.01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisyp2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_taxispositiony', .01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisyp1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_taxispositiony', 1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_axispositionz' class='wtw-onecol' style='white-space:nowrap;'>";
			$zmenu .= "					<input type='text' id='wtw_taxispositionz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxiszp4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_taxispositionz', -1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxiszp3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_taxispositionz', -.01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxiszp2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_taxispositionz', .01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxiszp1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_taxispositionz', 1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='wtw-one-items'>";
			$zmenu .= "				<h2 id='wtw_axisrotationtitle'>Axis Rotation</h2>\r\n";
			$zmenu .= "				<div id='wtw_axisrotationx' class='wtw-onecol'>";
			$zmenu .= "					<input type='text' id='wtw_taxisrotationx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisxr4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_taxisrotationx', -1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisxr3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_taxisrotationx', -.01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisxr2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_taxisrotationx', .01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisxr1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_taxisrotationx', 1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_axisrotationy' class='wtw-onecol'>";
			$zmenu .= "					<input type='text' id='wtw_taxisrotationy' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisyr4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_taxisrotationy', -1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisyr3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_taxisrotationy', -.01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisyr2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_taxisrotationy', .01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxisyr1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_taxisrotationy', 1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_axisrotationz' class='wtw-onecol'>";
			$zmenu .= "					<input type='text' id='wtw_taxisrotationz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxiszr4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_taxisrotationz', -1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxiszr3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_taxisrotationz', -.01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxiszr2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_taxisrotationz', .01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxiszr1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_taxisrotationz', 1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_actionzonemovementdistancediv' style='display:none;visibility:hidden;'>\r\n";
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "				<h2>Slide Distance <span> (Length)</span></h2>\r\n";
			$zmenu .= "				<div id='wtw_axisscalingz' class='wtw-onecol' style='white-space:nowrap;'>\r\n";
			$zmenu .= "					<input type='text' id='wtw_taxisscalingz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxiszl4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_taxisscalingz', -1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxiszl3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_taxisscalingz', -.01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxiszl2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_taxisscalingz', .01);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditaxiszl1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_taxisscalingz', 1);\" onmouseup='WTW.changeStop();WTW.setNewActionZone();' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_actionzonepartsdiv'>\r\n";
			$zmenu .= "			<div id='wtw_actionzonepartsdivlabel'>\r\n";
			$zmenu .= "				<h2>Action Zone Parts(3D Shapes included)</h2>\r\n";
			$zmenu .= "				Click to Remove\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div id='wtw_attachactionzonediv'>\r\n";
			$zmenu .= "				<h2>Trigger for Seat</h2>\r\n";
			$zmenu .= "				<div class='wtw-menulevel0text'>(Pick 3D Shape that you will select to have your avatar sit)</div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div id='wtw_actionzonepartslist'></div>\r\n";
			$zmenu .= "			<div id='wtw_baddactionzonepart' class='wtw-menulevel0' onclick='WTW.selectAddActionZonePart(WTW.pick);'>Pick Shape to Add</div>\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_actionzoneteleportdiv'>\r\n";
			$zmenu .= "			<h4>Teleport Settings</h4>\r\n";
			$zmenu .= "			<div class='select-input-field'>\r\n";
			$zmenu .= "				<p >Teleport to 3D Community:</p>\r\n";
			$zmenu .= "				<select id='wtw_tazteleportzoneid' onchange='WTW.reloadAZSpawnList();' class='wtw-pointer'></select>\r\n";
			$zmenu .= "			</div>";	
			$zmenu .= "			<div class='select-input-field'>\r\n";
			$zmenu .= "				<p>Spawn Zone:</p>\r\n";
			$zmenu .= "				<select id='wtw_tazspawnzoneid' class='wtw-pointer'></select>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_actionzoneadvancedoptslink' onclick=\"WTW.toggleAdvanced(this, 'wtw_actionzoneadvancedopts');\" class='wtw-showhideadvanced'>Advanced Options</div>\r\n";
			$zmenu .= "		<div id='wtw_actionzoneadvancedopts' class='wtw-advanced'>";
			$zmenu .= "			<div id='wtw_copyaxletoactionzonediv'>\r\n";
			$zmenu .= "				<h4>Action Zone Information</h4>\r\n";
			$zmenu .= "				<div class='checkbox-input-field'>";
			$zmenu .= "					<input type='checkbox' id='wtw_tcopyaxletoactionzone' class='wtw-secondcolcontent wtw-smallprintinput' onchange='WTW.setActionZonePosition();' /><span> Use Axle Position for Action Zone</span>\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div id='wtw_actionzonesettingsdiv'>\r\n";
			$zmenu .= "				<div class='wtw-one-items'>";
			$zmenu .= "					<h2>Action Zone Position</h2>\r\n";
			$zmenu .= "					<div id='wtw_actionzoneposx' class='wtw-onecol'>\r\n";
			$zmenu .= "						<input type='text' id='wtw_tactionzoneposx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "						<div class='item-input-down'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzoneposxp4' class='wtw-smallprint' value='-1' onmousedown=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.changeNumberValue('wtw_tactionzoneposx', -1);\" onmouseup='WTW.changeStop();' onclick=\"dGet('wtw_tcopyaxletoactionzone').checked=false;\" />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-down1'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzoneposxp3' class='wtw-smallprint' value='-.01' onmousedown=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.changeNumberValue('wtw_tactionzoneposx', -.01);\" onmouseup='WTW.changeStop();' onclick=\"dGet('wtw_tcopyaxletoactionzone').checked=false;\" />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up1'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzoneposxp2' class='wtw-smallprint' value='+.01' onmousedown=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.changeNumberValue('wtw_tactionzoneposx', .01);\" onmouseup='WTW.changeStop();' onclick=\"dGet('wtw_tcopyaxletoactionzone').checked=false;\" />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzoneposxp1' class='wtw-smallprint' value='+1' onmousedown=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.changeNumberValue('wtw_tactionzoneposx', 1);\" onmouseup='WTW.changeStop();' onclick=\"dGet('wtw_tcopyaxletoactionzone').checked=false;\" />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "					<div id='wtw_actionzoneposy' class='wtw-onecol'>\r\n";
			$zmenu .= "						<input type='text' id='wtw_tactionzoneposy' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "						<div class='item-input-down'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzoneposyp4' class='wtw-smallprint' value='-1' onmousedown=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.changeNumberValue('wtw_tactionzoneposy', -1);\" onmouseup='WTW.changeStop();' onclick=\"dGet('wtw_tcopyaxletoactionzone').checked=false;\" />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-down1'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzoneposyp3' class='wtw-smallprint' value='-.01' onmousedown=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.changeNumberValue('wtw_tactionzoneposy', -.01);\" onmouseup='WTW.changeStop();' onclick=\"dGet('wtw_tcopyaxletoactionzone').checked=false;\" />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up1'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzoneposyp2' class='wtw-smallprint' value='+.01' onmousedown=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.changeNumberValue('wtw_tactionzoneposy', .01);\" onmouseup='WTW.changeStop();' onclick=\"dGet('wtw_tcopyaxletoactionzone').checked=false;\" />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzoneposyp1' class='wtw-smallprint' value='+1' onmousedown=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.changeNumberValue('wtw_tactionzoneposy', 1);\" onmouseup='WTW.changeStop();' onclick=\"dGet('wtw_tcopyaxletoactionzone').checked=false;\" />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "					<div id='wtw_actionzoneposz' class='wtw-onecol'>\r\n";
			$zmenu .= "						<input type='text' id='wtw_tactionzoneposz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "						<div class='item-input-down'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzoneposzp4' class='wtw-smallprint' value='-1' onmousedown=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.changeNumberValue('wtw_tactionzoneposz', -1);\" onmouseup='WTW.changeStop();' onclick=\"dGet('wtw_tcopyaxletoactionzone').checked=false;\" />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-down1'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzoneposzp3' class='wtw-smallprint' value='-.01' onmousedown=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.changeNumberValue('wtw_tactionzoneposz', -.01);\" onmouseup='WTW.changeStop();' onclick=\"dGet('wtw_tcopyaxletoactionzone').checked=false;\" />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up1'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzoneposzp2' class='wtw-smallprint' value='+.01' onmousedown=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.changeNumberValue('wtw_tactionzoneposz', .01);\" onmouseup='WTW.changeStop();' onclick=\"dGet('wtw_tcopyaxletoactionzone').checked=false;\" />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzoneposzp1' class='wtw-smallprint' value='+1' onmousedown=\"dGet('wtw_tcopyaxletoactionzone').checked=false;WTW.changeNumberValue('wtw_tactionzoneposz', 1);\" onmouseup='WTW.changeStop();' onclick=\"dGet('wtw_tcopyaxletoactionzone').checked=false;\" />\r\n";
			$zmenu .= "						</div>\r\n";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_actionzonesizediv'>\r\n";
			$zmenu .= "					<div class='wtw-one-items'>";
			$zmenu .= "						<h2>Action Zone Size</h2>\r\n";
			$zmenu .= "						<div id='wtw_actionzonescalingx' class='wtw-onecol'>\r\n";
			$zmenu .= "							<input type='text' id='wtw_tactionzonescalingx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "							<div class='item-input-down'>";
			$zmenu .= "								<input type='button' id='wtw_beditactionzonescalingxs4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonescalingx', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-down1'>";
			$zmenu .= "								<input type='button' id='wtw_beditactionzonescalingxs3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonescalingx', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up1'>";
			$zmenu .= "								<input type='button' id='wtw_beditactionzonescalingxs2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonescalingx', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up'>";
			$zmenu .= "								<input type='button' id='wtw_beditactionzonescalingxs1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonescalingx', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "						</div>\r\n";
			$zmenu .= "						<div id='wtw_actionzonescalingy' class='wtw-onecol'>\r\n";
			$zmenu .= "							<input type='text' id='wtw_tactionzonescalingy' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "							<div class='item-input-down'>";
			$zmenu .= "								<input type='button' id='wtw_beditactionzonescalingys4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonescalingy', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-down1'>";
			$zmenu .= "								<input type='button' id='wtw_beditactionzonescalingys3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonescalingy', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up1'>";
			$zmenu .= "								<input type='button' id='wtw_beditactionzonescalingys2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonescalingy', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up'>";
			$zmenu .= "								<input type='button' id='wtw_beditactionzonescalingys1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonescalingy', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "						</div>\r\n";
			$zmenu .= "						<div id='wtw_actionzonescalingz' class='wtw-onecol'>\r\n";
			$zmenu .= "							<input type='text' id='wtw_tactionzonescalingz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "							<div class='item-input-down'>";
			$zmenu .= "								<input type='button' id='wtw_beditactionzonescalingzs4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonescalingz', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-down1'>";
			$zmenu .= "								<input type='button' id='wtw_beditactionzonescalingzs3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonescalingz', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up1'>";
			$zmenu .= "								<input type='button' id='wtw_beditactionzonescalingzs2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonescalingz', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up'>";
			$zmenu .= "								<input type='button' id='wtw_beditactionzonescalingzs1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonescalingz', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "						</div>\r\n";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div class='wtw-one-items'>";
			$zmenu .= "					<h2>Action Zone Rotation</h2>\r\n";
			$zmenu .= "					<div id='wtw_actionzonerotx' class='wtw-onecol'>\r\n";
			$zmenu .= "						<input type='text' id='wtw_tactionzonerotx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "						<div class='item-input-down'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzonerotxr4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonerotx', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-down1'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzonerotxr3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonerotx', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up1'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzonerotxr2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonerotx', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzonerotxr1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonerotx', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "					<div id='wtw_actionzoneroty' class='wtw-onecol'>\r\n";
			$zmenu .= "						<input type='text' id='wtw_tactionzoneroty' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "						<div class='item-input-down'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzonerotyr4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzoneroty', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-down1'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzonerotyr3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tactionzoneroty', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up1'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzonerotyr2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tactionzoneroty', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzonerotyr1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzoneroty', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "					<div id='wtw_actionzonerotz' class='wtw-onecol'>\r\n";
			$zmenu .= "						<input type='text' id='wtw_tactionzonerotz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewActionZone();\" />\r\n";
			$zmenu .= "						<div class='item-input-down'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzonerotzr4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonerotz', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-down1'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzonerotzr3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonerotz', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up1'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzonerotzr2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonerotz', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up'>";
			$zmenu .= "							<input type='button' id='wtw_beditactionzonerotzr1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tactionzonerotz', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div id='wtw_actionzoneavataranimationsdiv'>\r\n";
			$zmenu .= "				<h4>Load Avatar Animations</h4>\r\n";
			$zmenu .= "				<div id='wtw_azavataranimations'></div>\r\n";
			$zmenu .= "				<div class='select-input-field'>\r\n";
			$zmenu .= "					<p>Select to Add:</p>\r\n";
			$zmenu .= "					<select id='wtw_tazavataranimationid' class='wtw-pointer'></select>\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='wtw-yellowbutton' onclick='WTW.saveAZAvatarAnimation();'>Add Animation</div>\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_azvisibilitydistancediv'>\r\n";
			$zmenu .= "			<div class='select-input-field'>\r\n";
			$zmenu .= "				<p>Action Zone Load Distance</p>\r\n";
			$zmenu .= "				<select id='wtw_tazloadactionzoneid' class='wtw-pointer'></select>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_azjavascriptdiv'>\r\n";
			$zmenu .= "			<h4>Load JavaScript in Zone</h4>\r\n";
			$zmenu .= "			<div id='wtw_azjavascriptlinks' ></div>\r\n";
			$zmenu .= "			<div id='wtw_azjavascript' class='wtw-menulevel0' onclick='WTW.startUploadImage(this.innerHTML);return (false);'>Upload JavaScript File</div>\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "</div>\r\n";
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-getAdminActionzoneMenu=".$e->getMessage());
		}
		return $zmenu;
	}

	public function getAdminMoldMenu() {
		/* get html for the admin snapshot menu */
		/* admin menu form for editing molds (meshes and all associated information for when to load/unload them) */
		global $wtwdb;
		$zmenu = '';
		try {
			$zmenu .= "<div id='wtw_adminmenu11b' class='wtw-smallprintbackground wtw-hide' onclick='WTW.blockPassThrough();'>\r\n";
			$zmenu .= "		<div id='wtw_objectdiv'>\r\n";
			$zmenu .= "			<h2 class='wtw-marginbottom'>3D Model</h2>\r\n";
			$zmenu .= "			<div class='input-field'>\r\n";
			$zmenu .= "				<p>3D Model File</p>\r\n";
			$zmenu .= "				<input type='text' id='wtw_tmoldobjectfile' maxlength='255' class='wtw-smallprintinput' />\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-rightbutton' onclick=\"WTW.openFullPageForm('medialibrary','object','3dobject');\">Select 3D Model</div>\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<h2 class='wtw-marginbottom'>Properties</h2>\r\n";
			$zmenu .= "		<div class='wtw-one-items'>";
			$zmenu .= "			<h2 id='wtw_moldpositiontitle'>Position</h2>";
			$zmenu .= "			<div class='wtw-onecol single-item'>";
			$zmenu .= "				<input type='text' id='wtw_tmoldpositionx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldxp4' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldpositionx', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldxp3' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldpositionx', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldxp2' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldpositionx', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldxp1' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldpositionx', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-onecol single-item'>";
			$zmenu .= "				<input type='text' id='wtw_tmoldpositiony' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldyp4' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldpositiony', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldyp2' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldpositiony', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldyp3' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldpositiony', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldyp1' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldpositiony', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-onecol wtw-nowrap single-item'>";
			$zmenu .= "				<input type='text' id='wtw_tmoldpositionz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldzp4' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldpositionz', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldzp3' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldpositionz', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldzp2' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldpositionz', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldzp1' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldpositionz', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "		</div>";
			$zmenu .= "		<div class='wtw-one-items'>";
			$zmenu .= "			<h2 id='wtw_moldscalingtitle' class='wtw-marginbottom'>Mold Size</h2>\r\n";		
			$zmenu .= "			<div class='wtw-onecol'>";
			$zmenu .= "				<input type='text' id='wtw_tmoldscalingx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldxl4' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldscalingx', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldxl3' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldscalingx', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldxl2' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldscalingx', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldxl1' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldscalingx', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div id='wtw_moldscalingydiv' class='wtw-onecol' style='display:inline-block;'>\r\n";
			$zmenu .= "				<input type='text' id='wtw_tmoldscalingy' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldyl4' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldscalingy', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldyl3' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldscalingy', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldyl2' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldscalingy', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldyl1' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldscalingy', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-onecol'>";
			$zmenu .= "				<input type='text' id='wtw_tmoldscalingz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldzl4' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldscalingz', -1);\" onmouseup='WTW.changeStop();'  />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldzl3' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldscalingz', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldzl2' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldscalingz', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldzl1' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldscalingz', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "		</div>";
			$zmenu .= "		<div id='wtw_terrainheightdiv'>";
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "				<h2>Terrain Height</h2>";
			$zmenu .= "				<div class='wtw-onecol'>";
			$zmenu .= "					<input type='text' id='wtw_tmoldmaxheight' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_bterrainheight4' class='wtw-smallprint' value='-10' onmousedown=\"WTW.changeNumberValue('wtw_tmoldmaxheight', -10);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_bterrainheight3' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldmaxheight', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_bterrainheight2' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldmaxheight', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_bterrainheight1' class='wtw-smallprint' value='+10' onmousedown=\"WTW.changeNumberValue('wtw_tmoldmaxheight', 10);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "		</div>";
			$zmenu .= "		<div id='wtw_moldspecial1'>\r\n";
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "				<h2 id='wtw_moldspecial1title'>Special 1</h2>";
			$zmenu .= "				<div class='wtw-onecol'>";
			$zmenu .= "					<input type='text' id='wtw_tmoldspecial1' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditspecial14' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldspecial1', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditspecial13' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldspecial1', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditspecial12' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldspecial1', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditspecial11' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldspecial1', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_moldspecial2'>\r\n";
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "				<h2 id='wtw_moldspecial2title'>Special 2</h2>";
			$zmenu .= "				<div class='wtw-onecol'>";
			$zmenu .= "					<input type='text' id='wtw_tmoldspecial2' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditspecial24' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldspecial2', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditspecial23' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldspecial2', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "						<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditspecial22' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldspecial2', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditspecial21' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldspecial2', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div class='wtw-one-items'>";
			$zmenu .= "			<h2 id='wtw_moldrotationtitle' class='wtw-marginbottom'>Mold Rotation</h2>\r\n";
			$zmenu .= "			<div class='wtw-onecol single-item'>";
			$zmenu .= "				<input type='text' id='wtw_tmoldrotationx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldxr4' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldrotationx', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldxr3' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldrotationx', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldxr2' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldrotationx', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldxr1' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldrotationx', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-onecol single-item'>";
			$zmenu .= "				<input type='text' id='wtw_tmoldrotationy' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldyr4' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldrotationy', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldyr3' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldrotationy', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldyr2' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldrotationy', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldyr1' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldrotationy', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-onecol single-item'>";
			$zmenu .= "				<input type='text' id='wtw_tmoldrotationz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldzr4' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldrotationz', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldzr3' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldrotationz', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldzr2' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldrotationz', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_beditmoldzr1' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldrotationz', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "		</div>";
			$zmenu .= "		<hr class='wtw-menuhr' />";
			$zmenu .= 			$this->getAdminMenuDivs('editmold');
			$zmenu .= "		<div id='wtw_moldwebtextdiv'>\r\n";
			$zmenu .= "			<h2 class='wtw-marginbottom'>3D Text</h2>\r\n";
			$zmenu .= "		<div class='input-field'>";
			$zmenu .= "			<p>3D Text Lettering</p>";
			$zmenu .= "			<input type='text' id='wtw_tmoldwebtext' class='wtw-smallprintinput' style='width:90%;max-width:240px;' onblur='WTW.setNewMold();' />\r\n";
			$zmenu .= "		</div>";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_moldwebtextcolordiv'>\r\n";
			$zmenu .= "			<div class='select-input-field'>\r\n";
			$zmenu .= "				<p class='wtw-marginbottom'>Alignment</p>\r\n";
			$zmenu .= "				<select id='wtw_tmoldwebtextalign' onchange='WTW.setNewMold();' class='wtw-pointer'>\r\n";
			$zmenu .= "					<option value='center'>Center</option>\r\n";
			$zmenu .= "					<option value='left'>Left</option>\r\n";
			$zmenu .= "					<option value='right'>Right</option>\r\n";
			$zmenu .= "				</select>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "				<h2>Letter Height</h2>";
			$zmenu .= "				<div class='wtw-onecol'>";
			$zmenu .= "					<input type='text' id='wtw_tmoldwebtextheight' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditmoldlh4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldwebtextheight', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditmoldlh3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldwebtextheight', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditmoldlh2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldwebtextheight', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditmoldlh1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldwebtextheight', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";			
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "				<h2>Letter Thickness</h2>";
			$zmenu .= "				<div class='wtw-onecol'>";
			$zmenu .= "					<input type='text' id='wtw_tmoldwebtextthick' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditmoldlt4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldwebtextthick', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditmoldlt3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldwebtextthick', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditmoldlt2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldwebtextthick', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditmoldlt1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldwebtextthick', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='input-field'>";
			$zmenu .= "				<p class='wtw-marginbottom'>Letter Color <span> (emissive)</span></p>\r\n";
			$zmenu .= "				<input type='text' placeholder='#ff0000' id='wtw_tmoldwebtextemissive' maxlength='7' class='wtw-smallprintinput'  onfocus=\"WTW.openColorSelector(this, 'Emissive Color (Projected)', 'emissive');\" onblur='WTW.closeColorSelector(false);WTW.setNewMold(1);' onchange='WTW.setColorDirect(this);WTW.setNewMold(1);' onkeyup='WTW.setColorDirect(this);WTW.setNewMold(1);' />\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='input-field'>";
			$zmenu .= "				<p class='wtw-marginbottom'>Base Color <span>(diffuse)</span></p>\r\n";
			$zmenu .= "				<input type='text' placeholder='#f0f0f0' id='wtw_tmoldwebtextdiffuse' maxlength='7' class='wtw-smallprintinput' onfocus=\"WTW.openColorSelector(this, 'Diffuse Color (Base)', 'diffuse');\" onblur='WTW.closeColorSelector(false);WTW.setNewMold(1);' onchange='WTW.setColorDirect(this);WTW.setNewMold(1);'  onkeyup='WTW.setColorDirect(this);WTW.setNewMold(1);' />\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='input-field'>";
			$zmenu .= "				<p class='wtw-marginbottom'>Highlight Color <span>(specular)</span></p>\r\n";
			$zmenu .= "				<input type='text' placeholder='#000000' id='wtw_tmoldwebtextspecular' maxlength='7' class='wtw-smallprintinput' onfocus=\"WTW.openColorSelector(this, 'Specular Color (Highlight)', 'specular');\" onblur='WTW.closeColorSelector(false);WTW.setNewMold(1);' onchange='WTW.setColorDirect(this);WTW.setNewMold(1);' onkeyup='WTW.setColorDirect(this);WTW.setNewMold(1);' />\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='input-field'>";
			$zmenu .= "				<p class='wtw-marginbottom'>Environment Color <span>(ambient)</span></p>\r\n";
			$zmenu .= "				<input type='text' placeholder='#808080' id='wtw_tmoldwebtextambient' maxlength='7' class='wtw-smallprintinput' onfocus=\"WTW.openColorSelector(this, 'Ambient Color (Environment)', 'ambient');\" onblur='WTW.closeColorSelector(false);WTW.setNewMold(1);' onchange='WTW.setColorDirect(this);WTW.setNewMold(1);' onkeyup='WTW.setColorDirect(this);WTW.setNewMold(1);' />\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_moldaddimagediv'>\r\n";
			$zmenu .= "			<div class='img-text-field wtw-menulevel0text'>";
			$zmenu .= "				<h4>Image</h4>\r\n";
			$zmenu .= "				<img id='wtw_moldaddimagepreview' class='wtw-previewimage' />\r\n";
			$zmenu .= "				<div onclick=\"WTW.openFullPageForm('medialibrary','image','webimage','wtw_tmoldaddimageid','wtw_tmoldaddimagepath','wtw_moldaddimagepreview');\">Change Image</div>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='img-text-field wtw-menulevel0text'>";
			$zmenu .= "				<h4>Hover Image</h4>\r\n";
			$zmenu .= "				<img id='wtw_moldaddimagehoverpreview' class='wtw-previewimage' />\r\n";
			$zmenu .= "				<div onclick=\"WTW.openFullPageForm('medialibrary','image','webimagehover','wtw_tmoldaddimagehoverid','wtw_tmoldaddimagehoverpath','wtw_moldaddimagehoverpreview');\">Change Hover Image</div>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='select-input-field'>\r\n";
			$zmenu .= "				<p class='wtw-marginbottom'>Add Click Event<span>(optional)</span></p>\r\n";
			$zmenu .= "				<select id='wtw_tmoldaddonclick' onchange='WTW.changeOnClickEvent(this);' class='wtw-pointer'>\r\n";
			$zmenu .= "					<option value=''>None</option>\r\n";
			$zmenu .= "					<option value='WTW.openIFrame'>Open IFrame</option>\r\n";
			$zmenu .= "					<option value='WTW.openWebpage'>Open Webpage</option>\r\n";
			$zmenu .= "					<option value='javascript'>Execute JavaScript</option>\r\n";
			$zmenu .= "				</select>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div id='wtw_onclickjavascriptdiv'>\r\n";
			$zmenu .= "				<div class='input-field'>";
			$zmenu .= "					<p class='wtw-marginbottom'>OnClick JavaScript <span>(optional)</span></p>";
			$zmenu .= "					<input type='text' id='wtw_tmoldimagejsfunction' maxlength='255' style='width:300px;' class='wtw-smallprintinput' />\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div class='input-field'>";
			$zmenu .= "					<p id='wtw_moldjsparameterstitle' class='wtw-marginbottom'>JavaScript Parameters <span>(optional; comma separated)</span></p>";
			$zmenu .= "					<input type='text' id='wtw_tmoldimagejsparameters' maxlength='255' style='width:300px;' class='wtw-smallprintinput' />\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_moldaddvideodiv'>\r\n";
			$zmenu .= "			<h2 class='wtw-marginbottom'>Video Settings</h2>\r\n";
			$zmenu .= "			<div class='img-text-field wtw-menulevel0text'>";
			$zmenu .= "				<h4 class='wtw-marginbottom'>Video File (max 100MB)</h4>\r\n";
			$zmenu .= "				<img id='wtw_moldaddvideopreview' class='wtw-previewimage' width='190' src='/content/system/images/videoicon.png' />\r\n";
			$zmenu .= "				<div class='wtw-menulevel0' onclick=\"WTW.openFullPageForm('medialibrary','video','webvideo','wtw_tmoldvideoid','wtw_tmoldvideopath','wtw_moldaddvideopreview');\">Change Video</div>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='img-text-field wtw-menulevel0text'>";			
			$zmenu .= "				<h4 class='wtw-marginbottom'>Video Poster Image</h4>\r\n";
			$zmenu .= "				<img id='wtw_moldaddvideoposterpreview' class='wtw-previewimage' src='/content/system/images/videoposter.jpg' />\r\n";
			$zmenu .= "				<div id='wtw_changevideoposter' class='wtw-menulevel0' onclick='WTW.adminMenuItemSelected(this);'>Change Poster</div>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div id='wtw_removevideoposter' class='wtw-redbutton' onclick='WTW.adminMenuItemSelected(this);'>Remove Poster</div>\r\n";
			$zmenu .= "			<div class='checkbox-input-field'>";
			$zmenu .= "				<input type='checkbox' id='wtw_tmoldvideoloop' class='wtw-smallprint' value='1' onchange=\"dGet('wtw_tmoldsoundloop').checked=dGet('wtw_tmoldvideoloop').checked;WTW.setNewMold(1);\" /><span> Loop Video (repeat)</span>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "				<h2>Max Sound Distance Linear <span>(100-Default)</span></h2>";
			$zmenu .= "				<div class='wtw-onecol'>";
			$zmenu .= "					<input type='text' id='wtw_tmoldvideomaxdistance' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);dGet('wtw_tmoldsoundmaxdistance').value=dGet('wtw_tmoldvideomaxdistance').value;WTW.setNewMold(1);\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditmoldsvideodist4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldvideomaxdistance', -1, 1);\" onmouseup=\"WTW.changeStop();dGet('wtw_tmoldsoundmaxdistance').value=dGet('wtw_tmoldvideomaxdistance').value;WTW.setNewMold(1);\" />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditmoldsvideodist3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldvideomaxdistance', -.01, 1);\" onmouseup=\"WTW.changeStop();dGet('wtw_tmoldsoundmaxdistance').value=dGet('wtw_tmoldvideomaxdistance').value;WTW.setNewMold(1);\" />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditmoldsvideodist2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldvideomaxdistance', .01, 1);\" onmouseup=\"WTW.changeStop();dGet('wtw_tmoldsoundmaxdistance').value=dGet('wtw_tmoldvideomaxdistance').value;WTW.setNewMold(1);\" />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditmoldsvideodist1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldvideomaxdistance', 1, 1);\" onmouseup=\"WTW.changeStop();dGet('wtw_tmoldsoundmaxdistance').value=dGet('wtw_tmoldvideomaxdistance').value;WTW.setNewMold(1);\" />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_moldbasictexturesetdiv'>\r\n";
			$zmenu .= "			<div class='select-input-field'>";
			$zmenu .= "				<p class='wtw-marginbottom'>Covering Type";
			$zmenu .= "					<a href='https://www.Roomz.com/wiki/coverings-or-textures/' title='Help' alt='Help' class='wtw-helplink' target='_blank'>?</a></h2>\r\n";
			$zmenu .= "				</p>\r\n";
			$zmenu .= "				<select id='wtw_tmoldcovering' onchange='WTW.changeCoveringType();' class='wtw-pointer'>\r\n";
			$zmenu .= "				</select>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_moldcolorsdiv' class='mold-colors-list'>\r\n";
			$zmenu .= "			<div class='input-field'>";
			$zmenu .= "				<p class='wtw-marginbottom'>Mold Emissive Color <span>(Projected)</span></p>";
			$zmenu .= "				<input type='text' placeholder='#000000' id='wtw_tmoldemissivecolor' maxlength='7' class='wtw-smallprintinput' onfocus=\"WTW.openColorSelector(this, 'Emissive Color (Projected)', 'emissive');\" onblur='WTW.closeColorSelector(false);WTW.setNewMold();' onchange='WTW.setColorDirect(this);' onkeyup='WTW.setColorDirect(this);' />";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='input-field'>";
			$zmenu .= "				<p class='wtw-marginbottom'>Mold Diffuse Color <span>(Base)</span></p>";
			$zmenu .= "				<input type='text' placeholder='#ffffff' id='wtw_tmolddiffusecolor' maxlength='7' class='wtw-smallprintinput' onfocus=\"WTW.openColorSelector(this, 'Diffuse Color (Base)', 'diffuse');\" onblur='WTW.closeColorSelector(false);WTW.setNewMold();' onchange='WTW.setColorDirect(this);' onkeyup='WTW.setColorDirect(this);' />";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='input-field'>";
			$zmenu .= "				<p class='wtw-marginbottom'>Mold Specular Color <span>(Highlight)</span></p>";
			$zmenu .= "				<input type='text' placeholder='#686868' id='wtw_tmoldspecularcolor' maxlength='7' class='wtw-smallprintinput' onfocus=\"WTW.openColorSelector(this, 'Specular Color (Highlight)', 'specular');\" onblur='WTW.closeColorSelector(false);WTW.setNewMold();' onchange='WTW.setColorDirect(this);' onkeyup='WTW.setColorDirect(this);' />";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='input-field'>";
			$zmenu .= "				<p class='wtw-marginbottom'>Mold Ambient Color <span>(Environment)</span></p>";
			$zmenu .= "				<input type='text' placeholder='#575757' id='wtw_tmoldambientcolor' maxlength='7' class='wtw-smallprintinput' onfocus=\"WTW.openColorSelector(this, 'Ambient Color (Environment)', 'ambient');\" onblur='WTW.closeColorSelector(false);WTW.setNewMold();' onchange='WTW.setColorDirect(this);' onkeyup='WTW.setColorDirect(this);' />";
			$zmenu .= "			</div>";
			$zmenu .= "			<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_moldbasictextureset2div'>\r\n";
			$zmenu .= "			<div class='img-text-field wtw-menulevel0text'>";
			$zmenu .= "				<h4 id='wtw_moldtexturetitle'>Mold Texture Image</h4>\r\n";
			$zmenu .= "				<img id='wtw_moldtexturepreview' class='wtw-previewimage' src='' />\r\n";
			$zmenu .= "				<div id='wtw_moldchangetexture' class='wtw-menulevel0' onclick='WTW.adminMenuItemSelected(this);'>Change Texture</div>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_moldbumptextureset2div'>\r\n";
			$zmenu .= "			<div class='img-text-field wtw-menulevel0text'>";
			$zmenu .= "				<h4 id='wtw_moldbumptexturetitle'>Mold Bump Image</h4>\r\n";
			$zmenu .= "				<img id='wtw_moldtexturebumppreview' class='wtw-previewimage' src='' />\r\n";
			$zmenu .= "				<div id='wtw_moldchangebumptexture' class='wtw-menulevel0' onclick='WTW.adminMenuItemSelected(this);'>Change Bump Texture</div>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='wtw-menulevel0' onclick=\"dGet('wtw_tmoldtexturebumpid').value='';dGet('wtw_tmoldtexturebumppath').value='';WTW.setNewMold(1);dGet('wtw_moldtexturebumppreview').src='';\">Clear Bump Texture</div>\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_moldheightmapdiv'>\r\n";
			$zmenu .= "			<div class='img-text-field wtw-menulevel0text'>";
			$zmenu .= "				<h4>Terrain Heightmap Image</h4>\r\n";
			$zmenu .= "				<img id='wtw_moldheightmappreview' class='wtw-previewimage' src='' />\r\n";
			$zmenu .= "				<div id='wtw_moldchangeheightmap' class='wtw-menulevel0' onclick='WTW.adminMenuItemSelected(this);'>Change Heightmap</div>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div id='wtw_moldtextureadvancedoptslink' onclick=\"WTW.toggleAdvanced(this, 'wtw_moldtextureadvancedopts');\" class='wtw-showhideadvanced'>Show Advanced Mixmap Terrain</div>\r\n";
			$zmenu .= "			<div id='wtw_moldtextureadvancedopts' class='wtw-advanced'>";
			$zmenu .= "				<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "				<div class='wtw-mainmenuvalue'><strong>Advanced Mixmap Terrain</strong> only applies after all required images are set.</div>\r\n";
			$zmenu .= "				<div class='img-text-field wtw-menulevel0text'>";
			$zmenu .= "					<h4>Terrain Mixmap Image</h4>\r\n";
			$zmenu .= "					<p>Intensity of each texture according the channels red, green, and blue. (required)</p>\r\n";
			$zmenu .= "					<img id='wtw_moldmixmappreview' class='wtw-previewimage' src='' />\r\n";
			$zmenu .= "					<div id='wtw_changemixmap' class='wtw-menulevel0' onclick='WTW.adminMenuItemSelected(this);'>Change Mixmap</div>\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='img-text-field wtw-menulevel0text'>";
			$zmenu .= "					<h4>Red Texture Image</h4>\r\n";
			$zmenu .= "					<p>Texture that will apply to the Red channel of the Mixmap. (required)</p>\r\n";
			$zmenu .= "					<img id='wtw_moldtexturerpreview' class='wtw-previewimage' src='' />\r\n";
			$zmenu .= "					<div id='wtw_changeredtexture' class='wtw-menulevel0' onclick='WTW.adminMenuItemSelected(this);'>Change Red Texture</div>\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='img-text-field wtw-menulevel0text'>";
			$zmenu .= "					<h4>Green Texture Image</h4>\r\n";
			$zmenu .= "					<p>Texture that will apply to the Green channel of the Mixmap. (required)</p>\r\n";
			$zmenu .= "					<img id='wtw_moldtexturegpreview' class='wtw-previewimage' src='' />\r\n";
			$zmenu .= "					<div id='wtw_changegreentexture' class='wtw-menulevel0' onclick='WTW.adminMenuItemSelected(this);'>Change Green Texture</div>\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='img-text-field wtw-menulevel0text'>";
			$zmenu .= "					<h4>Blue Texture Image</h4>\r\n";
			$zmenu .= "					<p>Texture that will apply to the Blue channel of the Mixmap. (required)</p>\r\n";
			$zmenu .= "					<img id='wtw_moldtexturebpreview' class='wtw-previewimage' src='' />\r\n";
			$zmenu .= "					<div id='wtw_changebluetexture' class='wtw-menulevel0' onclick='WTW.adminMenuItemSelected(this);'>Change Blue Texture</div>\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='img-text-field wtw-menulevel0text'>";
			$zmenu .= "					<h4>Red Texture Bump Image</h4>\r\n";
			$zmenu .= "					<p>Bump map texture that will apply to the Red texture. (optional)</p>\r\n";
			$zmenu .= "					<img id='wtw_moldtexturebumprpreview' class='wtw-previewimage' src='' />\r\n";
			$zmenu .= "					<div id='wtw_changeredbumptexture' class='wtw-menulevel0' onclick='WTW.adminMenuItemSelected(this);'>Change Red Bump Map</div>\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='img-text-field wtw-menulevel0text'>";
			$zmenu .= "					<h4>Green Texture Bump Image</h4>\r\n";
			$zmenu .= "					<p>Bump map texture that will apply to the Green texture. (optional)</p>\r\n";
			$zmenu .= "					<img id='wtw_moldtexturebumpgpreview' class='wtw-previewimage' src='' />\r\n";
			$zmenu .= "					<div id='wtw_changegreenbumptexture' class='wtw-menulevel0' onclick='WTW.adminMenuItemSelected(this);'>Change Green Bump Map</div>\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='img-text-field wtw-menulevel0text'>";
			$zmenu .= "					<h4>Blue Texture Bump Image</h4>\r\n";
			$zmenu .= "					<p>Bump map texture that will apply to the Blue texture. (optional)</p>\r\n";
			$zmenu .= "					<img id='wtw_moldtexturebumpbpreview' class='wtw-previewimage' src='' />\r\n";
			$zmenu .= "					<div id='wtw_changebluebumptexture' class='wtw-menulevel0' onclick='WTW.adminMenuItemSelected(this);'>Change Blue Bump Map</div>\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_pointlistdiv' class='wtw-leftalign'>\r\n";
			$zmenu .= "			<div id='wtw_pointeditdiv' class='wtw-diff-bg'>\r\n";
			$zmenu .= "				<div class='cross-close-btn' onclick='WTW.editEndPoint();'>x</div>\r\n";
			$zmenu .= "				<div class='wtw-one-items'>";
			$zmenu .= "					<h2 class='wtw-marginbottom'>Point Position</h2>";
			$zmenu .= "					<div class='wtw-onecol'>";
			$zmenu .= "						<input type='text' id='wtw_tpointpositionx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />";
			$zmenu .= "						<div class='item-input-down'>";
			$zmenu .= "							<input type='button' id='wtw_beditpointxp4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tpointpositionx', -1);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-down1'>";
			$zmenu .= "							<input type='button' id='wtw_beditpointxp3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tpointpositionx', -.01);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up1'>";
			$zmenu .= "							<input type='button' id='wtw_beditpointxp2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tpointpositionx', .01);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up'>";
			$zmenu .= "							<input type='button' id='wtw_beditpointxp1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tpointpositionx', 1);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "						</div>";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='wtw-onecol'>";
			$zmenu .= "						<input type='text' id='wtw_tpointpositiony' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />";
			$zmenu .= "						<div class='item-input-down'>";
			$zmenu .= "							<input type='button' id='wtw_beditpointyp4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tpointpositiony', -1);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-down1'>";
			$zmenu .= "							<input type='button' id='wtw_beditpointyp3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tpointpositiony', -.01);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up1'>";
			$zmenu .= "							<input type='button' id='wtw_beditpointyp2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tpointpositiony', .01);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up'>";
			$zmenu .= "							<input type='button' id='wtw_beditpointyp1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tpointpositiony', 1);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "						</div>";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='wtw-onecol'>";
			$zmenu .= "						<input type='text' id='wtw_tpointpositionz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold();\" />";
			$zmenu .= "						<div class='item-input-down'>";
			$zmenu .= "							<input type='button' id='wtw_beditpointzp4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tpointpositionz', -1);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-down1'>";
			$zmenu .= "							<input type='button' id='wtw_beditpointzp3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tpointpositionz', -.01);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up1'>";
			$zmenu .= "							<input type='button' id='wtw_beditpointzp2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tpointpositionz', .01);\" onmouseup='WTW.changeStop();' />";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up'>";
			$zmenu .= "							<input type='button' id='wtw_beditpointzp1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tpointpositionz', 1);\" onmouseup='WTW.changeStop();' />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$zmenu .= "						</div>";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='two-btns'>";
			$zmenu .= "					<div class='wtw-redbutton' onmousedown='WTW.deletePoint();WTW.editEndPoint();' >Delete Point</div>";
			$zmenu .= "					<div class='wtw-yellowbutton' onmousedown='WTW.editEndPoint();' >Close</div>";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div id='wtw_pointlist1'></div>\r\n";
			$zmenu .= "			<div id='wtw_pointlist2'></div>\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div id='wtw_moldadvancedoptslink' onclick=\"WTW.toggleAdvanced(this, 'wtw_moldadvancedopts');\" class='wtw-showhideadvanced'> Advanced Options</div>\r\n";
			$zmenu .= "		<div id='wtw_moldadvancedopts' class='wtw-advanced'>";
			$zmenu .= "			\r\n";
			$zmenu .= "			<div id='wtw_visibilitydistancediv'>\r\n";
			$zmenu .= "				<div class='select-input-field'>\r\n";
			$zmenu .= "					<p>Shape Visibility Distance</p>\r\n";
			$zmenu .= "					<select id='wtw_tmoldloadactionzoneid' class='wtw-pointer'></select>\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div id='wtw_unloadzonediv'>\r\n";
			$zmenu .= "				<div class='select-input-field'>\r\n";
			$zmenu .= "					<p class='wtw-marginbottom'>Exclusion Zone</p>\r\n";
			$zmenu .= "					<select id='wtw_tmoldunloadactionzoneid' class='wtw-pointer'></select>\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div id='wtw_moldshadowreflectiondiv' style='text-align:left;'>\r\n";
			$zmenu .= "				<div class='checkbox-input-field'>";
			$zmenu .= "					<input type='checkbox' id='wtw_tmoldreceiveshadows' value='1' onchange='WTW.setNewMold(1);' /><span > Allow Shadows on Surface</span>\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='checkbox-input-field'>";
			$zmenu .= "					<input type='checkbox' id='wtw_tmoldwaterreflection' value='1' onchange='WTW.setNewMold(1);' /><span > Select to Reflect on Water</span>\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='checkbox-input-field'>";
			$zmenu .= "					<input type='checkbox' id='wtw_tmoldcheckcollisions' value='1' onchange='WTW.setNewMold(1);' /><span > Select to Check Collisions</span>\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='checkbox-input-field'>";
			$zmenu .= "					<input type='checkbox' id='wtw_tmoldispickable' value='1' onchange='WTW.setNewMold(1);' /><span > Select to be Pickable in Browse Mode (Always on for Admin Mode)</span>\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div id='wtw_moldtexturesetdiv'>\r\n";
			$zmenu .= "				<div class='checkbox-input-field'>";
			$zmenu .= "					<input type='checkbox' id='wtw_tmoldgraphiclevel' class='wtw-smallprint' value='1' onchange='WTW.setNewMold(1);' /><span> Force Original Graphic</span>\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div id='wtw_alttagdiv'>\r\n";
			$zmenu .= "					<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "					<div class='input-field'>";
			$zmenu .= "						<p>Alt Tag for 3D Mold</p>";
			$zmenu .= "						<input type='text' id='wtw_tmoldalttag' maxlength='255' onclick=\"WTW.checkKey(this, 'displayname', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'displayname', 0, 0);\" onblur=\"WTW.checkKey(this, 'displayname', 0, 1);\" />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_moldscalediv'>\r\n";
			$zmenu .= "					<h4 class='wtw-marginbottom'>Mold Texture Adjustment</h4>\r\n";
			$zmenu .= "					<div class='wtw-one-items single'>";
			$zmenu .= "						<h2>Scale Width <span>(0 for auto)</span></h2>\r\n";
			$zmenu .= "						<div class='wtw-onecol'>";
			$zmenu .= "							<input type='text' id='wtw_tmolduscale' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold(1);\" />\r\n";
			$zmenu .= "							<div class='item-input-down'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldus4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmolduscale', -1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-down1'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldus3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmolduscale', -.01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up1'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldus2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmolduscale', .01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldus1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmolduscale', 1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "						</div>\r\n";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "					<div class='wtw-one-items single'>";
			$zmenu .= "						<h2>Scale Height <span> (0 for auto)</span></h2>";
			$zmenu .= "						<div class='wtw-onecol'>\r\n";
			$zmenu .= "							<input type='text' id='wtw_tmoldvscale' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold(1);\" />\r\n";
			$zmenu .= "							<div class='item-input-down'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldvs4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldvscale', -1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-down1'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldvs3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldvscale', -.01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up1'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldvs2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldvscale', .01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldvs1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldvscale', 1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "						</div>\r\n";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "					<div class='wtw-one-items single'>";
			$zmenu .= "						<h2>Width Offset</h2>";
			$zmenu .= "						<div class='wtw-onecol'>\r\n";
			$zmenu .= "							<input type='text' id='wtw_tmolduoffset' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold(1);\" />\r\n";
			$zmenu .= "							<div class='item-input-down'>";
			$zmenu .= "								<input type='button' id='wtw_beditmolduo4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmolduoffset', -1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-down1'>";
			$zmenu .= "								<input type='button' id='wtw_beditmolduo3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmolduoffset', -.01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up1'>";
			$zmenu .= "								<input type='button' id='wtw_beditmolduo2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmolduoffset', .01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up'>";
			$zmenu .= "								<input type='button' id='wtw_beditmolduo1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmolduoffset', 1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "						</div>\r\n";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "					<div class='wtw-one-items single'>";
			$zmenu .= "						<h2>Height Offset</h2>";
			$zmenu .= "						<div class='wtw-onecol'>\r\n";
			$zmenu .= "							<input type='text' id='wtw_tmoldvoffset' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold(1);\" />\r\n";
			$zmenu .= "							<div class='item-input-down'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldvo4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldvoffset', -1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-down1'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldvo3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldvoffset', -.01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up1'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldvo2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldvoffset', .01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldvo1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldvoffset', 1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "						</div>\r\n";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "					<div class='wtw-one-items single'>";
			$zmenu .= "						<h2>Opacity <span>(0-transparent, 100-solid)</span></h2>";
			$zmenu .= "						<div class='wtw-onecol'>\r\n";
			$zmenu .= "							<input type='text' id='wtw_tmoldopacity' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold(1);\" />\r\n";
			$zmenu .= "							<div class='item-input-down'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldop4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldopacity', -1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-down1'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldop3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldopacity', -.01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up1'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldop2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldopacity', .01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "							<div class='item-input-up'>";
			$zmenu .= "								<input type='button' id='wtw_beditmoldop1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldopacity', 1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "							</div>";
			$zmenu .= "						</div>\r\n";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div id='wtw_moldsubdivisions'>\r\n";
			$zmenu .= "				<div class='wtw-one-items single two-arrows-only'>";
			$zmenu .= "					<h2>Subdivisions</h2>";
			$zmenu .= "					<div class='wtw-onecol'>\r\n";
			$zmenu .= "						<input type='text' id='wtw_tmoldsubdivisions' maxlength='16' class='wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold(1);\" />\r\n";
			$zmenu .= "						<div class='item-input-down'>";
			$zmenu .= "							<input type='button' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldsubdivisions', -1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "						<div class='item-input-up'>";
			$zmenu .= "							<input type='button' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldsubdivisions', 1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "						</div>";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div id='wtw_moldsounddiv'>\r\n";
			$zmenu .= "				<h2 class='wtw-marginbottom'>Attach Sound</h2>\r\n";
			$zmenu .= "				<div class='select-input-field'>\r\n";
			$zmenu .= "					<p>Attentuation Distance Model</p>\r\n";
			$zmenu .= "					<select id='wtw_tmoldsoundattenuation' class='wtw-pointer' onchange='WTW.setSoundFields();'>\r\n";
			$zmenu .= "						<option value='none'>No Sound</option>\r\n";
			$zmenu .= "						<option value='linear'>Linear</option>\r\n";
			$zmenu .= "						<option value='exponential'>Exponential</option>\r\n";
			$zmenu .= "						<option value='inverse'>Inverse</option>\r\n";
			$zmenu .= "					</select>\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div id='wtw_moldsoundoffdiv'>\r\n";
			$zmenu .= "					<div class='checkbox-input-field'>";
			$zmenu .= "						<input type='checkbox' id='wtw_tmoldsoundloop' class='wtw-smallprint' value='1' onchange='' /><span> Loop sound (repeat)</span>\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div id='wtw_moldsoundmaxdistdiv'>";
			$zmenu .= "						<div class='wtw-one-items single'>";
			$zmenu .= "							<h2 class='wtw-marginbottom'>Max Distance Linear <span>(Default: 100)</span></h2>\r\n";
			$zmenu .= "							<div class='wtw-onecol'>";
			$zmenu .= "								<input type='text' id='wtw_tmoldsoundmaxdistance' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput item-input' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold(1);\" />\r\n";
			$zmenu .= "								<div class='item-input-down'>";
			$zmenu .= "									<input type='button' id='wtw_beditmoldsdist4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldsoundmaxdistance', -1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "								</div>";
			$zmenu .= "								<div class='item-input-down1'>";
			$zmenu .= "									<input type='button' id='wtw_beditmoldsdist3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldsoundmaxdistance', -.01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "								</div>";
			$zmenu .= "								<div class='item-input-up1'>";
			$zmenu .= "									<input type='button' id='wtw_beditmoldsdist2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldsoundmaxdistance', .01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "								</div>";
			$zmenu .= "								<div class='item-input-up'>";
			$zmenu .= "									<input type='button' id='wtw_beditmoldsdist1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldsoundmaxdistance', 1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "								</div>";
			$zmenu .= "							</div>";
			$zmenu .= "						</div>";
			$zmenu .= "					</div>";
			$zmenu .= "					<div id='wtw_moldsoundrolloffdiv'>\r\n";
			$zmenu .= "						<div class='wtw-one-items single'>";
			$zmenu .= "							<h2>Roll Off Factor <span>(Default: 1)</span></h2>\r\n";
			$zmenu .= "							<div class='wtw-onecol'>";
			$zmenu .= "								<input type='text' id='wtw_tmoldsoundrollofffactor' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold(1);\" />\r\n";
			$zmenu .= "								<div class='item-input-down'>";
			$zmenu .= "									<input type='button' id='wtw_beditmoldsroll4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldsoundrollofffactor', -1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "								</div>";
			$zmenu .= "									<div class='item-input-down1'>";
			$zmenu .= "									<input type='button' id='wtw_beditmoldsroll3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldsoundrollofffactor', -.01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "								</div>";
			$zmenu .= "								<div class='item-input-up1'>";
			$zmenu .= "									<input type='button' id='wtw_beditmoldsroll2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldsoundrollofffactor', .01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "								</div>";
			$zmenu .= "								<div class='item-input-up'>";
			$zmenu .= "									<input type='button' id='wtw_beditmoldsroll1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldsoundrollofffactor', 1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "								</div>";
			$zmenu .= "							</div>";
			$zmenu .= "						</div>\r\n";
			$zmenu .= "					</div>\r\n";
			$zmenu .= "					<div id='wtw_moldsoundrefdistdiv'> \r\n";
			$zmenu .= "						<div class='wtw-one-items single'>";
			$zmenu .= "							<h2>Reference Distance <span>(Default: 1)</span></h2>\r\n";
			$zmenu .= "							<div class='wtw-onecol'>";
			$zmenu .= "								<input type='text' id='wtw_tmoldsoundrefdistance' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setNewMold(1);\" />\r\n";
			$zmenu .= "								<div class='item-input-down'>";
			$zmenu .= "									<input type='button' id='wtw_beditmoldsrdist4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldsoundrefdistance', -1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "								</div>";
			$zmenu .= "								<div class='item-input-down1'>";
			$zmenu .= "									<input type='button' id='wtw_beditmoldsrdist3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldsoundrefdistance', -.01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "									</div>";
			$zmenu .= "								<div class='item-input-up1'>";
			$zmenu .= "									<input type='button' id='wtw_beditmoldsrdist2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tmoldsoundrefdistance', .01, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "								</div>";
			$zmenu .= "								<div class='item-input-up'>";
			$zmenu .= "									<input type='button' id='wtw_beditmoldsrdist1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tmoldsoundrefdistance', 1, 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "								</div>";
			$zmenu .= "							</div>";
			$zmenu .= "						</div>";
			$zmenu .= "					</div>";
			$zmenu .= "					<img id='wtw_soundicon' src='/content/system/images/3dsound.png' class='wtw-adminiconimage' /> &nbsp;\r\n";
			$zmenu .= "					<div id='wtw_selectedsound'></div>\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div id='wtw_selectsound' class='wtw-menulevel0' onclick='WTW.adminMenuItemSelected(this);'>Select Sound</div>\r\n";
			$zmenu .= "				<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div id='wtw_moldmergemoldsdiv'>\r\n";
			$zmenu .= "				<a href='https://www.Roomz.com/wiki/cutting-out-3d-shapes/' title='Help' alt='Help' class='wtw-helplink' target='_blank'>?</a>\r\n";
			$zmenu .= "				<div class='select-input-field'>\r\n";
			$zmenu .= "					<p class='wtw-marginbottom'>Merge Shapes</p>\r\n";
			$zmenu .= "					<select id='wtw_tmoldcsgaction' class='wtw-pointer' onchange='WTW.checkMoldTextureCSG();WTW.setNewMold(1);'>\r\n";
			$zmenu .= "						<option value=''>None</option>\r\n";
			$zmenu .= "						<option value='subtract'>Subtract from another Shape</option>\r\n";
			$zmenu .= "						<option value='intersect'>Intersect with another Shape</option>\r\n";
			$zmenu .= "						<option value='union'>Combine with another Shape</option>\r\n";
			$zmenu .= "					</select>\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div id='wtw_selectedcsgshape'></div>\r\n";
			$zmenu .= "				<div id='wtw_bselectcsgshape' class='wtw-menulevel0' onclick='WTW.selectMergePart(WTW.pick);'>Pick Shape to Merge</div>\r\n";
			$zmenu .= "				<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "</div>\r\n";
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-getAdminMoldMenu=".$e->getMessage());
		}
		return $zmenu;
	}

	public function getAdminUserAccessMenu() {
		/* get html for the admin user access menu */
		/* admin menu form for editing user access to a 3D Community, Building, or Thing */
		global $wtwdb;
		$zmenu = '';
		try {
			$zmenu .= "<div id='wtw_adminmenu61b' class='wtw-hide' onclick='WTW.blockPassThrough();'>\r\n";
			$zmenu .= "		<h2>3D Community Access</h2>\r\n";
			$zmenu .= "		<div class='wtw-menulevel0text'>Note: Neighbors are Users with 3D Buildings in this 3D Community.\r\n";
			$zmenu .= "			Invitees are users who recieved an invitation to become a Neighbor.\r\n";
			$zmenu .= "		Visitors are all users.\r\n";
			$zmenu .= "		Architects can edit the 3D Community.\r\n";
			$zmenu .= "		Admins can Add or Remove Architects, Change Community Access, and edit the 3D Community.</div>\r\n";
			$zmenu .= "		<div class='input-field'>";
			$zmenu .= "			<p>User Email<span id='wtw_reqtadduseraccess' class='required'></span></p>";
			$zmenu .= "			<input type='text' id='wtw_tadduseridname' maxlength='64' width='250' onclick=\"WTW.checkKey(this, 'email', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'email', 0, 0);WTW.setAccessValid(2);\" onblur=\"WTW.checkKey(this, 'email', 0, 1);\" />";
			$zmenu .= "		</div>";
			$zmenu .= "		<div value='Add User' onclick='WTW.addAccess();' class='wtw-menulevel2'></div>\r\n";
			$zmenu .= "		<hr />\r\n";
			$zmenu .= "		<div id='wtw_useraccesslist'></div>\r\n";
			$zmenu .= "		\r\n";
			$zmenu .= "</div>\r\n";
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-getAdminUserAccessMenu=".$e->getMessage());
		}
		return $zmenu;
	}	

	public function getAdminUserDevAccessMenu() {
		/* get html for the admin user access menu */
		/* admin menu form for editing developer roles (depreciated) */
		global $wtwdb;
		$zmenu = '';
		try {
			$zmenu .= "<div id='wtw_adminmenu60b' class='wtw-hide' onclick='WTW.blockPassThrough();'>\r\n";
			$zmenu .= "		<div class='input-field'>";
			$zmenu .= "			<p>Add User <span>(Email or User ID)<.span><span id='wtw_reqtadduserdevaccess' class='wtw-required'></span></p>";
			$zmenu .= "			<input type='text' id='wtw_tadduserdevaccess' maxlength='64' width='250' onclick=\"WTW.checkKey(this, 'idoremail', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'idoremail', 0, 0);\" onblur=\"WTW.checkKey(this, 'idoremail', 0, 1);\" onkeyup='WTW.setDevAccessValid(2);' />";
			$zmenu .= "		</div>";
			$zmenu .= "		\r\n";
			$zmenu .= "		<h2>Access Level</h2>\r\n";
			$zmenu .= "		<div class='select-input-field'>\r\n";
			$zmenu .= "			<p id='wtw_accessnote' class='wtw-marginbottom'>Dev: updates to 3D Website.Admin: Dev and set permissions.</p>\r\n";
			$zmenu .= "			<select id='wtw_taddnewaccess' class='wtw-pointer'>\r\n";
			$zmenu .= "				<option value='dev'>Dev</option>\r\n";
			$zmenu .= "				<option value='admin'>Admin</option>\r\n";
			$zmenu .= "			</select>\r\n";
			$zmenu .= "		</div>";
			$zmenu .= "		\r\n";
			$zmenu .= "		<div onclick='WTW.addDevAccess();' class='wtw-greenbutton'>Add User</div>\r\n";
			$zmenu .= "		<hr />\r\n";
			$zmenu .= "		<div id='wtw_userdevaccesslist'></div>\r\n";
			$zmenu .= "		\r\n";
			$zmenu .= "</div>\r\n";
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-getAdminUserDevAccessMenu=".$e->getMessage());
		}
		return $zmenu;
	}	

	public function getAdminWaterDepthMenu() {
		/* get html for the admin user access menu */
		/* admin menu form for editing the water depth in a 3D Community Scene */
		global $wtwdb;
		$zmenu = '';
		try {
			$zmenu .= "<div id='wtw_adminmenu42b' class='wtw-hide' onclick='WTW.blockPassThrough();'>\r\n";
			$zmenu .= "		<div class='wtw-one-items single'>";
			$zmenu .= "			<h2>Extend Land Height <span>(Water Depth)</span></h2>\r\n";
			$zmenu .= "			<div class='wtw-onecol'>";
			$zmenu .= "				<input type='text' id='wtw_tgroundpositiony' maxlength='16' class='wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setGroundWater();\" />\r\n";
			$zmenu .= "				<div class='item-input-down'>";
			$zmenu .= "					<input type='button' id='wtw_bgroundpositionyp4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_tgroundpositiony', -1);\" onmouseup='WTW.changeStop();WTW.setGroundWater();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-down1'>";
			$zmenu .= "					<input type='button' id='wtw_bgroundpositionyp3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_tgroundpositiony', -.01);\" onmouseup='WTW.changeStop();WTW.setGroundWater();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up1'>";
			$zmenu .= "					<input type='button' id='wtw_bgroundpositionyp2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_tgroundpositiony', .01);\" onmouseup='WTW.changeStop();WTW.setGroundWater();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div class='item-input-up'>";
			$zmenu .= "					<input type='button' id='wtw_bgroundpositionyp1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_tgroundpositiony', 1);\" onmouseup='WTW.changeStop();WTW.setGroundWater();' />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "			</div>";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "		<div class='wtw-menulevel0text' style='text-align:left;font-size:.8em'><strong>Zero (0)</strong> Extended Land height removes water from the 3D Community.\r\n";
			$zmenu .= "		Setting a value <strong>less than zero</strong> will show water in your 3D Community.\r\n";
			$zmenu .= "		<strong>Extended Land</strong> is the continuous land that is always under your Avatar and keeps you from falling off the end of the ground. This does not change the height of other Land Terrain you may have added.</div>\r\n";
			$zmenu .= "		<div id='wtw_wateradvancedoptslink' onclick=\"WTW.toggleAdvanced(this, 'wtw_wateradvancedopts');\" class='wtw-showhideadvanced'>Advanced Options</div>\r\n";
			$zmenu .= "		<div id='wtw_wateradvancedopts' class='wtw-advanced'>";
			$zmenu .= "			<div class='img-text-field wtw-menulevel0text'>";
			$zmenu .= "				<h4>Water Texture Bump Image</h4>\r\n";
			$zmenu .= "				<p>Bump map texture that will apply to the Water. (optional)</p>\r\n";
			$zmenu .= "				<img id='wtw_waterbumppreview' class='wtw-previewimage' src='' />\r\n";
			$zmenu .= "				<div id='wtw_changewaterbumptexture' class='wtw-menulevel0' onclick='WTW.adminMenuItemSelected(this);'>Change Water Bump Map</div>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "			<h2>Bump Height <span>(up,-down)</span></h2>\r\n";
			$zmenu .= "				<div class='wtw-onecol'>\r\n";
			$zmenu .= "					<input type='text' id='wtw_twaterbumpheight' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setGroundWater();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatery4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_twaterbumpheight', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatery3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_twaterbumpheight', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatery2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_twaterbumpheight', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatery1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_twaterbumpheight', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "				<h2>Water Subdivisions <span>(for Bump Map)</span></h2>\r\n";
			$zmenu .= "				<div class='wtw-onecol'>\r\n";
			$zmenu .= "					<input type='text' id='wtw_twatersubdivisions' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setGroundWater();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatersub4' class='wtw-smallprint' value='-10' onmousedown=\"WTW.changeNumberValue('wtw_twatersubdivisions', -10);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatersub3' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_twatersubdivisions', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatersub2' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_twatersubdivisions', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatersub1' class='wtw-smallprint' value='+10' onmousedown=\"WTW.changeNumberValue('wtw_twatersubdivisions', 10);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "				<h2>Wave Height <span>(up,-down)</span></h2>\r\n";
			$zmenu .= "				<div class='wtw-onecol'>\r\n";
			$zmenu .= "					<input type='text' id='wtw_twaterwaveheight' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setGroundWater();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditwavey4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_twaterwaveheight', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwavey3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_twaterwaveheight', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwavey2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_twaterwaveheight', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditwavey1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_twaterwaveheight', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "				<h2>Wave Length <span>(front,-back)</span></h2>\r\n";
			$zmenu .= "				<div class='wtw-onecol'>\r\n";
			$zmenu .= "					<input type='text' id='wtw_twaterwavelength' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setGroundWater();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditwavez4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_twaterwavelength', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwavez3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_twaterwavelength', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwavez2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_twaterwavelength', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditwavez1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_twaterwavelength', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "			<div class='wtw-onecol'>\r\n";
			$zmenu .= "				<p>Water Color <span>(Refractive)</span> </p>\r\n";
			$zmenu .= "				<input type='text' placeholder='#23749C' id='wtw_twatercolorrefraction' maxlength='7' class='wtw-smallprintinput'  onfocus=\"WTW.openWaveColorSelector();\" onblur='WTW.closeColorSelector(false);WTW.setGroundWater();' onchange='WTW.setGroundWater();' onkeyup='WTW.setGroundWater();' />\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "				<h2>Color Blend Factor <span>(Refractive)</span></h2>\r\n";
			$zmenu .= "				<div class='wtw-onecol'>\r\n";
			$zmenu .= "					<input type='text' id='wtw_twatercolorblendfactor' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setGroundWater();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatercolor4' class='wtw-smallprint' value='-.1' onmousedown=\"WTW.changeNumberValue('wtw_twatercolorblendfactor', -.1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatercolor3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_twatercolorblendfactor', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatercolor2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_twatercolorblendfactor', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatercolor1' class='wtw-smallprint' value='+.1' onmousedown=\"WTW.changeNumberValue('wtw_twatercolorblendfactor', .1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='input-field'>";
			$zmenu .= "				<p>Water Color <span>(Reflective)</span></p>\r\n";
			$zmenu .= "				<input type='text' placeholder='#52BCF1' id='wtw_twatercolorreflection' maxlength='7' class='wtw-smallprintinput'  onfocus='WTW.openWaveColorSelector();' onblur='WTW.closeColorSelector(false);WTW.setGroundWater();' onchange='WTW.setGroundWater();' onkeyup='WTW.setGroundWater();' />\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "				<h2>Color Blend Factor <span>(Reflective)</span></h2>\r\n";
			$zmenu .= "				<div class='wtw-onecol'>\r\n";
			$zmenu .= "					<input type='text' id='wtw_twatercolorblendfactor2' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setGroundWater();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatercolor24' class='wtw-smallprint' value='-.1' onmousedown=\"WTW.changeNumberValue('wtw_twatercolorblendfactor2', -.1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatercolor23' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_twatercolorblendfactor2', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatercolor22' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_twatercolorblendfactor2', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditwatercolor21' class='wtw-smallprint' value='+.1' onmousedown=\"WTW.changeNumberValue('wtw_twatercolorblendfactor2', .1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "				<h2>Wind Force <span>(strength)</span></h2>\r\n";
			$zmenu .= "				<div class='wtw-onecol'>";
			$zmenu .= "					<input type='text' id='wtw_twaterwindforce' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setGroundWater();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindforce4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_twaterwindforce', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindforce3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_twaterwindforce', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindforce2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_twaterwindforce', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindforce1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_twaterwindforce', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<div class='wtw-one-items'>";
			$zmenu .= "				<h2>Wind Direction</h2>\r\n";
			$zmenu .= "				<div class='wtw-onecol'>\r\n";
			$zmenu .= "					<input type='text' id='wtw_twaterwinddirectionx' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setGroundWater();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindx4' class='wtw-smallprint' value='-.1' onmousedown=\"WTW.changeNumberValue('wtw_twaterwinddirectionx', -.1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindx3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_twaterwinddirectionx', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindx2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_twaterwinddirectionx', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindx1' class='wtw-smallprint' value='+.1' onmousedown=\"WTW.changeNumberValue('wtw_twaterwinddirectionx', .1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div class='wtw-onecol'>";
			$zmenu .= "					<input type='text' id='wtw_twaterwinddirectiony' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setGroundWater();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindy4' class='wtw-smallprint' value='-.1' onmousedown=\"WTW.changeNumberValue('wtw_twaterwinddirectiony', -.1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindy3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_twaterwinddirectiony', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindy2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_twaterwinddirectiony', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindy1' class='wtw-smallprint' value='+.1' onmousedown=\"WTW.changeNumberValue('wtw_twaterwinddirectiony', .1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div class='wtw-onecol'>";
			$zmenu .= "					<input type='text' id='wtw_twaterwinddirectionz' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setGroundWater();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindz4' class='wtw-smallprint' value='-.1' onmousedown=\"WTW.changeNumberValue('wtw_twaterwinddirectionz', -.1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindx3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_twaterwinddirectionz', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindz2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_twaterwinddirectionz', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditwindz1' class='wtw-smallprint' value='+.1' onmousedown=\"WTW.changeNumberValue('wtw_twaterwinddirectionz', .1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "			<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "			<div class='wtw-one-items single'>";
			$zmenu .= "				<h2>Opacity <span>(0-transparent, 100-solid)</span></h2>\r\n";
			$zmenu .= "				<div class='wtw-onecol'>\r\n";
			$zmenu .= "					<input type='text' id='wtw_twateralpha' maxlength='16' class='wtw-secondcolcontent wtw-smallprintinput' onclick=\"WTW.checkKey(this, 'number', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'number', 0, 0);\" onblur=\"WTW.checkKey(this, 'number', 0, 1);WTW.setGroundWater();\" />\r\n";
			$zmenu .= "					<div class='item-input-down'>";
			$zmenu .= "						<input type='button' id='wtw_beditwateralpha4' class='wtw-smallprint' value='-1' onmousedown=\"WTW.changeNumberValue('wtw_twateralpha', -1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-down1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwateralpha3' class='wtw-smallprint' value='-.01' onmousedown=\"WTW.changeNumberValue('wtw_twateralpha', -.01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up1'>";
			$zmenu .= "						<input type='button' id='wtw_beditwateralpha2' class='wtw-smallprint' value='+.01' onmousedown=\"WTW.changeNumberValue('wtw_twateralpha', .01);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "					<div class='item-input-up'>";
			$zmenu .= "						<input type='button' id='wtw_beditwateralpha1' class='wtw-smallprint' value='+1' onmousedown=\"WTW.changeNumberValue('wtw_twateralpha', 1);\" onmouseup='WTW.changeStop();' />\r\n";
			$zmenu .= "					</div>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "</div>\r\n";
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-getAdminWaterDepthMenu=".$e->getMessage());
		}
		return $zmenu;
	}	

	public function getAdminGroundSettingsMenu() {
		/* get html for the admin user access menu */
		/* admin menu form for editing the extended ground texture */
		global $wtwdb;
		$zmenu = '';
		try {
			$zmenu .= "<div id='wtw_adminmenu41b' class='wtw-hide' onclick='WTW.blockPassThrough();'>\r\n";
			$zmenu .= "		<h2>Ground Texture Image:</h2>\r\n";
			$zmenu .= "		<img id='wtw_showextendedgroundpreview' class='wtw-previewimage' />\r\n";
			$zmenu .= "		<div class='wtw-menulevel2' onclick=\"WTW.openFullPageForm('medialibrary','image','extendedgroundtexture','wtw_textendedgroundtextureid','wtw_textendedgroundtexturepath','wtw_showextendedgroundpreview');\" />Change Texture</div>\r\n";
			$zmenu .= "</div>\r\n";
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-getAdminGroundSettingsMenu=".$e->getMessage());
		}
		return $zmenu;
	}	

	public function getAdminSkyDomeMenu() {
		/* get html for the admin user access menu */
		/* admin menu form for editing the 3D Community Scene sky */
		global $wtwdb;
		$zmenu = '';
		try {
			$zmenu .= "<div id='wtw_adminmenu40b' class='wtw-hide' onclick='WTW.blockPassThrough();'>\r\n";
			$zmenu .= "		<div id='wtw_skysetday' class='wtw-menulevel2' onclick='WTW.adminMenuItemSelected(this);'>Set Day Scene</div>\r\n";
			$zmenu .= "		<div id='wtw_skysetsunrise' class='wtw-menulevel2' onclick='WTW.adminMenuItemSelected(this);'>Set Sunrise Scene</div>\r\n";
			$zmenu .= "		<div id='wtw_skysetsunset' class='wtw-menulevel2' onclick='WTW.adminMenuItemSelected(this);'>Set Sunset Scene</div>\r\n";
			$zmenu .= "		<div id='wtw_skysetnight' class='wtw-menulevel2' onclick='WTW.adminMenuItemSelected(this);'>Set Night Scene</div>\r\n";
			$zmenu .= "		<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "		<div id='wtw_skyadvancedoptslink' onclick=\"WTW.toggleAdvanced(this, 'wtw_skyadvancedopts');\" class='wtw-showhideadvanced'>Advanced Options</div>\r\n";
			$zmenu .= "		<div id='wtw_skyadvancedopts' class='wtw-advanced'>";
			$zmenu .= "			<div class='slider-field'>";
			$zmenu .= "				<h2>Solar Inclination</h2>\r\n";
			$zmenu .= "				<p>The sun position from Sunrise to Sunset.</p>\r\n";
			$zmenu .= "				<div class='slider-button'>";
			$zmenu .= "					<input type='button'  onclick=\"WTW.setSkyScene('inclination', null, -.01);\" />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<input id='wtw_tskyinclination' type='range' min='0' max='1.2' defaultValue='0' step='.01' onchange=\"WTW.setSkyScene('inclination', this.value, 0);\"/>\r\n";
			$zmenu .= "				<div class='slider-button'>";
			$zmenu .= "					<input type='button'  onclick=\"WTW.setSkyScene('inclination', null, .01);\" />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div id='wtw_skyinclination' class='wtw-mainmenuvalue wtw-center'></div>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='slider-field'>";
			$zmenu .= "				<h2>Sky Luminance</h2>\r\n";
			$zmenu .= "				<p>Controls the overall brightness of sky.</p>\r\n";
			$zmenu .= "				<div class='slider-button'>";
			$zmenu .= "					<input type='button'  onclick=\"WTW.setSkyScene('luminance', null, .01);\" />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<input id='wtw_tskyluminance' type='range' min='0' max='1' defaultValue='1' step='.01' style='direction:rtl;' onchange=\"WTW.setSkyScene('luminance', this.value, 0);\"/>\r\n";
			$zmenu .= "				<div class='slider-button'>";
			$zmenu .= "					<input type='button'  onclick=\"WTW.setSkyScene('luminance', null, -.01);\" />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div id='wtw_skyluminance' class='wtw-mainmenuvalue wtw-center'></div>	\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='slider-field'>";
			$zmenu .= "				<h2>Solar Azimuth</h2>\r\n";
			$zmenu .= "				<p>The horizontal angle of the sun position.</p>\r\n";
			$zmenu .= "				<div class='slider-button'>";
			$zmenu .= "					<input type='button'  onclick=\"WTW.setSkyScene('azimuth', null, -.01);\" />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<input id='wtw_tskyazimuth' type='range' min='0' max='.5' defaultValue='.25' step='.01' onchange=\"WTW.setSkyScene('azimuth', this.value, 0);\"/>\r\n";
			$zmenu .= "				<div class='slider-button'>";
			$zmenu .= "					<input type='button'  onclick=\"WTW.setSkyScene('azimuth', null, .01);\" />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div id='wtw_skyazimuth' class='wtw-mainmenuvalue wtw-center'></div>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='slider-field'>";
			$zmenu .= "				<h2>Sky Rayleigh</h2>\r\n";
			$zmenu .= "				<p>Represents the global sky appearance.</p>\r\n";
			$zmenu .= "				<div class='slider-button'>";
			$zmenu .= "					<input type='button'  onclick=\"WTW.setSkyScene('rayleigh', null, -.01);\" />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<input id='wtw_tskyrayleigh' type='range' min='0' max='5' defaultValue='2.00' step='.01' onchange=\"WTW.setSkyScene('rayleigh', this.value, 0);\"/>\r\n";
			$zmenu .= "				<div class='slider-button'>";
			$zmenu .= "					<input type='button'  onclick=\"WTW.setSkyScene('rayleigh', null, .01);\" />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div id='wtw_skyrayleigh' class='wtw-mainmenuvalue wtw-center'></div>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='slider-field'>";
			$zmenu .= "				<h2>Haze Turbidity</h2>\r\n";
			$zmenu .= "				<p>The amount of haze scattering in the atmosphere.</p>\r\n";
			$zmenu .= "				<div class='slider-button'>";
			$zmenu .= "					<input type='button'  onclick=\"WTW.setSkyScene('turbidity', null, -1);\" />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<input id='wtw_tskyturbidity' type='range' min='0' max='50' defaultValue='10' step='1' onchange=\"WTW.setSkyScene('turbidity', this.value, 0);\"/>\r\n";
			$zmenu .= "				<div class='slider-button'>";
			$zmenu .= "					<input type='button'  onclick=\"WTW.setSkyScene('turbidity', null, 1);\" />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div id='wtw_skyturbidity' class='wtw-mainmenuvalue wtw-center'></div>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='slider-field'>";
			$zmenu .= "				<h2>Haze Mie Scattering</h2>\r\n";
			$zmenu .= "				<p>The amount of haze particles in the atmosphere.</p>\r\n";
			$zmenu .= "				<div class='slider-button'>";
			$zmenu .= "					<input type='button'  onclick=\"WTW.setSkyScene('miedirectionalg', null, -.01);\" />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<input id='wtw_tskymiedirectionalg' type='range' min='.20' max='.99' defaultValue='.80' step='.01' onchange=\"WTW.setSkyScene('miedirectionalg', this.value, 0);\"/>\r\n";
			$zmenu .= "				<div class='slider-button'>";
			$zmenu .= "					<input type='button' onclick=\"WTW.setSkyScene('miedirectionalg', null, .01);\" />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div id='wtw_skymiedirectionalg' class='wtw-mainmenuvalue wtw-center'></div>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			<div class='slider-field'>";
			$zmenu .= "				<h2>Haze Mie Coefficient</h2>\r\n";
			$zmenu .= "				<p>The haze particle size coefficient.</p>\r\n";
			$zmenu .= "				<div class='slider-button'>";
			$zmenu .= "					<input type='button'  onclick=\"WTW.setSkyScene('miecoefficient', null, -.001);\" />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<input id='wtw_tskymiecoefficient' type='range' min='.001' max='.999' defaultValue='.008' step='.001' onchange=\"WTW.setSkyScene('miecoefficient', this.value, 0);\"/>\r\n";
			$zmenu .= "				<div class='slider-button'>";
			$zmenu .= "					<input type='button' onclick=\"WTW.setSkyScene('miecoefficient', null, .001);\" />\r\n";
			$zmenu .= "				</div>";
			$zmenu .= "				<div id='wtw_skymiecoefficient' class='wtw-mainmenuvalue wtw-center'></div>\r\n";
			$zmenu .= "			</div>";
			$zmenu .= "			\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "</div>\r\n";
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-getAdminSkyDomeMenu=".$e->getMessage());
		}
		return $zmenu;
	}	

	public function getAdminShareMenu($zmenuid, $zwebtype) {
		/* get html for the admin user access menu */
		/* admin menu form for Sharing a 3D Web */
		global $wtwdb;
		$zmenu = '';
		try {
			$zwebtypes = 'communities';
			$zexamples = 'Desert, Mountains, Islands, Forest, River, Snow, Spring, Fall, etc';
			switch ($zwebtype) {
				case 'building':
					$zwebtypes = 'buidings';
					$zexamples = 'Business, Store, House, Number of Floors, Blue, Wood, etc';
					break;
				case 'thing':
					$zwebtypes = 'things';
					$zexamples = 'Table, Chair, Display, Lamp, Car, Tree, Bridge, Bench, etc';
					break;
			}
			$zmenu .= "<div id='".$zmenuid."' class='wtw-hide' onclick='WTW.blockPassThrough();'>\r\n";
			$zmenu .= "		<div class='input-field'>";
			$zmenu .= "			<p>Template Name</p>";
			$zmenu .= "			<input type='text' id='wtw_tshare".$zwebtype."tempname' maxlength='255' onclick=\"WTW.checkKey(this, 'displayname', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'displayname', 0, 0);\" onblur=\"WTW.checkKey(this, 'displayname', 0, 1);\" />";
			$zmenu .= "		</div>";
			$zmenu .= "		<div class='text-field'>";
			$zmenu .= "			<p>Description</p>";
			$zmenu .= "			<textarea id='wtw_tshare".$zwebtype."description' rows='4' onclick=\"WTW.checkKey(this, 'safetext', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'safetext', 0, 0);\" onblur=\"WTW.checkKey(this, 'safetext', 0, 1);\"></textarea>";
			$zmenu .= "		</div>";
			$zmenu .= "		<div class='input-field'>";
			$zmenu .= "			<p>Search Category Tags</p>";
			$zmenu .= "			<input type='text' id='wtw_tshare".$zwebtype."tags' maxlength='255' onclick=\"WTW.checkKey(this, 'displayname', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'displayname', 0, 0);\" onblur=\"WTW.checkKey(this, 'displayname', 0, 1);\" />";
			$zmenu .= "		</div>";
			$zmenu .= "		<div class='wtw-menulevel0text'>Example: ".$zexamples."</div>\r\n";
			$zmenu .= "		\r\n";
			$zmenu .= "		<div id='wtw_bsnapshot".$zwebtype."' class='wtw-menulevel2' onclick=\"WTW.snapshot3D(dGet('wtw_tcontentpath').value + '/uploads/".$zwebtypes."/' + dGet('wtw_t".$zwebtype."id').value + '/snapshots/', 'default".$zwebtype.".png');\" style='cursor: pointer;'>Set Default Snapshot</div>\r\n";
			$zmenu .= "		<img id='wtw_default".$zwebtype."snapshot' class='wtw-snapshot' />\r\n"; 
			$zmenu .= "		<div id='wtw_share".$zwebtype."response' style='font-size:1.5em;color:green;'></div>\r\n"; 
			$zmenu .= "		<h2>Initial Share or Update</h2>\r\n";
			$zmenu .= "		<div class='radio-field' onclick=\"dGet('wtw_tshare".$zwebtype."original').click();\">\r\n";
			$zmenu .= "			<input type='radio' id='wtw_tshare".$zwebtype."original' name='wtw_tsharetype' value='initial' onchange=\"WTW.changeWebVersion('".$zwebtype."');\" />";
			$zmenu .= "			<p>Initial Share</p>";
			$zmenu .= "		</div>";
			$zmenu .= "		<div class='wtw-menulevel0text'>You created the 3D ".ucwords($zwebtype)." and want to Share it.</div>\r\n";
			$zmenu .= "		\r\n";
			$zmenu .= "		<div class='radio-field' onclick=\"dGet('wtw_tshare".$zwebtype."update').click();\">\r\n";
			$zmenu .= "			<input type='radio' id='wtw_tshare".$zwebtype."update' name='wtw_tsharetype' value='update' onchange=\"WTW.changeWebVersion('".$zwebtype."');\" />";
			$zmenu .= "			<p>Update Share</p>";
			$zmenu .= "		</div>";
			$zmenu .= "		<div>";
			$zmenu .= "				<div class='wtw-menulevel0text'>\r\n";
			$zmenu .= "					Optional: Only Available if this 3D ".ucwords($zwebtype)." was already Shared and you are the original creator.\r\n";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "			<div id='wtw_tshare".$zwebtype."div' class='wtw-hide'>\r\n";
			$zmenu .= "				<div class='input-field'><p>Version: </p> <input type='text' id='wtw_tshare".$zwebtype."version' maxlength='255' value='1.0.0' /></div>";
			$zmenu .= "				<div class='wtw-menulevel0text'> Version Numbers are 3 numbers each separated by a period.</div>";
			$zmenu .= "				<div class='wtw-menulevel0text'>\r\n";
			$zmenu .= "					<ul>";
			$zmenu .= "						<li>First number is incremented for major changes or complete rebuilds.</li>";
			$zmenu .= "						<li>Second number is incremented for minor changes or additions</li>";
			$zmenu .= "						<li>Third number is incremented for adjustments, texture changes, or bug fixes.</li>";
			$zmenu .= "						<li>When the first or second number changes, the numbers to the right reset to 0.</li>";
			$zmenu .= "					</ul>";
			$zmenu .= "				</div>\r\n";
			$zmenu .= "				<div class='input-field'><p>Version Description:</p> <input type='text' id='wtw_tshare".$zwebtype."versiondesc' maxlength='255' value='' /></div>";
			$zmenu .= "			</div>\r\n";
			$zmenu .= "		</div>\r\n";
			$zmenu .= "</div>\r\n";
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-getAdminShareMenu=".$e->getMessage());
		}
		return $zmenu;
	}

	public function getAdminWebMenu($zmenuid, $zwebtype) {
		/* get html for the admin user access menu */
		/* admin menu form for editing 3D Web Information */
		global $wtwdb;
		$zmenu = '';
		try {
			$zwebtypes = 'communities';
			$zsavebutton = 'wtw_save25';
			switch ($zwebtype) {
				case 'building':
					$zwebtypes = 'buidings';
					$zsavebutton = 'wtw_adminmenubuildsave';
					break;
				case 'thing':
					$zwebtypes = 'things';
					$zsavebutton = 'wtw_adminmenuthingsave';
					break;
			}
			$zmenu .= "<div id='".$zmenuid."' class='wtw-hide' onclick='WTW.blockPassThrough();'>\r\n";
			$zmenu .= "		<div class='input-field'>";
			$zmenu .= "			<p>3D ".ucwords($zwebtype)." Name <span id='wtw_reqedit".$zwebtype."name' class='wtw-required'></span></p>";
			$zmenu .= "			<input type='text' id='wtw_t".$zwebtype."name' maxlength='255' onclick=\"WTW.checkKey(this, 'displayname', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'displayname', 0, 0);\" onblur=\"WTW.checkKey(this, 'displayname', 0, 1);\" />";
			$zmenu .= "		</div>";
			$zmenu .= "		<div class='input-field'>";
			$zmenu .= "			<p>Version</p>";
			$zmenu .= "			<input type='text' id='wtw_tinfo".$zwebtype."version' maxlength='12' />\r\n";
			$zmenu .= "		</div>";
			$zmenu .= "		<div class='input-field'>";
			$zmenu .= "			<p>Version Description</p>";
			$zmenu .= "			<input type='text' id='wtw_tinfo".$zwebtype."versiondesc' maxlength='255' />\r\n";
			$zmenu .= "		</div>";
			$zmenu .= "		<div class='input-field'>";
			$zmenu .= "			<p>3D ".ucwords($zwebtype)." Description</p>";
			$zmenu .= "			<input type='text' id='wtw_t".$zwebtype."description' maxlength='255' onclick=\"WTW.checkKey(this, 'safetext', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'safetext', 0, 0);\" onblur=\"WTW.checkKey(this, 'safetext', 0, 1);\" />\r\n";
			$zmenu .= "		</div>";
			$zmenu .= "		<div class='wtw-menulevel0text' style='text-align:left;'>Description shows on the meta tags of the 3D Website</div>\r\n";
			$zmenu .= "		<div class='input-field'>";
			$zmenu .= "			<p>Google Analytics ID</p>";
			$zmenu .= "			<input type='text' id='wtw_t".$zwebtype."analyticsid' maxlength='255' onclick=\"WTW.checkKey(this, 'webname', 1, 0);\" onkeyup=\"WTW.checkKey(this, 'webname', 1, 0);\" onblur=\"WTW.checkKey(this, 'webname', 1, 1);\" />\r\n";
			$zmenu .= "		</div>";
			$zmenu .= "		<hr class='wtw-menuhr' />\r\n";
			$zmenu .= "		<div class='input-field'>";
			$zmenu .= "			<p>Alt Tag for 3D ".ucwords($zwebtype)."</p>";
			$zmenu .= "			<input type='text' id='wtw_t".$zwebtype."alttag' maxlength='255' onclick=\"WTW.checkKey(this, 'displayname', 0, 0);\" onkeyup=\"WTW.checkKey(this, 'displayname', 0, 0);\" onblur=\"WTW.checkKey(this, 'displayname', 0, 1);\" />\r\n";
			$zmenu .= "		</div>";
			$zmenu .= "		<div id='".$zsavebutton."' class='wtw-greenbuttonbig' onclick='WTW.adminMenuItemSelected(this);'>Save Settings</div>\r\n";
			$zmenu .= "</div>\r\n";
		} catch (Exception $e) {
			$wtwdb->serror("core-functions-class_wtwmenus.php-getAdminWebMenu=".$e->getMessage());
		}
		return $zmenu;
	}	
	public function __($zlabel) {
		/* Language translation based on language file */
		global $wtwdb;
		return $wtwdb->__($zlabel);
	}	

}

	function wtwadminmenu() {
		return wtwadminmenu::instance();
	}

	/* Global for backwards compatibility. */
	$GLOBALS['wtwadminmenu'] = wtwadminmenu();	



	
/* line 624: logo needs to be updated*/ 
?>


