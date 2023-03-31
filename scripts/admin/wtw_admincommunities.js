/* All code is Copyright 2013-2023 Bixma */
/* All code is patent */

/* these functions are used to administer a website in admin mode only */

/* these functions administer 3D Communities as a whole (mold functions are in wtw_adminmolds.js) */
/* name, alt tags, set analytics, etc... */
/* also includes 3D Scene settings: sky, gravity, water level, extended ground, etc... */
/* 		and common functions for 3D Communities, 3D Buildings, and 3D Things */

WTWJS.prototype.openCommunityForm = async function(zcommunityid) {
	/* open the 3D Community Information form */
	try {
		WTW.show('wtw_loadingcommunityform');
		WTW.show('wtw_loadingwaterdepthform');
		WTW.hide('wtw_adminmenu25b');
		WTW.hide('wtw_adminmenu42b');
		dGet('wtw_tcommunityalttag').value = '';
		WTW.getAsyncJSON('/connect/communities.php', 
			function(zresponse) {
				WTW.communities = JSON.parse(zresponse);
				if (WTW.communities != null) {
					for (var i = 0; i < WTW.communities.length; i++) {
						if (WTW.communities[i] != null) {
							if (WTW.communities[i].communityinfo.communityid != undefined) {
								if (zcommunityid == WTW.communities[i].communityinfo.communityid) {
									dGet('wtw_tinfocommunityversion').disabled = false;
									dGet('wtw_tinfocommunityversiondesc').disabled = false;
									dGet('wtw_tcommunityname').value = WTW.decode(WTW.communities[i].communityinfo.communityname);
									dGet('wtw_tversionid').value = WTW.communities[i].communityinfo.versionid;
									dGet('wtw_tinfocommunityversion').value = WTW.communities[i].communityinfo.version;
									dGet('wtw_tinfocommunityversiondesc').value = WTW.decode(WTW.communities[i].communityinfo.versiondesc);
									dGet('wtw_tcommunitydescription').value = WTW.decode(WTW.communities[i].communityinfo.communitydescription);
									dGet('wtw_tcommunitysnapshotid').value = WTW.communities[i].communityinfo.snapshotid;
									dGet('wtw_tcommunityanalyticsid').value = WTW.communities[i].communityinfo.analyticsid;
									dGet('wtw_tgroundpositiony').value = Number(WTW.communities[i].ground.position.y).toFixed(2);
									dGet('wtw_twaterpositiony').value = Number(WTW.communities[i].water.position.y).toFixed(2);
									dGet('wtw_twaterbumpid').value = WTW.communities[i].water.bump.id;
									dGet('wtw_twaterbumpheight').value = Number(WTW.communities[i].water.bump.height).toFixed(2);
									dGet('wtw_twatersubdivisions').value = Number(WTW.communities[i].water.subdivisions).toFixed(0);
									dGet('wtw_twaterwaveheight').value = Number(WTW.communities[i].water.waveheight).toFixed(2);
									dGet('wtw_twaterwavelength').value = Number(WTW.communities[i].water.wavelength).toFixed(2);
									dGet('wtw_twatercolorrefraction').value = WTW.communities[i].water.colorrefraction;
									dGet('wtw_twatercolorreflection').value = WTW.communities[i].water.colorreflection;
									dGet('wtw_twatercolorblendfactor').value = Number(WTW.communities[i].water.colorblendfactor).toFixed(2);
									dGet('wtw_twatercolorblendfactor2').value = Number(WTW.communities[i].water.colorblendfactor2).toFixed(2);
									dGet('wtw_twaterwindforce').value = Number(WTW.communities[i].wind.force).toFixed(2);
									dGet('wtw_twaterwinddirectionx').value = Number(WTW.communities[i].wind.direction.x).toFixed(2);
									dGet('wtw_twaterwinddirectiony').value = Number(WTW.communities[i].wind.direction.y).toFixed(2);
									dGet('wtw_twaterwinddirectionz').value = Number(WTW.communities[i].wind.direction.z).toFixed(2);
									dGet('wtw_twateralpha').value = Number(WTW.communities[i].water.alpha).toFixed(2) * 100;
									dGet('wtw_tcommunityalttag').value = WTW.decode(WTW.communities[i].alttag.name);
									dGet('wtw_tcommunityalttag').value = WTW.decode(WTW.communities[i].alttag.name);
									dGet('wtw_tinfocommunityversion').disabled = true;
									dGet('wtw_tinfocommunityversiondesc').disabled = true;
									dGet('wtw_twaterbumppath').value = WTW.communities[i].water.bump.path;
									if (dGet('wtw_twaterbumppath').value == '') {
										dGet('wtw_twaterbumppath').value = '/content/system/images/waterbump.png';
									}
									dGet('wtw_waterbumppreview').src = dGet('wtw_twaterbumppath').value;
								}
							}
						}
					}
				}
				window.setTimeout(function() {
					WTW.hide('wtw_loadingcommunityform');
					WTW.hide('wtw_loadingwaterdepthform');
					WTW.show('wtw_adminmenu25b');
					WTW.show('wtw_adminmenu42b');
					WTW.setWindowSize();
				},500);
			}
		);
		if (dGet('wtw_tcommunityname') != null) {
			dGet('wtw_tcommunityname').focus();
		}
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-openCommunityForm=' + ex.message);
	}
}		

WTWJS.prototype.loadCommunityForm = async function(zcommunityid) {
	/* load settings to the 3D Community Information Form */
	try {
		dGet('wtw_tcommunityalttag').value = '';
		WTW.getAsyncJSON('/connect/communities.php', 
			function(zresponse) {
				WTW.communities = JSON.parse(zresponse);
				if (WTW.communities != null) {
					for (var i = 0; i < WTW.communities.length; i++) {
						if (WTW.communities[i] != null) {
							if (WTW.communities[i].communityinfo.communityid != undefined) {
								if (zcommunityid == WTW.communities[i].communityinfo.communityid) {
									dGet('wtw_tcommunityname').value = WTW.decode(WTW.communities[i].communityinfo.communityname);
									dGet('wtw_tcommunitydescription').value = WTW.decode(WTW.communities[i].communityinfo.communitydescription);
									dGet('wtw_tcommunitysnapshotid').value = WTW.communities[i].communityinfo.snapshotid;
									dGet('wtw_tcommunityanalyticsid').value = WTW.communities[i].communityinfo.analyticsid;
									dGet('wtw_tgroundpositiony').value = Number(WTW.communities[i].ground.position.y).toFixed(2);
									dGet('wtw_twaterpositiony').value = Number(WTW.communities[i].water.position.y).toFixed(2);
									dGet('wtw_twaterbumpid').value = WTW.communities[i].water.bump.id;
									dGet('wtw_twaterbumpheight').value = Number(WTW.communities[i].water.bump.height).toFixed(2);
									dGet('wtw_twatersubdivisions').value = Number(WTW.communities[i].water.subdivisions).toFixed(0);
									dGet('wtw_twaterwaveheight').value = Number(WTW.communities[i].water.waveheight).toFixed(2);
									dGet('wtw_twaterwavelength').value = Number(WTW.communities[i].water.wavelength).toFixed(2);
									dGet('wtw_twatercolorrefraction').value = WTW.communities[i].water.colorrefraction;
									dGet('wtw_twatercolorreflection').value = WTW.communities[i].water.colorreflection;
									dGet('wtw_twatercolorblendfactor').value = Number(WTW.communities[i].water.colorblendfactor).toFixed(2);
									dGet('wtw_twatercolorblendfactor2').value = Number(WTW.communities[i].water.colorblendfactor2).toFixed(2);
									dGet('wtw_twaterwindforce').value = Number(WTW.communities[i].wind.force).toFixed(2);
									dGet('wtw_twaterwinddirectionx').value = Number(WTW.communities[i].wind.direction.x).toFixed(2);
									dGet('wtw_twaterwinddirectiony').value = Number(WTW.communities[i].wind.direction.y).toFixed(2);
									dGet('wtw_twaterwinddirectionz').value = Number(WTW.communities[i].wind.direction.z).toFixed(2);
									dGet('wtw_twateralpha').value = Number(WTW.communities[i].water.alpha).toFixed(2) * 100;
									dGet('wtw_tcommunityalttag').value = WTW.decode(WTW.communities[i].alttag.name);
									dGet('wtw_twaterbumppath').value = WTW.communities[i].water.bump.path;
									if (dGet('wtw_twaterbumppath').value == '') {
										dGet('wtw_twaterbumppath').value = '/content/system/images/waterbump.png';
									}
									dGet('wtw_waterbumppreview').src = dGet('wtw_twaterbumppath').value;
								}
							}
						}
					}
				}
			}
		);
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-loadCommunityForm=' + ex.message);
	}
}		

