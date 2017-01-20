<?php
require_once 'Customizing/global/plugins/Services/Repository/RepositoryObject/InteractiveVideo/VideoSources/interface.ilInteractiveVideoSourceGUI.php';
require_once 'Customizing/global/plugins/Services/Repository/RepositoryObject/InteractiveVideo/VideoSources/plugin/InteractiveVideoFauVideoPortal/class.ilInteractiveVideoFauVideoPortal.php';

/**
 * Class ilInteractiveVideoFauVideoPortalGUI
 */
class ilInteractiveVideoFauVideoPortalGUI implements ilInteractiveVideoSourceGUI
{
	/**
	 * @param ilRadioOption $option
	 * @param               $obj_id
	 * @return ilRadioOption
	 */
	public function getForm($option, $obj_id)
	{
		global $tpl, $lng;
		$tpl->addJavaScript('Customizing/global/plugins/Services/Repository/RepositoryObject/InteractiveVideo/VideoSources/plugin/InteractiveVideoFauVideoPortal/js/fauMediaPortalAjaxQuery.js');
		$fau_id = new ilTextInputGUI(ilInteractiveVideoPlugin::getInstance()->txt('fau_id'), 'fau_id');
		$object = new ilInteractiveVideoFauVideoPortal();
		$data = $object->doReadVideoSource($obj_id);
		$fau_id->setValue($data['fau_id']);
		$fau_id->setInfo(ilInteractiveVideoPlugin::getInstance()->txt('fau_id_info'));
		$option->addSubItem($fau_id);
		$fau_url = new ilHiddenInputGUI('fau_url');
		$fau_url->setValue($data['fau_url']);
		$option->addSubItem($fau_url);
		$lng->toJS(array('rep_robj_xvid_fau_video_found', 'rep_robj_xvid_fau_not_found'), $tpl);
		return $option;
	}

	/**
	 * @param ilPropertyFormGUI $form
	 * @return bool
	 */
	public function checkForm($form)
	{
		$fau_url = ilUtil::stripSlashes($_POST['fau_url']);
		if($fau_url != '' )
		{
			return true;
		}
		return false;
	}
	

	/**
	 * @param ilTemplate $tpl
	 * @return ilTemplate
	 */
	public function addPlayerElements($tpl)
	{
		$tpl->addJavaScript('Customizing/global/plugins/Services/Repository/RepositoryObject/InteractiveVideo/VideoSources/plugin/InteractiveVideoFauVideoPortal/js/jquery.InteractiveVideoFauVideoPortalPlayer.js');
		$tpl->addJavaScript('Services/MediaObjects/media_element_2_14_2/mediaelement-and-player.js');
		$tpl->addCss('Services/MediaObjects/media_element_2_14_2/mediaelementplayer.css');
		return $tpl;
	}

	/**
	 * @param ilObjInteractiveVideo $obj
	 * @return ilTemplate
	 */
	public function getPlayer($obj)
	{
		$player		= new ilTemplate('Customizing/global/plugins/Services/Repository/RepositoryObject/InteractiveVideo/VideoSources/plugin/InteractiveVideoFauVideoPortal/tpl/tpl.video.html', false, false);
		$instance	= new ilInteractiveVideoFauVideoPortal();
		$data		= $instance->doReadVideoSource($obj->getId());
		$player->setVariable('FAU_URL', $data['fau_url']);
		return $player;
	}

	/**
	 * @param array                 $a_values
	 * @param ilObjInteractiveVideo $obj
	 */
	public function getEditFormCustomValues(array &$a_values, $obj)
	{
		$instance = new ilInteractiveVideoFauVideoPortal();
		$value = $instance->doReadVideoSource($obj->getId());
	
		$a_values[ilInteractiveVideoFauVideoPortal::FORM_ID_FIELD] = $value['fau_id'];
		$a_values[ilInteractiveVideoFauVideoPortal::FORM_URL_FIELD] = $value['fau_url'];
	}

	/**
	 * @param $form
	 */
	public function getConfigForm($form)
	{

	}

	/**
	 * @return boolean
	 */
	public function hasOwnConfigForm()
	{
		return false;
	}

}