<?php
require_once 'Customizing/global/plugins/Services/Repository/RepositoryObject/InteractiveVideo/VideoSources/interface.ilInteractiveVideoSource.php';
/**
 * Class ilInteractiveVideoFauVideoPortal
 */
class ilInteractiveVideoFauVideoPortal implements ilInteractiveVideoSource
{
	const FORM_ID_FIELD = 'fau_id';
	const FORM_URL_FIELD = 'fau_url';

	const TABLE_NAME = 'rep_robj_xvid_fau';

	/**
	 * @var string
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $version;

	/**
	 * @var string
	 */
	protected $core_folder;

	/**
	 * ilInteractiveVideoYoutube constructor.
	 */
	public function __construct()
	{
		if (is_file(dirname(__FILE__) . '/version.php'))
		{
			include(dirname(__FILE__) . '/version.php');
			$this->version = $version;
			$this->id = $id;
		}
	}

	/**
	 * @param $obj_id
	 */
	public function doCreateVideoSource($obj_id)
	{
		$this->doUpdateVideoSource($obj_id);
	}

	/**
	 * @param int $obj_id
	 * @return array
	 */
	public function doReadVideoSource($obj_id)
	{
		global $ilDB;
		$result = $ilDB->query('SELECT fau_id, fau_url FROM '.self::TABLE_NAME.' WHERE obj_id = '.$ilDB->quote($obj_id, 'integer'));
		$row = $ilDB->fetchAssoc($result);
		return array('fau_id' => $row['fau_id'], 'fau_url' => $row['fau_url']);
	}

	/**
	 * @param $obj_id
	 */
	public function doDeleteVideoSource($obj_id)
	{
		$this->beforeDeleteVideoSource($obj_id);
	}

	/**
	 * @param $original_obj_id
	 * @param $new_obj_id
	 */
	public function doCloneVideoSource($original_obj_id, $new_obj_id)
	{
		$data = $this->doReadVideoSource($original_obj_id);
		$this->saveData($new_obj_id, $data['fau_id'], $data['fau_url']);
	}

	/**
	 * @param $obj_id
	 */
	public function beforeDeleteVideoSource($obj_id)
	{
		$this->removeEntryFromTable($obj_id);
	}

	/**
	 * @param $obj_id
	 */
	public function removeEntryFromTable($obj_id)
	{
		global $ilDB;
		$ilDB->manipulateF('DELETE FROM '.self::TABLE_NAME.' WHERE obj_id = %s',
			array('integer'), array($obj_id));
	}

	/**
	 * @param $obj_id
	 */
	public function doUpdateVideoSource($obj_id)
	{
		$fau_id = ilUtil::stripSlashes($_POST['fau_id']);
		$fau_url = ilUtil::stripSlashes($_POST['fau_url']);
		$this->removeEntryFromTable($obj_id);
		$this->saveData($obj_id, $fau_id, $fau_url);
	}

	/**
	 * @param $obj_id
	 * @param $fau_id
	 * @param $fau_url
	 */
	protected function saveData($obj_id, $fau_id, $fau_url)
	{
		global $ilDB;
		$ilDB->insert(
			self::TABLE_NAME,
			array(
				'obj_id'     => array('integer', $obj_id),
				'fau_id'     => array('text', $fau_id),
				'fau_url'    => array('text', $fau_url)
			)
		);
	}

	/**
	 * @return string
	 */
	public function getClass()
	{
		return __CLASS__;
	}

	/**
	 * @return bool
	 */
	public function isFileBased()
	{
		return false;
	}

	/**
	 * @return ilInteractiveVideoFauVideoPortalGUI
	 */
	public function getGUIClass()
	{
		require_once dirname(__FILE__) . '/class.ilInteractiveVideoFauVideoPortalGUI.php';
		return new ilInteractiveVideoFauVideoPortalGUI();
	}

	/**
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getClassPath()
	{
		return 'VideoSources/plugin/InteractiveVideoFauVideoPortal/class.ilInteractiveVideoFauVideoPortal.php';
	}

	/**
	 * @return string
	 */
	public function getVersion()
	{
		return $this->version;
	}
}