WTWJS.prototype.submitCommunityForm = async function(w) {
	/* submit the 3D Community Information Form */
	try {
		switch (w) {
			case 0:
				/* delete 3D Community */
				/* note that the 3D Community is flagged as deleted in the database and no data is actually deleted */
				var zrequest = {
					'communityid': communityid,
					'function':'deletecommunity'
				};
				WTW.postAsyncJSON('/core/handlers/communities.php', zrequest, 
					function(zresponse) {
						zresponse = JSON.parse(zresponse);
						/* note serror would contain errors */
						WTW.redirectParent('/admin.php');
					}
				);
				break;
			case 1:
				/* save 3D Community settings */
				var zalpha = 1;
				if (WTW.isNumeric(dGet('wtw_twateralpha').value)) {
					zalpha = Number(dGet('wtw_twateralpha').value) / 100;
				}
				if (WTW.isNumeric(dGet('wtw_tgroundpositiony').value) == false) {
					dGet('wtw_tgroundpositiony').value = '0.00';
				}
				if (WTW.isNumeric(dGet('wtw_twaterpositiony').value) == false) {
					dGet('wtw_twaterpositiony').value = '-1.00';
				}
				for (var i = 0; i < WTW.communities.length; i++) {
					if (WTW.communities[i] != null) {
						if (WTW.communities[i].communityinfo.communityid == communityid) {
							WTW.communities[i].communityinfo.version = dGet('wtw_tinfocommunityversion').value;
							WTW.communities[i].communityinfo.versiondesc = WTW.encode(dGet('wtw_tinfocommunityversiondesc').value);
							WTW.communities[i].communityinfo.communityname = WTW.encode(dGet('wtw_tcommunityname').value);
							WTW.communities[i].communityinfo.communitydescription = WTW.encode(dGet('wtw_tcommunitydescription').value);
							WTW.communities[i].communityinfo.analyticsid = dGet('wtw_tcommunityanalyticsid').value;
							WTW.communities[i].ground.position.y = dGet('wtw_tgroundpositiony').value;
							WTW.communities[i].water.position.y = dGet('wtw_twaterpositiony').value;
							WTW.communities[i].water.bump.id = dGet('wtw_twaterbumpid').value;
							WTW.communities[i].water.bump.height = dGet('wtw_twaterbumpheight').value;
							WTW.communities[i].water.subdivisions = dGet('wtw_twatersubdivisions').value;
							WTW.communities[i].water.waveheight = dGet('wtw_twaterwaveheight').value;
							WTW.communities[i].water.wavelength = dGet('wtw_twaterwavelength').value;
							WTW.communities[i].water.colorrefraction = dGet('wtw_twatercolorrefraction').value;
							WTW.communities[i].water.colorreflection = dGet('wtw_twatercolorreflection').value;
							WTW.communities[i].water.colorblendfactor = dGet('wtw_twatercolorblendfactor').value;
							WTW.communities[i].water.colorblendfactor2 = dGet('wtw_twatercolorblendfactor2').value;
							WTW.communities[i].water.alpha = zalpha;
							WTW.communities[i].water.bump.path = dGet('wtw_twaterbumppath').value;
							WTW.communities[i].wind.force = dGet('wtw_twaterwindforce').value;
							WTW.communities[i].wind.direction.x = dGet('wtw_twaterwinddirectionx').value;
							WTW.communities[i].wind.direction.y = dGet('wtw_twaterwinddirectiony').value;
							WTW.communities[i].wind.direction.z = dGet('wtw_twaterwinddirectionz').value;
							WTW.communities[i].alttag.name = WTW.encode(dGet('wtw_tcommunityalttag').value);
							dGet('wtw_showcommunityname').innerHTML = dGet('wtw_tcommunityname').value;
						}
					}
				}
				for (var i = 0; i < WTW.communitiesMolds.length; i++) {
					if (WTW.communitiesMolds[i] != null) {
						if (WTW.communitiesMolds[i].communityinfo.communityid == communityid) {
							WTW.communitiesMolds[i].graphics.texture.backupid = '';
						}
					}
				}
				var zrequest = {
					'communityid': communityid,
					'communityname': btoa(dGet('wtw_tcommunityname').value),
					'communitydescription': btoa(dGet('wtw_tcommunitydescription').value),
					'versionid': dGet('wtw_tversionid').value,
					'version': dGet('wtw_tinfocommunityversion').value,
					'versiondesc': btoa(dGet('wtw_tinfocommunityversiondesc').value),
					'analyticsid': dGet('wtw_tcommunityanalyticsid').value,
					'groundpositiony': dGet('wtw_tgroundpositiony').value,
					'waterpositiony': dGet('wtw_twaterpositiony').value,
					'waterbumpid': dGet('wtw_twaterbumpid').value,
					'waterbumppath': dGet('wtw_twaterbumppath').value,
					'waterbumpheight': dGet('wtw_twaterbumpheight').value,
					'watersubdivisions': dGet('wtw_twatersubdivisions').value,
					'waterwaveheight': dGet('wtw_twaterwaveheight').value,
					'waterwavelength': dGet('wtw_twaterwavelength').value,
					'watercolorrefraction': dGet('wtw_twatercolorrefraction').value,
					'watercolorreflection': dGet('wtw_twatercolorreflection').value,
					'watercolorblendfactor': dGet('wtw_twatercolorblendfactor').value,
					'watercolorblendfactor2': dGet('wtw_twatercolorblendfactor2').value,
					'wateralpha': zalpha,
					'waterwindforce': dGet('wtw_twaterwindforce').value,
					'waterwinddirectionx': dGet('wtw_twaterwinddirectionx').value,
					'waterwinddirectiony': dGet('wtw_twaterwinddirectiony').value,
					'waterwinddirectionz': dGet('wtw_twaterwinddirectionz').value,
					'alttag': btoa(dGet('wtw_tcommunityalttag').value),
					'function':'savecommunity'
				};
				WTW.postAsyncJSON('/core/handlers/communities.php', zrequest, 
					function(zresponse) {
						zresponse = JSON.parse(zresponse);
						/* note serror would contain errors */
						WTW.hideAdminMenu();
						WTW.backToTools();
						WTW.setMenuBarSelectText();
					}
				);
				break;
			case -1:
				/* cancel and reverse any 3D Community settings */
				for (var i = 0; i < WTW.communities.length; i++) {
					if (WTW.communities[i] != null) {
						if (WTW.communities[i].communityinfo.communityid == communityid) {
							dGet('wtw_tinfocommunityversion').value = WTW.communities[i].communityinfo.version;
							dGet('wtw_tinfocommunityversiondesc').value = WTW.decode(WTW.communities[i].communityinfo.versiondesc);
							dGet('wtw_tcommunityname').value = WTW.decode(WTW.communities[i].communityinfo.communityname);
							dGet('wtw_tcommunitydescription').value = WTW.decode(WTW.communities[i].communityinfo.communitydescription);
							dGet('wtw_tcommunityanalyticsid').value = WTW.communities[i].communityinfo.analyticsid;
							dGet('wtw_tcommunityalttag').value = WTW.decode(WTW.communities[i].alttag.name);
						}
					}
				}
				//need rollback on scene
				WTW.hideAdminMenu();
				WTW.backToTools();
				WTW.setMenuBarSelectText();
				break;
		}
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-submitCommunityForm=' + ex.message);
	}
}

WTWJS.prototype.openWaveColorSelector = function() {
	/* opens 2 color selectors for water waves refractive and reflective colors */
	try {
		if (WTW.guiAdminColors != null) {
			WTW.guiAdminColors.dispose();
			WTW.guiAdminColors = null;
		}
		WTW.guiAdminColors = BABYLON.GUI.AdvancedDynamicTexture.CreateFullscreenUI('UI');
		var zpanel = new BABYLON.GUI.StackPanel();
		zpanel.width = '300px';
		zpanel.isVertical = true;
		zpanel.horizontalAlignment = BABYLON.GUI.Control.HORIZONTAL_ALIGNMENT_RIGHT;
		zpanel.verticalAlignment = BABYLON.GUI.Control.VERTICAL_ALIGNMENT_TOP;
		WTW.guiAdminColors.addControl(zpanel);

		var zcolortitle = new BABYLON.GUI.TextBlock();
		zcolortitle.text = 'Refraction Color';
		zcolortitle.color = '#FFFFFF';
		zcolortitle.fontSize = 20;
		zcolortitle.height = '50px';
		zpanel.addControl(zcolortitle);     
	
		var zcolorpicker = new BABYLON.GUI.ColorPicker();
		zcolorpicker.value = new BABYLON.Color3.FromHexString(dGet('wtw_twatercolorrefraction').value);
		zcolorpicker.height = '250px';
		zcolorpicker.width = '250px';
		zcolorpicker.horizontalAlignment = BABYLON.GUI.Control.HORIZONTAL_ALIGNMENT_CENTER;
		zcolorpicker.verticalAlignment = BABYLON.GUI.Control.VERTICAL_ALIGNMENT_TOP;
		zcolorpicker.onValueChangedObservable.add(function(value) {
			if (value != null) {
				dGet('wtw_twatercolorrefraction').value = WTW.rgbToHex(value.r, value.g, value.b);
				WTW.setGroundWater();
			}
		});
		zpanel.addControl(zcolorpicker); 

		var zcolortitle2 = new BABYLON.GUI.TextBlock();
		zcolortitle2.text = 'Reflection Color';
		zcolortitle2.color = '#FFFFFF';
		zcolortitle2.fontSize = 20;
		zcolortitle2.height = '50px';
		zpanel.addControl(zcolortitle2);     
	
		var zcolorpicker2 = new BABYLON.GUI.ColorPicker();
		zcolorpicker2.value = new BABYLON.Color3.FromHexString(dGet('wtw_twatercolorreflection').value);
		zcolorpicker2.height = '250px';
		zcolorpicker2.width = '250px';
		zcolorpicker2.horizontalAlignment = BABYLON.GUI.Control.HORIZONTAL_ALIGNMENT_CENTER;
		zcolorpicker2.verticalAlignment = BABYLON.GUI.Control.VERTICAL_ALIGNMENT_TOP;
		zcolorpicker2.onValueChangedObservable.add(function(value) {
			if (value != null) {
				dGet('wtw_twatercolorreflection').value = WTW.rgbToHex(value.r, value.g, value.b);
				WTW.setGroundWater();
			}
		});
		zpanel.addControl(zcolorpicker2); 
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-openWaveColorSelector=' + ex.message);
	}
}

WTWJS.prototype.copyMyCommunity = async function() {
	/* make a copy of an existing 3D Community (use as backup or as a new 3D Community to edit and use) */
	try {
		dGet('wtw_tcommunityname').value = '';
		WTW.getAsyncJSON('/connect/communities.php?userid=' + dGet('wtw_tuserid').value, 
			function(zresponse) {
				WTW.communities = JSON.parse(zresponse);
				if (WTW.communities != null) {
					for (var i = 0; i < WTW.communities.length; i++) {
						if (WTW.communities[i] != null) {
							if (WTW.communities[i].communityinfo.communityid != undefined) {
								if (WTW.communities[i].communityinfo.communityid != null) {
									if (communityid == WTW.communities[i].communityinfo.communityid) {
										dGet('wtw_tcommunityname').value = WTW.decode(WTW.communities[i].communityinfo.communityname) + ' - Copy';
										var zcommunityname = WTW.encode(dGet('wtw_tcommunityname').value);
										if (zcommunityname != '') {
											WTW.copyCommunity(communityid, zcommunityname + ' - Copy');
										} else {
											WTW.copyCommunity(communityid, 'New 3D Community - Copy');
										}
									}
								}
							}
						}
					}
				}
			}
		);
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-copyMyCommunity=' + ex.message);
	}
}

WTWJS.prototype.copyCommunity = async function(zcopycommunityid, zcommunityname) {
	/* submit the copy process to the database to duplicate */
	try {
		if (zcommunityname != '' && dGet('wtw_tcommunityname').value == '') {
			dGet('wtw_tcommunityname').value = zcommunityname;
		} else if (dGet('wtw_tcommunityname').value == '') {
			dGet('wtw_tcommunityname').value = 'New 3D Community';
		}
		if (dGet('wtw_tgroundpositiony').value == '' || WTW.isNumeric(dGet('wtw_tgroundpositiony').value) == false) {
			dGet('wtw_tgroundpositiony').value = '0.00';
		}
		if (dGet('wtw_twaterpositiony').value == '' || WTW.isNumeric(dGet('wtw_twaterpositiony').value) == false) {
			dGet('wtw_twaterpositiony').value = '-1.00';
		}
		var zrequest = {
			'pastcommunityid': zcopycommunityid,
			'communityname': btoa(dGet('wtw_tcommunityname').value),
			'communitydescription': btoa(dGet('wtw_tcommunitydescription').value),
			'groundpositiony': dGet('wtw_tgroundpositiony').value,
			'waterpositiony': dGet('wtw_twaterpositiony').value,
			'alttag': '',
			'function':'savecommunity'
		};
		WTW.postAsyncJSON('/core/handlers/communities.php', zrequest, 
			function(zresponse) {
				zresponse = JSON.parse(zresponse);
				/* note serror would contain errors */
				WTW.copyCommunityComplete(zresponse.communityid);
			}
		);
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-copyCommunity=' + ex.message);
	}
}

