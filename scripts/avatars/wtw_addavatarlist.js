/* All code is Copyright 2013-2023 Bixma */
/* All code is patent */


/* these functions set the types of avatars to add and define the default values, form fields, and functions to create the avatars */

/* currently not in use, these functions will hold the ability to add auto bot avatars to scenes */
WTWJS.prototype.getAvatarList = function() {
	/* list of autobot avatars */
	var zavatarlist = [];
	try {
		zavatarlist[zavatarlist.length] = 'Anonymous';
		zavatarlist[zavatarlist.length] = 'Female';
		zavatarlist[zavatarlist.length] = 'Male';
	} catch (ex) {
		WTW.log('core-scripts-avatars-addavatarlist\r\n getAvatarList=' + ex.message);
	} 
	return zavatarlist;
}

WTWJS.prototype.addAvatar = function(zavatarname, zavatardef, zparentname) {
	/* functions to add the autobot avatars selected by avatartype (avatar) */
	var zavatar;
	try {
		if (zavatardef.avatar == undefined) {
			zavatardef.avatar = '';
		}
		switch (zavatardef.avatar.toLowerCase()) {
			case 'shark':
				zavatar = WTW.addAvatarShark(zavatarname, zavatardef);
				break;
			default:
				zavatardef.avatar = '';
				zavatar = WTW.addAvatar3DObject(zavatarname, zavatardef);
				break;
		}
		var zavatarparent = WTW.getMeshOrNodeByID(zavatardef.parentname);
		if (zavatarparent != null) {
			zavatar.parent = zavatarparent;
		}
	} catch (ex) {
		WTW.log('core-scripts-avatars-addavatarlist\r\n addAvatar=' + ex.message);
	} 
	return zavatar;
}
