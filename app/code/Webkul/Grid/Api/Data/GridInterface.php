<?php
/**
 * Grid GridInterface.
 * @category  Webkul
 * @package   Webkul_Grid
 * @author    Webkul
 * @copyright Copyright (c) 2010-2017 Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */

namespace Webkul\Grid\Api\Data;

interface GridInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ENTITY_ID = 'entity_id';
    const TITLE = 'title';
	const TICKETNUMBER = 'ticketnumber';
    const FULLNAME = 'fullname';
	const EMAIL = 'email';
    const TOPIC = 'topic';
    const STATUS = 'status';
    const UPDATE_TIME = 'update_time';
    const CREATED_AT = 'created_at';

   /**
    * Get EntityId.
    *
    * @return int
    */
    public function getEntityId();

   /**
    * Set EntityId.
    */
    public function setEntityId($entityId);

   /**
    * Get Title.
    *
    * @return varchar
    */
    public function getTitle();

   /**
    * Set Title.
    */
    public function setTitle($title);
	
	/**
    * Get Ticketnumber.
    *
    * @return varchar
    */
    public function getTicketnumber();

   /**
    * Set Ticketnumber.
    */
    public function setTicketnumber($ticketnumber);

   /**
    * Get Fullname.
    *
    * @return varchar
    */
    public function getFullname();

   /**
    * Set Fullname.
    */
    public function setFullname($fullname);
	
	/**
    * Get Email.
    *
    * @return varchar
    */
    public function getEmail();

   /**
    * Set Email.
    */
    public function setEmail($email);

   /**
    * Get Topic.
    *
    * @return varchar
    */
    public function getTopic();

   /**
    * Set Topic.
    */
    public function setTopic($topic);

   /**
    * Get Status.
    *
    * @return varchar
    */
    public function getStatus();

   /**
    * Set Status.
    */
    public function setStatus($status);

   /**
    * Get UpdateTime.
    *
    * @return varchar
    */
    public function getUpdateTime();

   /**
    * Set UpdateTime.
    */
    public function setUpdateTime($updateTime);

   /**
    * Get CreatedAt.
    *
    * @return varchar
    */
    public function getCreatedAt();

   /**
    * Set CreatedAt.
    */
    public function setCreatedAt($createdAt);
}