WTWJS.prototype.copyCommunityComplete = function(zcommunityid) {
	/* copy process is complete, load new 3D Community */
	try {
		window.setTimeout(function() {
			if (zcommunityid != '' && zcommunityid != communityid) {
				window.location.href='/admin.php?communityid=' + zcommunityid + '&hmenu=25&newcommunity=1';
			}
		}, 2000);
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-copyCommunityComplete=' + ex.message);
	} 
}

WTWJS.prototype.setCommunitiesListTab = async function(zfilter) {
	/* sets the tabs classes */
	try {
		if (zfilter == undefined) {
			zfilter = 'mine';
		}
		if (zfilter == 'all' && WTW.isUserInRole('admin')) {
			if (dGet('wtw_communitybuttonmine') != null) {
				dGet('wtw_communitybuttonmine').className = 'wtw-localbutton wtw-leftradius';
				dGet('wtw_communitybuttonall').className = 'wtw-localbuttonselected wtw-rightradius';
			}
		} else {
			zfilter = 'mine';
			if (dGet('wtw_communitybuttonmine') != null) {
				dGet('wtw_communitybuttonmine').className = 'wtw-localbuttonselected wtw-leftradius';
				dGet('wtw_communitybuttonall').className = 'wtw-localbutton wtw-rightradius';
			}
		}
		WTW.getSelectCommunitiesList(zfilter);
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-setCommunitiesListTab=' + ex.message);
	} 
}

WTWJS.prototype.getSelectCommunitiesList = async function(zfilter) {
	/* populates the admin menu for My 3D Community to load and edit */
	try {
		if (zfilter == undefined) {
			zfilter = 'mine';
		}
		WTW.hide('wtw_listcommunities');
		WTW.show('wtw_loadingcommunityid');
		var zlistcommunities = '';
		if (WTW.isUserInRole('admin') || WTW.isUserInRole('developer') || WTW.isUserInRole('architect') || WTW.isUserInRole('graphic artist')) {
			zlistcommunities = "<div class='wtw-localbuttonleftpad'></div><div id='wtw_communitybuttonmine' class='wtw-localbutton";
			if (zfilter == 'mine') {
				zlistcommunities += "selected";
			}
			zlistcommunities += " wtw-leftradius' onclick=\"WTW.setCommunitiesListTab('mine');\">Mine</div><div class='wtw-localbuttonmiddlepad'> or </div><div id='wtw_communitybuttonall' class='wtw-localbutton";
			if (zfilter == 'all') {
				zlistcommunities += "selected";
			}
			zlistcommunities += " wtw-rightradius' onclick=\"WTW.setCommunitiesListTab('all');\">All</div><div class='wtw-localbuttonrightpad'></div><div class='wtw-clear'></div>\r\n";
		} else {
			zlistcommunities = '<br /><br />';
		}
		dGet('wtw_listcommunities').innerHTML = zlistcommunities;
		WTW.getAsyncJSON('/connect/communities.php?filter=' + zfilter, 
			function(zresponse) {
				WTW.communities = JSON.parse(zresponse);
				if (WTW.communities != null) {
					if (WTW.communities.length > 0) {
						var zversioncheck = [];
						for (var i = 0; i < WTW.communities.length; i++) {
							if (WTW.communities[i] != null) {
								var zversion = '';
								zversioncheck[zversioncheck.length] = {
									'webtype': 'community',
									'webname': btoa(WTW.communities[i].communityinfo.communityname),
									'webdesc': btoa(WTW.communities[i].communityinfo.communitydescription),
									'webimage': WTW.communities[i].communityinfo.snapshotpath,
									'webid': WTW.communities[i].communityinfo.communityid,
									'versionid': WTW.communities[i].communityinfo.versionid,
									'version': WTW.communities[i].communityinfo.version
								};
								if (WTW.communities[i].communityinfo.version != undefined) {
									if (WTW.communities[i].communityinfo.version != '') {
										zversion = ' (v' + WTW.communities[i].communityinfo.version + ')';
									}
								}
								if (WTW.communities[i].communityinfo.communityid == communityid) {
									dGet('wtw_listcommunities').innerHTML += "<div id='wtw_beditweb-" + WTW.communities[i].communityinfo.communityid + "' class='wtw-menulevel2' style='background-color:#2C2CAB;'><div style='float:right;color:#afafaf;'>" + zversion + "</div>" + WTW.decode(WTW.communities[i].communityinfo.communityname) + "</div>\r\n";
								} else {
									dGet('wtw_listcommunities').innerHTML += "<div id='wtw_beditweb-" + WTW.communities[i].communityinfo.communityid + "' onclick=\"window.location.href='admin.php?communityid=" + WTW.communities[i].communityinfo.communityid + "';\" class='wtw-menulevel2'><div style='float:right;color:#afafaf;'>" + zversion + "</div>" + WTW.decode(WTW.communities[i].communityinfo.communityname) + "</div>\r\n";
								}
							}
						}
						dGet('wtw_listcommunities').innerHTML += "<div class='wtw-normalgray'>Total: <b>" + WTW.communities.length + "</b> Communities</div>";
						WTW.pluginsShowListVersionCheck('community', zversioncheck);
					} else {
						dGet('wtw_listcommunities').innerHTML = "<div class='wtw-yellow'>No 3D Communities Found</div><br />";
						dGet("wtw_listcommunities").innerHTML += "<div id='wtw_adminaddcommunity2' class='wtw-adminsubmenu' onclick=\"WTW.adminMenuItemSelected(dGet('wtw_adminaddcommunity'));\">Add New 3D Community</div>";
					}
				}
				window.setTimeout(function() {
					WTW.hide('wtw_loadingcommunityid');
					WTW.show('wtw_listcommunities');
				},500);
			}
		);
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-getSelectCommunitiesList=' + ex.message);
	}		
}

WTWJS.prototype.editCommunity = function(zcommunityid) {
	/* load a select 3D Community into the editor */
	try {
		WTW.openWebpage(wtw_domainurl + '/admin.php?communityidid=' + zcommunityid);
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-editCommunity=' + ex.message);
	}
}

WTWJS.prototype.communitySearchShowCommunity = function(newcommunityid) {
	/* after you search and select a 3D Community, this loads the 3D Community in the editor */
	try {
		window.location.href='/admin.php?communityid=' + newcommunityid + '&hmenu=25&newcommunity=1';
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-communitySearchShowCommunity=' + ex.message);
	}
}

WTWJS.prototype.openShareCommunityForm = async function() {
	/* share 3D Community is used to send a copy to roomz for others to search and download copies of their own */
	try {
		dGet('wtw_tsharecommunitytempname').value = '';
		dGet('wtw_tsharecommunitydescription').value = '';
		dGet('wtw_tsharecommunitytags').value = '';
		WTW.hide('wtw_adminmenu29b');
		WTW.show('wtw_loadingsharecommunityform');
		WTW.getAsyncJSON('/connect/communities.php', 
			function(zresponse) {
				WTW.communities = JSON.parse(zresponse);
				if (WTW.communities != null) {
					for (var i = 0; i < WTW.communities.length; i++) {
						if (WTW.communities[i] != null) {
							if (WTW.communities[i].communityinfo.communityid != undefined) {
								if (WTW.communities[i].communityinfo.communityid != null) {
									if (communityid == WTW.communities[i].communityinfo.communityid) {
										var zversionid = communityid;
										var zversion = '1.0.0';
										var zversiondesc = 'Initial Version';
										var zcreateuserid = '';
										if (WTW.communities[i].communityinfo.versionid != undefined) {
											if (WTW.communities[i].communityinfo.versionid != '') {
												zversionid = WTW.communities[i].communityinfo.versionid;
											}
										}
										if (WTW.communities[i].communityinfo.version != undefined) {
											if (WTW.communities[i].communityinfo.version != '') {
												zversion = WTW.communities[i].communityinfo.version;
											}
										}
										if (WTW.communities[i].communityinfo.versiondesc != undefined) {
											if (WTW.communities[i].communityinfo.versiondesc != '') {
												zversiondesc = WTW.communities[i].communityinfo.versiondesc;
											}
										}
										if (WTW.communities[i].communityinfo.createuserid != undefined) {
											if (WTW.communities[i].communityinfo.createuserid != '') {
												zcreateuserid = WTW.communities[i].communityinfo.createuserid;
											}
										}
										if (WTW.communities[i].share.templatename != '') {
											dGet('wtw_tsharecommunitytempname').value = WTW.communities[i].share.templatename;
										} else {
											dGet('wtw_tsharecommunitytempname').value = WTW.communities[i].communityinfo.communityname;
										}
										dGet('wtw_tsharecommunitydescription').value = WTW.communities[i].share.description;
										dGet('wtw_tsharecommunitytags').value = WTW.communities[i].share.tags;
										if (WTW.communities[i].communityinfo.snapshotpath != '') {
											dGet('wtw_defaultcommunitysnapshot').src = WTW.communities[i].communityinfo.snapshotpath;
										} else {
											dGet('wtw_defaultcommunitysnapshot').src = WTW.communities[i].communityinfo.snapshotdata;
										}
										dGet('wtw_tsharecommunityversion').value = zversion;
										dGet('wtw_tsharecommunityversiondesc').value = zversiondesc;
										dGet('wtw_tsharecommunityoriginal').checked = true;
										dGet('wtw_tsharecommunityversion').disabled = true;
										dGet('wtw_tsharecommunityversiondesc').disabled = true;
										dGet('wtw_tsharecommunityoriginal').onchange = function() { WTW.changeWebVersion('community', zversion, zversiondesc);};
										dGet('wtw_tsharecommunityupdate').onchange = function() { WTW.changeWebVersion('community', zversion, zversiondesc);};
										if (dGet('wtw_tuserid').value == zcreateuserid && zcreateuserid != '') {
											dGet('wtw_tsharecommunityupdate').disabled = false;
										} else {
											dGet('wtw_tsharecommunityupdate').disabled = true;
										}
									}
								}
							}
						}
					}
				}
				if (dGet('wtw_defaultcommunitysnapshot').src.length < 20) {
					WTW.hide('wtw_defaultcommunitysnapshot');
				} else {
					WTW.show('wtw_defaultcommunitysnapshot');
				}
				WTW.hide('wtw_loadingsharecommunityform');
				WTW.show('wtw_adminmenu29b');
				WTW.setWindowSize();
			}
		);
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-openShareCommunityForm=' + ex.message);
	}
}		

