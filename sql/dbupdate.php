<#1>
<?php
/**
 * @var $ilDB ilDB
 */
if(!$ilDB->tableExists('rep_robj_xvid_fau'))
{
	$fields = array(
		'obj_id' => array(
			'type' => 'integer',
			'length' => '4',
			'notnull' => true
		),
		'fau_id' => array(
			'type' => 'text',
			'length' => '100',
			'notnull' => true
		),
		'fau_url' => array(
			'type' => 'text',
			'length' => '1000',
			'notnull' => true
		)
	);
	$ilDB->createTable('rep_robj_xvid_fau', $fields);
	$ilDB->addPrimaryKey('rep_robj_xvid_fau', array('obj_id', 'fau_id'));
}
?>