<?php
/* handlers recieve the form submittals from the javascript and route the data to the correct class functions for processing to and from the database */
/* this handler is for action zone functions */
require_once('../functions/class_wtwhandlers.php');
global $wtwhandlers;
try {
	require_once(wtw_rootpath.'/core/functions/class_wtwactionzones.php');
	global $wtwactionzones;
	$zrequest = $wtwhandlers->openFilefromURL('php://input');
	$zrequest = json_decode($zrequest, TRUE);
	
	/* read in values */
	$zfunction = strtolower($wtwhandlers->getPost('function',''));
	$zactionzoneid = $wtwhandlers->getPost('actionzoneid','');
	$zcommunityid = $wtwhandlers->getPost('communityid','');
	$zbuildingid = $wtwhandlers->getPost('buildingid','');
	$zthingid = $wtwhandlers->getPost('thingid','');
	$zactionzonename = $wtwhandlers->getPost('actionzonename','');
	$zactionzonetype = $wtwhandlers->getPost('actionzonetype','');
	$zactionzoneshape = $wtwhandlers->getPost('actionzoneshape','');
	$zattachmoldid = $wtwhandlers->getPost('attachmoldid','');
	$zteleportwebid = $wtwhandlers->getPost('teleportwebid','');
	$zteleportwebtype = $wtwhandlers->getPost('teleportwebtype','');
	$zspawnactionzoneid = $wtwhandlers->getPost('spawnactionzoneid','');
	$zmovementtype = $wtwhandlers->getPost('movementtype','');
	$zrotatespeed = $wtwhandlers->getPost('rotatespeed','1');
	$zvalue1 = $wtwhandlers->getPost('value1','0');
	$zvalue2 = $wtwhandlers->getPost('value2','0');
	$zdefaulteditform = $wtwhandlers->getPost('defaulteditform','0');
	$zpositionx = $wtwhandlers->getPost('positionx','0');
	$zpositiony = $wtwhandlers->getPost('positiony','0');
	$zpositionz = $wtwhandlers->getPost('positionz','0');
	$zscalingx = $wtwhandlers->getPost('scalingx','1');
	$zscalingy = $wtwhandlers->getPost('scalingy','1');
	$zscalingz = $wtwhandlers->getPost('scalingz','1');
	$zrotationx = $wtwhandlers->getPost('rotationx','0');
	$zrotationy = $wtwhandlers->getPost('rotationy','0');
	$zrotationz = $wtwhandlers->getPost('rotationz','0');
	$zaxispositionx = $wtwhandlers->getPost('axispositionx','0');
	$zaxispositiony = $wtwhandlers->getPost('axispositiony','0');
	$zaxispositionz = $wtwhandlers->getPost('axispositionz','0');
	$zaxisscalingx = $wtwhandlers->getPost('axisscalingx','1');
	$zaxisscalingy = $wtwhandlers->getPost('axisscalingy','1');
	$zaxisscalingz = $wtwhandlers->getPost('axisscalingz','1');
	$zaxisrotationx = $wtwhandlers->getPost('axisrotationx','0');
	$zaxisrotationy = $wtwhandlers->getPost('axisrotationy','0');
	$zaxisrotationz = $wtwhandlers->getPost('axisrotationz','0');
	$zrotateaxis = $wtwhandlers->getPost('rotateaxis','y');
	$zrotatedegrees = $wtwhandlers->getPost('rotatedegrees','90');
	$zrotatedirection = $wtwhandlers->getPost('rotatedirection','1');
	$zloadactionzoneid = $wtwhandlers->getPost('loadactionzoneid','');
	$zjsfunction = $wtwhandlers->getPost('jsfunction','');
	$zjsparameters = $wtwhandlers->getPost('jsparameters','');
	$zmoldswithactionzones = $wtwhandlers->getPost('moldswithactionzones','');
	$zavataranimationid = $wtwhandlers->getPost('avataranimationid','');
	$zactionzonesbulk = $wtwhandlers->getPost('actionzonesbulk','');

	/* select the function called */
	$zresponse = array();
	switch ($zfunction) {
		case "saveactionzone":
			if ($wtwactionzones->saveActionZone($zactionzoneid, $zcommunityid, $zbuildingid, $zthingid, $zactionzonename, $zactionzonetype, $zactionzoneshape, $zattachmoldid, $zteleportwebid, $zteleportwebtype, $zspawnactionzoneid, $zmovementtype, $zrotatespeed, $zvalue1, $zvalue2, $zdefaulteditform, $zpositionx, $zpositiony, $zpositionz, $zscalingx, $zscalingy, $zscalingz, $zrotationx, $zrotationy, $zrotationz, $zaxispositionx, $zaxispositiony, $zaxispositionz, $zaxisrotationx, $zaxisrotationy, $zaxisrotationz, $zrotateaxis, $zrotatedegrees, $zrotatedirection, $zaxisscalingz, $zloadactionzoneid, $zjsfunction, $zjsparameters) == false) {
				$zresponse = array(
					'serror'=> 'Could not save Action Zone'
				);
			}
			break;
		case "deleteactionzone":
			if ($wtwactionzones->deleteActionZone($zactionzoneid, $zcommunityid, $zbuildingid, $zthingid) == false) {
				$zresponse = array(
					'serror'=> 'Could not delete Action Zone'
				);
			}
			break;
		case "removeactionzone":
			if (!empty($zcommunityid)) {
				if ($wtwactionzones->updateActionZoneCommunityMolds($zmoldswithactionzones, $zcommunityid, $zactionzoneid) == false) {
					$zresponse = array(
						'serror'=> 'Could not update Community Mold'
					);
				}
			} else if (!empty($zbuildingid)) {
				if ($wtwactionzones->updateActionZoneBuildingMolds($zmoldswithactionzones, $zbuildingid, $zactionzoneid) == false) {
					$zresponse = array(
						'serror'=> 'Could not update Building Mold'
					);
				}
			} else if (!empty($zthingid)) {
				if ($wtwactionzones->updateActionZoneThingMolds($zmoldswithactionzones, $zthingid, $zactionzoneid) == false) {
					$zresponse = array(
						'serror'=> 'Could not update Thing Mold'
					);
				}
			}
			break;
		case "saveazavataranimation":
			$wtwactionzones->updateActionZoneAvatarAnimation($zactionzoneid, $zavataranimationid, $zcommunityid, $zbuildingid, $zthingid);
			break;
		case "deleteazavataranimation":
			$wtwactionzones->deleteActionZoneAvatarAnimation($zactionzoneid, $zavataranimationid, $zcommunityid, $zbuildingid, $zthingid);
			break;
		case "importactionzone":
			$wtwactionzones->importActionZones($zcommunityid, $zbuildingid, $zthingid, $zactionzonesbulk);
			break;
	}

	/* set headers to keep data local to server */
	echo $wtwhandlers->addHandlerHeader($wtwhandlers->domainname);
	/* return the response from the function */
	echo json_encode($zresponse);

} catch (Exception $e) {
	$wtwhandlers->serror("core-handlers-actionzones.php=".$e->getMessage());
}
?>