WTWJS.prototype.changeWebVersion = function(zwebtype, zversion, zversiondesc) {
	/* change when initial share or update share is selected on Share 3D Avatar Form */
	try {
		if (dGet('wtw_tshare' + zwebtype + 'original') != null) {
			if (dGet('wtw_tshare' + zwebtype + 'original').checked == true) {
				dGet('wtw_tshare' + zwebtype + 'version').value = '1.0.0';
				dGet('wtw_tshare' + zwebtype + 'versiondesc').value = 'Initial Version';
				dGet('wtw_tshare' + zwebtype + 'version').disabled = true;
				dGet('wtw_tshare' + zwebtype + 'versiondesc').disabled = true;
				WTW.hide('wtw_tshare' + zwebtype + 'div');
			} else {
				dGet('wtw_tshare' + zwebtype + 'version').disabled = false;
				dGet('wtw_tshare' + zwebtype + 'versiondesc').disabled = false;
				dGet('wtw_tshare' + zwebtype + 'version').value = zversion;
				dGet('wtw_tshare' + zwebtype + 'versiondesc').value = zversiondesc;
				WTW.show('wtw_tshare' + zwebtype + 'div');
			}
		}
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-changeWebVersion=' + ex.message);
	} 
}


/* 3D Scene Settings */

/* ground Terrain */
WTWJS.prototype.openAddGroundTerrain = function() {
	/* add terrain and height map generated molds */
	try {
		var zmoldind = WTW.getNextCount(WTW.communitiesMolds);
		WTW.communitiesMolds[zmoldind] = WTW.newMold();
		var zshape = 'terrain';
		var zmoldid = WTW.getRandomString(16);
		var zsettingx = 700;
		var zsettingz = 800;
		var zpositionx = 0;
		var zpositiony = -1;
		var zpositionz = 0;
		var zrotationx = 0;
		var zrotationy = 0;
		var zrotationz = 0;
		var znewcoords = WTW.getNewCoordinates(500);
		zpositionx = znewcoords.positionX;
		zpositionz = znewcoords.positionZ;
		zrotationy = znewcoords.rotationY;
		WTW.communitiesMolds[zmoldind].moldid = zmoldid;
		WTW.communitiesMolds[zmoldind].moldind = zmoldind;
		WTW.communitiesMolds[zmoldind].communityinfo.communityid = communityid;
		WTW.communitiesMolds[zmoldind].communityinfo.communityind = '-1';
		WTW.communitiesMolds[zmoldind].position.x = zpositionx;
		WTW.communitiesMolds[zmoldind].position.y = zpositiony;
		WTW.communitiesMolds[zmoldind].position.z = zpositionz;
		WTW.communitiesMolds[zmoldind].scaling.x = zsettingx;
		WTW.communitiesMolds[zmoldind].scaling.y = 1;
		WTW.communitiesMolds[zmoldind].scaling.z = zsettingz;
		WTW.communitiesMolds[zmoldind].rotation.x = zrotationx;
		WTW.communitiesMolds[zmoldind].rotation.y = zrotationy;
		WTW.communitiesMolds[zmoldind].rotation.z = zrotationz;
		WTW.communitiesMolds[zmoldind].graphics.texture.id = 'p3a7548r37pzqpev';
		WTW.communitiesMolds[zmoldind].graphics.heightmap.id = 'dxmbplwoocpg5df3';
		WTW.communitiesMolds[zmoldind].graphics.heightmap.minheight = 0;
		WTW.communitiesMolds[zmoldind].graphics.heightmap.maxheight = 70;
		WTW.communitiesMolds[zmoldind].graphics.uscale = zsettingx / 10
		WTW.communitiesMolds[zmoldind].graphics.vscale = zsettingz / 10
		WTW.communitiesMolds[zmoldind].subdivisions = 70;
		WTW.communitiesMolds[zmoldind].shape = zshape;
		WTW.communitiesMolds[zmoldind].covering = 'terrain';
		WTW.communitiesMolds[zmoldind].checkcollisions = '1';
		WTW.communitiesMolds[zmoldind].ispickable = '1';	
		WTW.communitiesMolds[zmoldind].loadactionzoneid = WTW.getLoadActionZoneID('Extreme');		
		WTW.communitiesMolds[zmoldind].loadactionzoneind = WTW.getActionZoneInd(WTW.communitiesMolds[zmoldind].loadactionzoneid, Number(dGet('wtw_tconnectinggridind').value));
		WTW.communitiesMolds[zmoldind].unloadactionzoneid = '';		
		WTW.communitiesMolds[zmoldind].unloadactionzoneind = -1;
		WTW.communitiesMolds[zmoldind].connectinggridind = Number(dGet('wtw_tconnectinggridind').value);		
		WTW.communitiesMolds[zmoldind].connectinggridid = dGet('wtw_tconnectinggridid').value;		
		WTW.communitiesMolds[zmoldind].parentname = dGet('wtw_tconnectinggridname').value;		
		WTW.communitiesMolds[zmoldind].moldname = 'local-communitymolds-' + zmoldind + '-' + zmoldid + '-' + dGet('wtw_tconnectinggridind').value + '-' + dGet('wtw_tconnectinggridid').value + '-' + zshape;		
		var zimageinfo = WTW.getUploadFileData('fcg9ws5gsjd7x2ko');
		var zimageinfo2 = WTW.getUploadFileData('rb89jzbm4qepbimm');
		dGet('wtw_moldheightmappreview').src = zimageinfo2.filedata;
		WTW.openMoldForm(zmoldind, 'terrain', 'community', false);
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-openAddGroundTerrain=' + ex.message);
	}		
}

WTWJS.prototype.openEditGroundSettings = function() {
	/* edit extended ground texture settings */
	try {
		var zgroundtextureid = WTW.init.groundTextureID;
		var zgroundtexturepath = WTW.init.groundTexturePath;
		WTW.hide('wtw_adminmenu41b');
		WTW.show('wtw_loadinggroundsettingsform');
		for (var i = 0; i < WTW.communities.length; i++) {
			if (WTW.communities[i] != null) {
				if (WTW.communities[i].communityinfo.communityid == communityid) {
					if (WTW.communities[i].graphics.texture.id != null) {
						if (WTW.communities[i].graphics.texture.backupid == '') {
							WTW.communities[i].graphics.texture.backupid = WTW.communities[i].graphics.texture.id;
						}
						zgroundtextureid = WTW.communities[i].graphics.texture.id;
					}
					if (WTW.communities[i].graphics.texture.path != null) {
						if (WTW.communities[i].graphics.texture.backuppath == '') {
							WTW.communities[i].graphics.texture.backuppath = WTW.communities[i].graphics.texture.path;
						}
						zgroundtexturepath = WTW.communities[i].graphics.texture.path;
					}
				}
			}
		}
		WTW.hide('wtw_loadinggroundsettingsform');
		WTW.show('wtw_adminmenu41b');
		dGet('wtw_textendedgroundtextureid').value = zgroundtextureid;
		dGet('wtw_textendedgroundtexturepath').value = zgroundtexturepath;
		WTW.setPreviewImage('wtw_showextendedgroundpreview', 'wtw_textendedgroundtexturepath', 'wtw_textendedgroundtextureid');
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-openEditGroundSettings=' + ex.message);
	}		
}

WTWJS.prototype.saveGround = async function() {
	/* save extended ground texture settings */
	try {
		var zgroundtextureid = WTW.init.groundTextureID;
		var zgroundtexturepath = WTW.init.groundTexturePath;
		if (dGet('wtw_textendedgroundtextureid').value != '') {
			zgroundtextureid = dGet('wtw_textendedgroundtextureid').value;
		}
		if (dGet('wtw_textendedgroundtexturepath').value != '') {
			zgroundtexturepath = dGet('wtw_textendedgroundtexturepath').value;
		}
		for (var i = 0; i < WTW.communities.length; i++) {
			if (WTW.communities[i] != null) {
				if (WTW.communities[i].communityinfo.communityid == communityid) {
					if (WTW.communities[i].graphics.texture.id != null) {
						WTW.communities[i].graphics.texture.backupid = '';
						WTW.communities[i].graphics.texture.id = zgroundtextureid;
					}
					if (WTW.communities[i].graphics.texture.path != null) {
						WTW.communities[i].graphics.texture.backuppath = '';
						WTW.communities[i].graphics.texture.path = zgroundtexturepath;
					}
				}
			}
		}
		var zrequest = {
			'communityid': communityid,
			'groundtextureid': zgroundtextureid,
			'function':'saveextendedground'
		};
		WTW.postAsyncJSON('/core/handlers/communities.php', zrequest, 
			function(zresponse) {
				zresponse = JSON.parse(zresponse);
				/* note serror would contain errors */
			}
		);
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-saveGround=' + ex.message);
	}		
}

WTWJS.prototype.cancelGround = function() {
	/* cancel and undo extended ground texture settings */
	try {
		var zgroundtextureid = WTW.init.groundTextureID;
		var zgroundtexturepath = WTW.init.groundTexturePath;
		for (var i = 0; i < WTW.communities.length; i++) {
			if (WTW.communities[i] != null) {
				if (WTW.communities[i].communityinfo.communityid == communityid) {
					if (WTW.communities[i].graphics.texture.id != null) {
						if (WTW.communities[i].graphics.texture.backupid != '') {
							WTW.communities[i].graphics.texture.id = WTW.communities[i].graphics.texture.backupid;
							WTW.communities[i].graphics.texture.backupid = '';
						}
						zgroundtextureid = WTW.communities[i].graphics.texture.id;
						if (WTW.communities[i].graphics.texture.backuppath != '') {
							WTW.communities[i].graphics.texture.path = WTW.communities[i].graphics.texture.backuppath;
							WTW.communities[i].graphics.texture.backuppath = '';
						}
						zgroundtexturepath = WTW.communities[i].graphics.texture.path;
					}
				}
			}
		}
		dGet('wtw_textendedgroundtextureid').value = zgroundtextureid;
		dGet('wtw_textendedgroundtexturepath').value = zgroundtexturepath;
		WTW.setPreviewImage('wtw_showextendedgroundpreview', 'wtw_textendedgroundtexturepath', 'wtw_textendedgroundtextureid');
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-cancelGround=' + ex.message);
	}		
}

