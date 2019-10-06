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
		$object->doReadVideoSource($obj_id);
		$fau_id->setValue($object->getFauId());
		$fau_id->setInfo(ilInteractiveVideoPlugin::getInstance()->txt('fau_id_info'));
		$option->addSubItem($fau_id);
		$fau_url = new ilHiddenInputGUI('fau_url');
		$fau_url->setValue($object->getFauUrl());
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
        ilPlayerUtil::initMediaElementJs($tpl);
		return $tpl;
	}

    /**
     * @param                       $player_id
     * @param ilObjInteractiveVideo $obj
     * @return ilTemplate
     */
    public function getPlayer($player_id, $obj)
	{
		$player		= new ilTemplate('Customizing/global/plugins/Services/Repository/RepositoryObject/InteractiveVideo/VideoSources/plugin/InteractiveVideoFauVideoPortal/tpl/tpl.video.html', false, false);
		$instance	= new ilInteractiveVideoFauVideoPortal();
		$instance->doReadVideoSource($obj->getId());
		$player->setVariable('PLAYER_ID', $player_id);
		$player->setVariable('FAU_URL', $instance->getFauUrl());
		return $player;
	}

	/**
	 * @param array                 $a_values
	 * @param ilObjInteractiveVideo $obj
	 */
	public function getEditFormCustomValues(array &$a_values, $obj)
	{
		$instance = new ilInteractiveVideoFauVideoPortal();
		$instance->doReadVideoSource($obj->getId());
	
		$a_values[ilInteractiveVideoFauVideoPortal::FORM_ID_FIELD] = $instance->getFauId();
		$a_values[ilInteractiveVideoFauVideoPortal::FORM_URL_FIELD] = $instance->getFauUrl();
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