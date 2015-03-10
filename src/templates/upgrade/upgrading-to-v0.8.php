
#RENAME FOLDERS

class
to
classes


include
to
includes



# MOVE MEDIAE TO CENTRAL TABLE IF DESIRED

Upgade class



# JANITOR CLASS UPDATE

Itemtypes extend Itemtype (instead of Model)




new Item()
to
new Items()


# JANITOR CONTROLLER UPDATE

Manual update (in most cases optional)


# JANITOR TEMPLATE UPDATE



# UPDATE FUNCTION NAMES

$IC-getItems can extend directly


$IC->getCompleteItem()
replace with 
$IC->getItem() with extend option



# Update user_usernames table - add verification_code (varchar 8)
ALTER TABLE user_usernames ADD `verification_code` varchar(8) DEFAULT NULL AFTER `verified`


# Update navigation_nodes table (new fields and contraint + set empty node_page_id default NULL)
ALTER TABLE navigation_nodes CHANGE `node_page_id` `node_item_id` int(11) DEFAULT NULL;
ALTER TABLE navigation_nodes ADD `node_item_controller` varchar(255) DEFAULT NULL AFTER `node_item_id`;
ALTER TABLE navigation_nodes ADD `node_target` varchar(255) DEFAULT NULL AFTER `node_classname`;
ALTER TABLE navigation_nodes ADD `node_fallback` varchar(255) DEFAULT NULL AFTER `node_target`;
UPDATE navigation_nodes SET node_item_id = NULL WHERE node_item_id = 0;
ALTER TABLE navigation_nodes ADD CONSTRAINT `navigation_nodes_ibfk_2` FOREIGN KEY (`node_item_id`) REFERENCES `items` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

		