/* sky dome */
WTWJS.prototype.openSkyDomeForm = function() {
	/* edit sky dome appearance */
	/* this sky dome uses sky procedure texture */
	try {
		var zskydomeid = WTW.init.skyTextureID;
		WTW.hide('wtw_adminmenu40b');
		WTW.show('wtw_loadingskysettingsform');
		WTW.loadSkyScene(WTW.init.skyInclination, WTW.init.skyLuminance, WTW.init.skyAzimuth, WTW.init.skyRayleigh, WTW.init.skyTurbidity, WTW.init.skyMieDirectionalG, WTW.init.skyMieCoefficient, 1);
		dGet('wtw_tskyinclinationbackup').value = WTW.init.skyInclination;
		dGet('wtw_tskyluminancebackup').value = WTW.init.skyLuminance;
		dGet('wtw_tskyazimuthbackup').value = WTW.init.skyAzimuth;
		dGet('wtw_tskyrayleighbackup').value = WTW.init.skyRayleigh;
		dGet('wtw_tskyturbiditybackup').value = WTW.init.skyTurbidity;
		dGet('wtw_tskymiedirectionalgbackup').value = WTW.init.skyMieDirectionalG;
		dGet('wtw_tskymiecoefficientbackup').value = WTW.init.skyMieCoefficient;
		for (var i = 0; i < WTW.communities.length; i++) {
			if (WTW.communities[i] != null) {
				if (WTW.communities[i].communityinfo.communityid == communityid) {
					if (WTW.communities[i].graphics.sky.id != null) {
						if (WTW.communities[i].graphics.sky.backupid == '') {
							WTW.communities[i].graphics.sky.backupid = WTW.communities[i].graphics.sky.id;
						}
						zskydomeid = WTW.communities[i].graphics.sky.id;
					}
				}
			}
		}
		WTW.hide('wtw_loadingskysettingsform');
		WTW.show('wtw_adminmenu40b');
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-openSkyDomeForm=' + ex.message);
	}
}

WTWJS.prototype.setSkyScene = function (zkey, znewvalue, zincrement) {
	/* set sky dome based on form settings (one value at a time updates) */
	try {
		var zfield = '';
		var zmin = 0;
		var zmax = 1;
		switch (zkey) {
			case 'inclination':
				zfield = 'wtw_tskyinclination';
				if (znewvalue == null) {
					zmin = Number(dGet(zfield).min) - .6;
					zmax = Number(dGet(zfield).max) - .6;
					znewvalue = (Number(WTW.init.skyInclination) + zincrement).toFixed(2);
					if (znewvalue < zmin) {
						znewvalue = zmin;
					} else if (znewvalue > zmax) {
						znewvalue = zmax;
					} 
				} else {
					znewvalue = Number(znewvalue) - .6;
				}
				WTW.init.skyInclination = Number(znewvalue).toFixed(2);
				break;
			case 'luminance':
				zfield = 'wtw_tskyluminance';
				if (znewvalue == null) {
					zmin = Number(dGet(zfield).min);
					zmax = Number(dGet(zfield).max);
					znewvalue = (Number(WTW.init.skyLuminance) + zincrement).toFixed(2);
					if (znewvalue < zmin) {
						znewvalue = zmin;
					} else if (znewvalue > zmax) {
						znewvalue = zmax;
					} 
				}
				WTW.init.skyLuminance = Number(znewvalue).toFixed(2);
				break;
			case 'azimuth':
				zfield = 'wtw_tskyazimuth';
				if (znewvalue == null) {
					zmin = Number(dGet(zfield).min);
					zmax = Number(dGet(zfield).max);
					znewvalue = (Number(WTW.init.skyAzimuth) + zincrement).toFixed(2);
					if (znewvalue < zmin) {
						znewvalue = zmin;
					} else if (znewvalue > zmax) {
						znewvalue = zmax;
					} 
				}
				WTW.init.skyAzimuth = Number(znewvalue).toFixed(2);
				break;
			case 'rayleigh':
				zfield = 'wtw_tskyrayleigh';
				if (znewvalue == null) {
					zmin = Number(dGet(zfield).min);
					zmax = Number(dGet(zfield).max);
					znewvalue = (Number(WTW.init.skyRayleigh) + zincrement).toFixed(2);
					if (znewvalue < zmin) {
						znewvalue = zmin;
					} else if (znewvalue > zmax) {
						znewvalue = zmax;
					} 
				}
				WTW.init.skyRayleigh = Number(znewvalue).toFixed(2);
				break;
			case 'turbidity':
				zfield = 'wtw_tskyturbidity';
				if (znewvalue == null) {
					zmin = Number(dGet(zfield).min);
					zmax = Number(dGet(zfield).max);
					znewvalue = (Number(WTW.init.skyTurbidity) + zincrement).toFixed(0);
					if (znewvalue < zmin) {
						znewvalue = zmin;
					} else if (znewvalue > zmax) {
						znewvalue = zmax;
					} 
				}
				WTW.init.skyTurbidity = Number(znewvalue).toFixed(0);
				break;
			case 'miedirectionalg':
				zfield = 'wtw_tskymiedirectionalg';
				if (znewvalue == null) {
					zmin = Number(dGet(zfield).min);
					zmax = Number(dGet(zfield).max);
					znewvalue = (Number(WTW.init.skyMieDirectionalG) + zincrement).toFixed(2);
					if (znewvalue < zmin) {
						znewvalue = zmin;
					} else if (znewvalue > zmax) {
						znewvalue = zmax;
					} 
				}
				WTW.init.skyMieDirectionalG = Number(znewvalue).toFixed(2);
				break;
			case 'miecoefficient':
				zfield = 'wtw_tskymiecoefficient';
				if (znewvalue == null) {
					zmin = Number(dGet(zfield).min);
					zmax = Number(dGet(zfield).max);
					znewvalue = (Number(WTW.init.skyMieCoefficient) + zincrement).toFixed(3);
					if (znewvalue < zmin) {
						znewvalue = zmin;
					} else if (znewvalue > zmax) {
						znewvalue = zmax;
					} 
				}
				WTW.init.skyMieCoefficient = Number(znewvalue).toFixed(3);
				break;
		}
		WTW.loadSkyScene(WTW.init.skyInclination, WTW.init.skyLuminance, WTW.init.skyAzimuth, WTW.init.skyRayleigh, WTW.init.skyTurbidity, WTW.init.skyMieDirectionalG, WTW.init.skyMieCoefficient, 1);
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-setSkyScene=' + ex.message);
	}  
}

WTWJS.prototype.cancelSkyDome = function() {
	/* cancel and undo sky dome form changes */
	try {
		var zskydomeid = WTW.init.skyTextureID;
		WTW.init.skyInclination = dGet('wtw_tskyinclinationbackup').value;
		WTW.init.skyLuminance = dGet('wtw_tskyluminancebackup').value;
		WTW.init.skyAzimuth = dGet('wtw_tskyazimuthbackup').value;
		WTW.init.skyRayleigh = dGet('wtw_tskyrayleighbackup').value;
		WTW.init.skyTurbidity = dGet('wtw_tskyturbiditybackup').value;
		WTW.init.skyMieDirectionalG = dGet('wtw_tskymiedirectionalgbackup').value;
		WTW.init.skyMieCoefficient = dGet('wtw_tskymiecoefficientbackup').value;
		WTW.loadSkyScene(WTW.init.skyInclination, WTW.init.skyLuminance, WTW.init.skyAzimuth, WTW.init.skyRayleigh, WTW.init.skyTurbidity, WTW.init.skyMieDirectionalG, WTW.init.skyMieCoefficient, 1);
		for (var i = 0; i < WTW.communities.length; i++) {
			if (WTW.communities[i] != null) {
				if (WTW.communities[i].communityinfo.communityid == communityid) {
					if (WTW.communities[i].graphics.sky.id != null) {
						if (WTW.communities[i].graphics.sky.backupid != '') {
							WTW.communities[i].graphics.sky.id = WTW.communities[i].graphics.sky.backupid;
							WTW.communities[i].graphics.sky.backupid = '';
						}
					}
					zskydomeid = WTW.communities[i].graphics.sky.id;
				}
			}
		}
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-cancelSkyDome=' + ex.message);
	}
}

WTWJS.prototype.saveSkyDome = async function() {
	/* save skydome sky changes */
	try {
		var zskydomeid = WTW.init.skyTextureID;
		if (dGet('wtw_tskydomeid').value != '') {
			zskydomeid = dGet('wtw_tskydomeid').value;
		}
		for (var i = 0; i < WTW.communities.length; i++) {
			if (WTW.communities[i] != null) {
				if (WTW.communities[i].communityinfo.communityid == communityid) {
					if (WTW.communities[i].graphics.sky.id != null) {
						WTW.communities[i].graphics.sky.backupid = '';
						WTW.communities[i].graphics.sky.id = zskydomeid;
					}
				}
			}
		}
		var zrequest = {
			'communityid': communityid,
			'skydomeid': zskydomeid,
			'skyinclination': WTW.init.skyInclination,
			'skyluminance': WTW.init.skyLuminance,
			'skyazimuth': WTW.init.skyAzimuth,
			'skyrayleigh': WTW.init.skyRayleigh,
			'skyturbidity': WTW.init.skyTurbidity,
			'skymiedirectionalg': WTW.init.skyMieDirectionalG,
			'skymiecoefficient': WTW.init.skyMieCoefficient,
			'function':'saveskydome'
		};
		WTW.postAsyncJSON('/core/handlers/communities.php', zrequest, 
			function(zresponse) {
				zresponse = JSON.parse(zresponse);
				/* note serror would contain errors */
			}
		);
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-saveSkyDome=' + ex.message);
	}
}

/* 3D Community Scene gravity */
WTWJS.prototype.saveGravity = async function() {
	/* save community gravity (applies to scene when loaded) */
	try {
		if (communityid != '') {
			var zrequest = {
				'communityid': communityid,
				'gravity':WTW.init.gravity,
				'function':'savegravity'
			};
			WTW.postAsyncJSON('/core/handlers/communities.php', zrequest, 
				function(zresponse) {
					zresponse = JSON.parse(zresponse);
					/* note serror would contain errors */
				}
			);
		} else if (buildingid != '') {
			var zrequest = {
				'buildingid': buildingid,
				'gravity':WTW.init.gravity,
				'function':'savegravity'
			};
			WTW.postAsyncJSON('/core/handlers/buildings.php', zrequest, 
				function(zresponse) {
				}
			);
		} else if (thingid != '') {
			var zrequest = {
				'thingid': thingid,
				'gravity':WTW.init.gravity,
				'function':'savegravity'
			};
			WTW.postAsyncJSON('/core/handlers/things.php', zrequest, 
				function(zresponse) {
					zresponse = JSON.parse(zresponse);
					/* note serror would contain errors */
				}
			);
		}		
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-saveGravity=' + ex.message);
	}
}

WTWJS.prototype.setGravity = function() {
	/* set gravity based on form */
	try {
		if (WTW.isNumeric(dGet('wtw_tcommgravity').value)) {
			if (Number(dGet('wtw_tcommgravity').value) != 0) {
				scene.gravity = new BABYLON.Vector3(0, -Number(dGet('wtw_tcommgravity').value), 0);
			} else {
				scene.gravity = new BABYLON.Vector3(0, 0, 0);
			}
		} else {
			scene.gravity = new BABYLON.Vector3(0, 0, 0);
		}
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-setGravity=' + ex.message);
	}
}

