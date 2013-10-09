<?php
/**
 * @desc <b>Cart</b> - provides all necessary methods to use a cart.
 * @desc <p>public methods:</p><ul><li>item</li></ul>
 * @author sopitz
 * @todo implement methods,write observer for itemList which: a) processes the current price automatically, b) creates a history to provide undo events
 * @version 0.0.1
 */
require_once 'BaseController.php';
class Cart extends BaseController{
	private $user;
	private $itemList = array();
	private $price;
	
	
	public function __construct($user) {
		if ($user instanceof User) {
			$this->user = $user;
		} else {
			self::logErrorWithErrorText("\$user not instnace of user");
		}
		
	}
	
	
	public function addItemWitItemObject($item) {
		if (!($this->checkforItemClasswithItemObject($item))) {
			self::logErrorWithErrorText("\$item is not of class Item");
		}
		array_push($this->itemList, $item);
	}
	
	public function removeItemWithArayofItemObject($item) {
		if (!($this->checkforItemClasswithItemObject($item))) {
			self::logErrorWithErrorText("\$item is not of class Item");
		}
		foreach ($this->itemList as $itemfromitemlist) {
			if ($itemfromitemlist === $item) {
				// delete element
			}
		}
	} 
	
	
	
	public function checkOut() {
		
	}
	
	public function processPayment() {
		
	}
	
	private function checkforItemClasswithItemObject($item) {
		if ($item instanceof Item) {
			return true;
		}
		return false;
	}
	
	private function calcItemPosition() {
		return $this->itemList + 1;
	}
}