/* ground level - creates water if below 0 (zero) */
WTWJS.prototype.setGroundWater = function() {
	/* set ground level and water settings from form */
	try {
		if (communityid != '') {
			var zgroundpositiony = 0;
			var zwaterpositiony = -50;
			var zwatercolorrefraction = '#23749C';
			var zwatercolorreflection = '#52BCF1';

			if (WTW.isNumeric(dGet('wtw_tgroundpositiony').value)) {
				zgroundpositiony = Number(dGet('wtw_tgroundpositiony').value);
			}
			if (zgroundpositiony > 0) {
				zgroundpositiony = 0;
				dGet('wtw_tgroundpositiony').value = '0.00';
			}
			if (zgroundpositiony != 0) {
				zwaterpositiony = 0;
			}
			if (WTW.extraGround != null) {
				WTW.extraGround.position.y = zgroundpositiony;
			}
			if (WTW.water != null) {

				if (dGet('wtw_twaterbumppath').value == '') {
					dGet('wtw_twaterbumppath').value = '/content/system/images/waterbump.png';
				}
				if (WTW.water != null) {
					WTW.water.material.dispose();
					WTW.water.dispose();
					WTW.water = null;
				}
				/* create water */
				if (WTW.isNumeric(dGet('wtw_twatersubdivisions').value)) {
					if (Number(dGet('wtw_twatersubdivisions').value) < 2) {
						dGet('wtw_twatersubdivisions').value = 2;
					}
				} else {
					dGet('wtw_twatersubdivisions').value = 2;
				}
			
				WTW.water = BABYLON.Mesh.CreateGround('communitywater', 5000, 5000, Math.round(Number(dGet('wtw_twatersubdivisions').value)), scene, false);
			
				WTW.waterMat = new BABYLON.WaterMaterial('communitywatermat', scene, new BABYLON.Vector2(512, 512));
				WTW.waterMat.bumpTexture = new BABYLON.Texture(dGet('wtw_twaterbumppath').value, scene);
				WTW.water.position.y = zwaterpositiony;
				WTW.init.waterBumpPath = dGet('wtw_twaterbumppath').value;
				WTW.init.waterSubdivisions = dGet('wtw_twatersubdivisions').value;
				if (WTW.isNumeric(dGet('wtw_twaterbumpheight').value)) {
					if (Number(dGet('wtw_twaterbumpheight').value) < 0) {
						dGet('wtw_twaterbumpheight').value = 0;
					}
					WTW.waterMat.bumpHeight = Number(dGet('wtw_twaterbumpheight').value);
				} else {
					WTW.waterMat.bumpHeight = 0;
				}
				if (WTW.isHexColor(dGet('wtw_twatercolorrefraction').value)) {
					zwatercolorrefraction = dGet('wtw_twatercolorrefraction').value;
				}
				if (WTW.isHexColor(dGet('wtw_twatercolorreflection').value)) {
					zwatercolorreflection = dGet('wtw_twatercolorreflection').value;
				}
				WTW.waterMat.waterColor = new BABYLON.Color3.FromHexString(zwatercolorrefraction); 
				/* water color blended with the refraction (near) */
				WTW.waterMat.waterColor2 = new BABYLON.Color3.FromHexString(zwatercolorreflection); 
				/* water color blended with the reflection (far) */
				if (WTW.isNumeric(dGet('wtw_twatercolorblendfactor').value)) {
					if (Number(dGet('wtw_twatercolorblendfactor').value) < 0) {
						dGet('wtw_twatercolorblendfactor').value = 0;
					} else if (Number(dGet('wtw_twatercolorblendfactor').value) > 10) {
						dGet('wtw_twatercolorblendfactor').value = 10;
					}
					WTW.waterMat.colorBlendFactor = Number(dGet('wtw_twatercolorblendfactor').value);
				} else {
					WTW.waterMat.colorBlendFactor = .2;
				}
				if (WTW.isNumeric(dGet('wtw_twatercolorblendfactor2').value)) {
					if (Number(dGet('wtw_twatercolorblendfactor2').value) < 0) {
						dGet('wtw_twatercolorblendfactor2').value = 0;
					} else if (Number(dGet('wtw_twatercolorblendfactor2').value) > 10) {
						dGet('wtw_twatercolorblendfactor2').value = 10;
					}
					WTW.waterMat.colorBlendFactor2 = Number(dGet('wtw_twatercolorblendfactor2').value);
				} else {
					WTW.waterMat.colorBlendFactor2 = .2;
				}
				if (WTW.isNumeric(dGet('wtw_twaterwindforce').value)) {
					WTW.waterMat.windForce = dGet('wtw_twaterwindforce').value;
				} else {
					WTW.waterMat.windForce = -10;
				}
				if (WTW.isNumeric(dGet('wtw_twaterwinddirectionx').value) && WTW.isNumeric(dGet('wtw_twaterwinddirectionz').value)) {
					if (Number(dGet('wtw_twaterwinddirectionx').value) < -1) {
						dGet('wtw_twaterwinddirectionx').value = -1;
					} else if (Number(dGet('wtw_twaterwinddirectionx').value) > 1) {
						dGet('wtw_twaterwinddirectionx').value = 1;
					}
					if (Number(dGet('wtw_twaterwinddirectionz').value) < -1) {
						dGet('wtw_twaterwinddirectionz').value = -1;
					} else if (Number(dGet('wtw_twaterwinddirectionz').value) > 1) {
						dGet('wtw_twaterwinddirectionz').value = 1;
					}
					WTW.waterMat.windDirection = new BABYLON.Vector2(Number(dGet('wtw_twaterwinddirectionx').value), Number(dGet('wtw_twaterwinddirectionz').value));
				} else {
					WTW.waterMat.windDirection = new BABYLON.Vector2(1, 1);
				}
				if (WTW.isNumeric(dGet('wtw_twaterwaveheight').value)) {
					if (Number(dGet('wtw_twaterwaveheight').value) < 0) {
						dGet('wtw_twaterwaveheight').value = 0;
					}
					WTW.waterMat.waveHeight = Number(dGet('wtw_twaterwaveheight').value);
				} else {
					WTW.waterMat.waveHeight = .2;
				}
				if (WTW.isNumeric(dGet('wtw_twaterwavelength').value)) {
					if (Number(dGet('wtw_twaterwavelength').value) < 0) {
						dGet('wtw_twaterwavelength').value = 0;
					}
					WTW.waterMat.waveLength = Number(dGet('wtw_twaterwavelength').value);	
				} else {
					WTW.waterMat.waveLength = .02;	
				}
				if (WTW.isNumeric(dGet('wtw_twateralpha').value)) {
					if (Number(dGet('wtw_twateralpha').value) < 0) {
						dGet('wtw_twateralpha').value = 0;
					} else if (Number(dGet('wtw_twateralpha').value) > 100) {
						dGet('wtw_twateralpha').value = 100;
					}
					WTW.waterMat.alpha = Number(dGet('wtw_twateralpha').value) / 100;
				} else {
					WTW.waterMat.alpha = .9;
				}
				WTW.waterMat.backFaceCulling = true;
				WTW.water.isPickable = false;
				WTW.water.checkCollisions = false;
				WTW.water.material = WTW.waterMat;
				WTW.waterMat.addToRenderList(WTW.sky);
				WTW.waterMat.addToRenderList(WTW.extraGround);
			}
			dGet('wtw_twaterpositiony').value = zwaterpositiony;
		}
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-setGroundWater=' + ex.message);
	}
}


/* Common functions for 3D Communities, 3D Buildings, and 3D Things */

/* confirmation pages before executing a command */
WTWJS.prototype.openConfirmation = function(zoption) {
	/* open confirmation box with warning */
	try {
		WTW.showInline('wtw_confirmform');
		dGet('wtw_confirmform').style.top = (WTW.getScrollY() + 150).toString() + 'px';
		WTW.showInline('wtw_greyout');
		dGet('wtw_tconfirmid').value = zoption;
		switch (zoption) {
			case 'Delete 3D Community':
				dGet('wtw_confirmformtitle').innerHTML = 'Confirm Delete 3D Community';
				dGet('wtw_confirmheading').innerHTML = 'Are you sure you want to Delete the 3D Community?';
				dGet('wtw_confirmtext').innerHTML = '<br />Deleting the Community will also Delete all Terrain, Building Placements, Walls, Floors, and Web Components.';
				dGet('wtw_bconfirm').value = 'Delete 3D Community';
				break;
			case 'Delete 3D Building':
				dGet('wtw_confirmformtitle').innerHTML = 'Confirm Delete 3D Building';
				dGet('wtw_confirmheading').innerHTML = 'Are you sure you want to Delete the 3D Building?';
				dGet('wtw_confirmtext').innerHTML = '<br />Deleting the Building will Delete all Walls, Floors, and Web Components. It will also remove it from all <b>3D Communities</b>!';
				dGet('wtw_bconfirm').value = 'Delete 3D Building';
				break;
			case 'Delete Building from this Community':
				dGet('wtw_confirmformtitle').innerHTML = 'Confirm Delete Building from this Community';
				dGet('wtw_confirmheading').innerHTML = 'Are you sure you want to Delete the Building from this Community?';
				dGet('wtw_confirmtext').innerHTML = '<br />The building can always be added again if you change your mind.';
				dGet('wtw_bconfirm').value = 'Delete 3D Building from 3D Community';
				break;
			case 'Delete 3D Thing':
				dGet('wtw_confirmformtitle').innerHTML = 'Confirm Delete 3D Thing';
				dGet('wtw_confirmheading').innerHTML = 'Are you sure you want to Delete the 3D Thing?';
				dGet('wtw_confirmtext').innerHTML = '<br />Deleting the 3D Thing will also Delete all parts including Shapes and Web Components.';
				dGet('wtw_bconfirm').value = 'Delete 3D Thing';
				break;
			case 'Delete 3D Avatar':
				dGet('wtw_confirmformtitle').innerHTML = 'Confirm Delete 3D Avatar';
				dGet('wtw_confirmheading').innerHTML = 'Are you sure you want to Delete the 3D Avatar?';
				dGet('wtw_confirmtext').innerHTML = '<br />Deleting the 3D Avatar will also Delete all parts including Animations.';
				dGet('wtw_bconfirm').value = 'Delete 3D Avatar';
				break;
			case 'Permanently Delete 3D Model':
				dGet('wtw_confirmformtitle').innerHTML = 'Confirm Permanently Delete 3D Model';
				dGet('wtw_confirmheading').innerHTML = 'Are you sure you want to Delete this 3D Model?';
				dGet('wtw_confirmtext').innerHTML = '<br />This will delete the record and related 3D Model files on the server if they are no longer in use by other 3D Models. This cannot be undone once Permanently Deleted.';
				dGet('wtw_bconfirm').value = 'Permanently Delete My 3D Model';
				break;
		}
		WTW.pluginsOpenConfirmation(zoption);
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-openConfirmation=' + ex.message);
	}
}

WTWJS.prototype.completedConfirmation = function(zoption) {
	/* if confirmed, continue to process */
	try {
		switch (zoption) {
			case 'Delete 3D Community':
				WTW.submitCommunityForm(0);
				break;
			case 'Delete 3D Building':
				WTW.submitBuildingForm(0);
				break;
			case 'Delete Building from this Community':
				WTW.submitConnectingGridsForm(0);
				break;
			case 'Delete 3D Thing':
				WTW.submitthingForm(0);
				break;
			case 'Delete 3D Avatar':
				WTW.deleteAvatar(0);
				break;
			case 'Permanently Delete 3D Model':
				WTW.deleteUploadObject(dGet('wtw_tgroupuploadobjectid').value,1);
				dGet('wtw_tgroupuploadobjectid').value = '';
				break;
		}
		WTW.pluginsCompletedConfirmation(zoption);
		WTW.closeConfirmation();
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-completedConfirmation=' + ex.message);
	}
}

WTWJS.prototype.closeConfirmation = function(zoption) {
	/* close confirmation box */
	try {
		WTW.hide('wtw_confirmform');
		WTW.hide('wtw_greyout');
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-closeConfirmation=' + ex.message);
	}
}

/* start position */
WTWJS.prototype.setStartPosition = async function(zcommunityid, zbuildingid, zthingid) {
	/* sets start position for 3D Commuity, 3D Building, or 3D Thing */
	try {
		if (WTW.myAvatar!= null) {
			if (zcommunityid != '') {
				var zrequest = {
					'communityid': zcommunityid,
					'positionx': WTW.myAvatar.position.x,
					'positiony': WTW.myAvatar.position.y,
					'positionz': WTW.myAvatar.position.z,
					'scalingx': 1,
					'scalingy': 1,
					'scalingz': 1,
					'rotationx': WTW.cameraYOffset,
					'rotationy': WTW.getDegrees(WTW.myAvatar.rotation.y),
					'rotationz': WTW.getDegrees(WTW.myAvatar.rotation.z),
					'function':'savestartposition'
				};
				WTW.postAsyncJSON('/core/handlers/communities.php', zrequest, 
					function(zresponse) {
						zresponse = JSON.parse(zresponse);
						/* note serror would contain errors */
						dGet('wtw_startsaved').style.visibility = 'visible';
						window.setTimeout(function(){
							dGet('wtw_startsaved').style.visibility = 'hidden';
						}, 3000);
					}
				);
			} else if (zbuildingid != '') {
				var zrequest = {
					'buildingid': zbuildingid,
					'positionx': WTW.myAvatar.position.x,
					'positiony': WTW.myAvatar.position.y,
					'positionz': WTW.myAvatar.position.z,
					'scalingx': 1,
					'scalingy': 1,
					'scalingz': 1,
					'rotationx': WTW.cameraYOffset,
					'rotationy': WTW.getDegrees(WTW.myAvatar.rotation.y),
					'rotationz': WTW.getDegrees(WTW.myAvatar.rotation.z),
					'function':'savestartposition'
				};
				WTW.postAsyncJSON('/core/handlers/buildings.php', zrequest, 
					function(zresponse) {
						dGet('wtw_startsaved').style.visibility = 'visible';
						window.setTimeout(function(){
							dGet('wtw_startsaved').style.visibility = 'hidden';
						}, 3000);
					}
				);
			} else if (zthingid != '') {
				var zrequest = {
					'thingid': zthingid,
					'positionx': WTW.myAvatar.position.x,
					'positiony': WTW.myAvatar.position.y,
					'positionz': WTW.myAvatar.position.z,
					'scalingx': 1,
					'scalingy': 1,
					'scalingz': 1,
					'rotationx': WTW.cameraYOffset,
					'rotationy': WTW.getDegrees(WTW.myAvatar.rotation.y),
					'rotationz': WTW.getDegrees(WTW.myAvatar.rotation.z),
					'function':'savestartposition'
				};
				WTW.postAsyncJSON('/core/handlers/things.php', zrequest, 
					function(zresponse) {
						zresponse = JSON.parse(zresponse);
						/* note serror would contain errors */
						dGet('wtw_startsaved').style.visibility = 'visible';
						window.setTimeout(function(){
							dGet('wtw_startsaved').style.visibility = 'hidden';
						}, 3000);
					}
				);
			}
		}
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-setStartPosition=' + ex.message);
	}
}

WTWJS.prototype.openStartPositionForm = async function() {
	/* load settings to the Start Position Form */
	try {
		WTW.clearDDL('wtw_tdefaultspawnzone');
		var zoption = document.createElement('option');
		zoption.text = 'Random';
		zoption.value = '';
		dGet('wtw_tdefaultspawnzone').add(zoption);
		var zoption2 = document.createElement('option');
		zoption2.text = 'Default';
		zoption2.value = 'default';
		dGet('wtw_tdefaultspawnzone').add(zoption2);
		WTW.getAsyncJSON('/connect/domaininfo.php?communityid=' + communityid + '&buildingid=' + buildingid + '&thingid=' + thingid, 
			function(zresponse) {
				zresponse = JSON.parse(zresponse);
				var zspawnactionzoneid = '';
				if (zresponse.domaininfo.spawnactionzoneid != undefined) {
					zspawnactionzoneid = zresponse.domaininfo.spawnactionzoneid;
				}
				if (zresponse.spawnzones != null) {
					for (var i =0;i<zresponse.spawnzones.length;i++) {
						if (zresponse.spawnzones[i] != null) {
							var zoption3 = document.createElement('option');
							zoption3.text = zresponse.spawnzones[i].actionzonename;
							zoption3.value = zresponse.spawnzones[i].actionzoneid;
							if (zresponse.spawnzones[i].actionzoneid == zspawnactionzoneid) {
								zoption3.selected = true;
							}
							dGet('wtw_tdefaultspawnzone').add(zoption3);
						}
					}
				}
				if (zspawnactionzoneid == '') {
					dGet('wtw_tdefaultspawnzone').selectedIndex = 0;
				} else if (zspawnactionzoneid == 'default') {
					dGet('wtw_tdefaultspawnzone').selectedIndex = 1;
				}
			}
		);
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-openStartPositionForm=' + ex.message);
	}
}		

WTWJS.prototype.saveDefaultSpawnZone = async function(zcommunityid, zbuildingid, zthingid) {
	/* sets start position for 3D Community, 3D Building, or 3D Thing */
	try {
		var zspawnactionzoneid = WTW.getDDLValue('wtw_tdefaultspawnzone');
		var zrequest = {
			'communityid': zcommunityid,
			'buildingid': zbuildingid,
			'thingid': zthingid,
			'spawnactionzoneid': zspawnactionzoneid,
			'function':'savedefaultspawnzone'
		};
		WTW.postAsyncJSON('/core/handlers/communities.php', zrequest, 
			function(zresponse) {
				zresponse = JSON.parse(zresponse);
				/* note serror would contain errors */
			}
		);
		WTW.hideAdminMenu();
		WTW.backToTools();
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-saveDefaultSpawnZone=' + ex.message);
	}
}


/* screen capture for babylon canvas of 3D Scene */

WTWJS.prototype.openUpdateSnapshotForm = async function() {
	/* open stapshot form view  and load current snapshot if any */
	try {
		WTW.hide('wtw_adminmenu69b');
		WTW.show('wtw_loadingupdatesnapshot');
		if (communityid != '') {
			WTW.getAsyncJSON('/connect/communities.php', 
				function(zresponse) {
					WTW.communities = JSON.parse(zresponse);
					if (WTW.communities != null) {
						for (var i = 0; i < WTW.communities.length; i++) {
							if (WTW.communities[i] != null) {
								if (WTW.communities[i].communityinfo.communityid != undefined) {
									if (WTW.communities[i].communityinfo.communityid != null) {
										if (communityid == WTW.communities[i].communityinfo.communityid) {
											if (WTW.communities[i].communityinfo.snapshotpath != '') {
												dGet('wtw_defaultsnapshot').src = WTW.communities[i].communityinfo.snapshotpath;
											} else {
												dGet('wtw_defaultsnapshot').src = WTW.communities[i].communityinfo.snapshotdata;
											}
										}
									}
								}
							}
						}
					}
					if (dGet('wtw_defaultsnapshot').src.length < 20) {
						WTW.hide('wtw_defaultsnapshot');
					} else {
						WTW.show('wtw_defaultsnapshot');
					}
					WTW.hide('wtw_loadingupdatesnapshot');
					WTW.show('wtw_adminmenu69b');
					WTW.setWindowSize();
				}
			);
		} else if (buildingid != '') {
			WTW.getAsyncJSON('/connect/buildings.php', 
				function(zresponse) {
					WTW.buildings = JSON.parse(zresponse);
					if (WTW.buildings != null) {
						for (var i = 0; i < WTW.buildings.length; i++) {
							if (WTW.buildings[i] != null) {
								if (WTW.buildings[i].buildinginfo.buildingid != undefined) {
									if (WTW.buildings[i].buildinginfo.buildingid != null) {
										if (buildingid == WTW.buildings[i].buildinginfo.buildingid) {
											if (WTW.buildings[i].buildinginfo.snapshotpath != '') {
												dGet('wtw_defaultsnapshot').src = WTW.buildings[i].buildinginfo.snapshotpath;
											} else {
												dGet('wtw_defaultsnapshot').src = WTW.buildings[i].buildinginfo.snapshotdata;
											}
										}
									}
								}
							}
						}
					}
					if (dGet('wtw_defaultsnapshot').src.length < 20) {
						WTW.hide('wtw_defaultsnapshot');
					} else {
						WTW.show('wtw_defaultsnapshot');
					}
					WTW.hide('wtw_loadingupdatesnapshot');
					WTW.show('wtw_adminmenu69b');
					WTW.setWindowSize();
				}
			);
		} else if (thingid != '') {
			WTW.getAsyncJSON('/connect/things.php?userid=' + dGet('wtw_tuserid').value, 
				function(zresponse) {
					WTW.things = JSON.parse(zresponse);
					if (WTW.things != null) {
						for (var i = 0; i < WTW.things.length; i++) {
							if (WTW.things[i] != null) {
								if (WTW.things[i].thinginfo.thingid != undefined) {
									if (WTW.things[i].thinginfo.thingid != null) {
										if (thingid == WTW.things[i].thinginfo.thingid) {
											if (WTW.things[i].thinginfo.snapshotpath != '') {
												dGet('wtw_defaultsnapshot').src = WTW.things[i].thinginfo.snapshotpath;
											} else {
												dGet('wtw_defaultsnapshot').src = WTW.things[i].thinginfo.snapshotdata;
											}
										}
									}
								}
							}
						}
					}
					if (dGet('wtw_defaultsnapshot').src.length < 20) {
						WTW.hide('wtw_defaultsnapshot');
					} else {
						WTW.show('wtw_defaultsnapshot');
					}
					WTW.hide('wtw_loadingupdatesnapshot');
					WTW.show('wtw_adminmenu69b');
					WTW.setWindowSize();
				}
			);
		} else if (avatarid != '') {
			WTW.getAsyncJSON('/connect/avatar.php?avatarid=' + avatarid, 
				function(zresponse) {
					zresponse = JSON.parse(zresponse);
					dGet('wtw_tavatarfolder').value = zresponse.avatar.objects.folder;
					if (zresponse.avatar.snapshots.thumbnail != null) {
						dGet('wtw_defaultsnapshot').src = zresponse.avatar.snapshots.thumbnail;
						if (dGet('wtw_defaultsnapshot').src.length < 20) {
							WTW.hide('wtw_defaultsnapshot');
						} else {
							WTW.show('wtw_defaultsnapshot');
						}
					} else {
						WTW.hide('wtw_defaultsnapshot');
					}
					WTW.hide('wtw_loadingupdatesnapshot');
					WTW.show('wtw_adminmenu69b');
					WTW.setWindowSize();
				}
			);
		}
	} catch (ex) {
		WTW.log('core-scripts-admin-wtw_admincommunities.js-openUpdateSnapshotForm=' + ex.message);
	}
}

WTWJS.prototype.snapshot3D = async function(zfilepath, zfilename) {
	/* capture 3D Scene and save file to server */
	try {
		/* 3d web form */
		if (dGet('wtw_bsnapshotthing') != null) {
			dGet('wtw_bsnapshotthing').onclick = '';
			dGet('wtw_bsnapshotthing').innerHTML = "<span style='color:gray;'>Loading Image...</span>";
		}
		if (dGet('wtw_bsnapshotbuilding') != null) {
			dGet('wtw_bsnapshotbuilding').onclick = '';
			dGet('wtw_bsnapshotbuilding').innerHTML = "<span style='color:gray;'>Loading Image...</span>";
		}
		if (dGet('wtw_bsnapshotcommunity') != null) {
			dGet('wtw_bsnapshotcommunity').onclick = '';
			dGet('wtw_bsnapshotcommunity').innerHTML = "<span style='color:gray;'>Loading Image...</span>";
		}
		/* avatar forms */
		if (dGet('wtw_bupdatesnapshot') != null) {
			dGet('wtw_bupdatesnapshot').onclick = '';
			dGet('wtw_bupdatesnapshot').innerHTML = "<span style='color:gray;'>Loading Image...</span>";
		}
		if (dGet('wtw_bsnapshotavatar') != null) {
			dGet('wtw_bsnapshotavatar').onclick = '';
			dGet('wtw_bsnapshotavatar').innerHTML = "<span style='color:gray;'>Loading Image...</span>";
		}
		dGet('wtw_tfilename').value = zfilename;
		dGet('wtw_tfilepath').value = zfilepath;

		var zcontext = canvas.getContext('experimental-webgl', {preserveDrawingBuffer: true});
		scene.render();
		var zfiledata = canvas.toDataURL('image/png');
		zcontext = canvas.getContext('experimental-webgl', {preserveDrawingBuffer: false});
		var zrequest = {
			'communityid': communityid,
			'buildingid': buildingid,
			'thingid': thingid,
			'avatarid': avatarid,
			'filename': dGet('wtw_tfilename').value,
			'filepath': dGet('wtw_tfilepath').value,
			'filedata': zfiledata,
			'function':'saveimage'
		};
		WTW.postAsyncJSON('/core/handlers/uploads.php', zrequest, 
			function(zresponse) {
				zresponse = JSON.parse(zresponse);
				/* note serror would contain errors */
				WTW.updateSnapshot3D(communityid, buildingid, thingid, avatarid, zresponse.snapshotid, zresponse.snapshotpath, zresponse.snapshotdata);
			}
		);
	} catch (ex) {
		WTW.log('core-scripts-prime-wtw_admincommunities.js-snapshot3D=' + ex.message);
	} 
}

WTWJS.prototype.updateSnapshot3D = function(zcommunityid, zbuildingid, zthingid, zavatarid, zsnapshotid, zsnapshotpath, zfiledata) {
	/* update snapshot of 3D Community, 3D Building, or 3D Thing */
	try {
		if (WTW.adminView == 1) {
			if (zthingid != '') {
				if (dGet('wtw_defaultthingsnapshot') != null) {
					if (zsnapshotpath != '') {
						dGet('wtw_defaultthingsnapshot').src = zsnapshotpath + '?' + WTW.getRandomString(5);
					} else {
						dGet('wtw_defaultthingsnapshot').src = zfiledata;
					}
					WTW.show('wtw_defaultthingsnapshot');
				}
				if (WTW.things != null) {
					for (var i = 0; i < WTW.things.length; i++) {
						if (WTW.things[i] != null) {
							if (WTW.things[i].thinginfo.thingid != undefined) {
								if (WTW.things[i].thinginfo.thingid != null) {
									if (zthingid == WTW.things[i].thinginfo.thingid) {
										WTW.things[i].thinginfo.snapshotid = zsnapshotid;
										WTW.things[i].thinginfo.snapshotpath = zsnapshotpath;
										WTW.things[i].thinginfo.snapshotdata = zfiledata;
									}
								}
							}
						}
					}
				}
			}
			if (zbuildingid != '') {
				if (dGet('wtw_defaultbuildingsnapshot') != null) {
					if (zsnapshotpath != '') {
						dGet('wtw_defaultbuildingsnapshot').src = zsnapshotpath + '?' + WTW.getRandomString(5);
					} else {
						dGet('wtw_defaultbuildingsnapshot').src = zfiledata;
					}
					WTW.show('wtw_defaultbuildingsnapshot');
				}
				if (WTW.buildings != null) {
					for (var i = 0; i < WTW.buildings.length; i++) {
						if (WTW.buildings[i] != null) {
							if (WTW.buildings[i].buildinginfo.buildingid != undefined) {
								if (WTW.buildings[i].buildinginfo.buildingid != null) {
									if (zbuildingid == WTW.buildings[i].buildinginfo.buildingid) {
										WTW.buildings[i].buildinginfo.snapshotid = zsnapshotid;
										WTW.buildings[i].buildinginfo.snapshotpath = zsnapshotpath;
										WTW.buildings[i].buildinginfo.snapshotdata = zfiledata;
									}
								}
							}
						}
					}
				}
			}
			if (zcommunityid != '') {
				if (dGet('wtw_defaultcommunitysnapshot') != null) {
					if (zsnapshotpath != '') {
						dGet('wtw_defaultcommunitysnapshot').src = zsnapshotpath + '?' + WTW.getRandomString(5);
					} else {
						dGet('wtw_defaultcommunitysnapshot').src = zfiledata;
					}
					WTW.show('wtw_defaultcommunitysnapshot');
				}
				if (WTW.communities != null) {
					for (var i = 0; i < WTW.communities.length; i++) {
						if (WTW.communities[i] != null) {
							if (WTW.communities[i].communityinfo.communityid != undefined) {
								if (WTW.communities[i].communityinfo.communityid != null) {
									if (zcommunityid == WTW.communities[i].communityinfo.communityid) {
										WTW.communities[i].communityinfo.snapshotid = zsnapshotid;
										WTW.communities[i].communityinfo.snapshotpath = zsnapshotpath;
										WTW.communities[i].communityinfo.snapshotdata = zfiledata;
									}
								}
							}
						}
					}
				}
			}
		}
		/* update snapshot on snapshot form */
		if (dGet('wtw_defaultsnapshot') != null) {
			if (zsnapshotpath != '') {
				dGet('wtw_defaultsnapshot').src = zsnapshotpath + '?' + WTW.getRandomString(5);
			} else {
				dGet('wtw_defaultsnapshot').src = zfiledata;
			}
			WTW.show('wtw_defaultsnapshot');
		}
		if (dGet('wtw_bupdatesnapshot') != null) {
			dGet('wtw_bupdatesnapshot').onclick = function(){
				if (WTW.adminView == 1) {
					WTW.adminMenuItemSelected(this);
				}
			};
			dGet('wtw_bupdatesnapshot').innerHTML = 'Set Default Snapshot';
		}
		if (avatarid != '') {
			/* update snapshot on avatar share form */
				if (dGet('wtw_defaultavatarsnapshot') != null) {
				if (zsnapshotpath != '') {
					dGet('wtw_defaultavatarsnapshot').src = zsnapshotpath + '?' + WTW.getRandomString(5);
				} else {
					dGet('wtw_defaultavatarsnapshot').src = zfiledata;
				}
				WTW.show('wtw_defaultavatarsnapshot');
			}
			if (dGet('wtw_bsnapshotavatar') != null) {
				dGet('wtw_bsnapshotavatar').onclick = function(){
					WTW.snapshot3D(dGet('wtw_trootpath').value + dGet('wtw_tavatarfolder').value + 'snapshots/', 'defaultavatar.png');
				};
				dGet('wtw_bsnapshotavatar').innerHTML = 'Set Default Snapshot';
			}
		} else {
			/* update snapshot on community, building, and thing forms */
			if (dGet('wtw_bsnapshotthing') != null) {
				dGet('wtw_bsnapshotthing').onclick = function(){
					WTW.snapshot3D(dGet('wtw_tcontentpath').value + '/uploads/things/' + dGet('wtw_tthingid').value + '/snapshots/', 'defaultthing.png');
				};
				dGet('wtw_bsnapshotthing').innerHTML = 'Set Default Snapshot';
			}
			if (dGet('wtw_bsnapshotbuilding') != null) {
				dGet('wtw_bsnapshotbuilding').onclick = function(){
					WTW.snapshot3D(dGet('wtw_tcontentpath').value + '/uploads/buildings/' + dGet('wtw_tbuildingid').value + '/snapshots/', 'defaultbuilding.png');
				};
				dGet('wtw_bsnapshotbuilding').innerHTML = 'Set Default Snapshot';
			}
			if (dGet('wtw_bsnapshotcommunity') != null) {
				dGet('wtw_bsnapshotcommunity').onclick = function(){
					WTW.snapshot3D(dGet('wtw_tcontentpath').value + '/uploads/communities/' + dGet('wtw_tcommunityid').value + '/snapshots/', 'defaultcommunity.png');
				};
				dGet('wtw_bsnapshotcommunity').innerHTML = 'Set Default Snapshot';
			}
		}

	} catch (ex) {
		WTW.log('core-scripts-prime-wtw_admincommunities.js-updateSnapshot3D=' + ex.message);
	} 
}

