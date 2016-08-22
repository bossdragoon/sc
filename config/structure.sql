/*
Navicat MySQL Data Transfer

Source Server         : HOSxP_Slave
Source Server Version : 50505
Source Host           : 192.168.2.2:3306
Source Database       : db_nurse

Target Server Type    : MYSQL
Target Server Version : 50505
File Encoding         : 65001

Date: 2016-08-02 10:00:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for structure
-- ----------------------------
DROP TABLE IF EXISTS `structure`;
CREATE TABLE `structure` (
  `Table` varchar(100) NOT NULL,
  `Field` varchar(100) NOT NULL,
  `Type` varchar(255) DEFAULT NULL,
  `Null` varchar(255) DEFAULT NULL,
  `Key` varchar(255) DEFAULT NULL,
  `Default` varchar(255) DEFAULT NULL,
  `Extra` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`Table`,`Field`),
  KEY `_Table` (`Table`),
  KEY `_Field` (`Field`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of structure
-- ----------------------------
INSERT INTO `structure` VALUES ('depart', 'depart_id', 'int(2)', 'NO', 'PRI', '', 'auto_increment');
INSERT INTO `structure` VALUES ('depart', 'depart_name', 'varchar(50)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('depart', 'depart_tel', 'char(3)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('depart', 'depart_status', 'char(1)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('depart', 'office_sit', 'int(4)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('depart', 'productivity_status', 'enum(\'N\',\'Y\')', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('config', 'var', 'varchar(255)', 'NO', 'PRI', '', '');
INSERT INTO `structure` VALUES ('config', 'value', 'varchar(255)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('multiple_depart', 'multiple_depart_id', 'int(3)', 'NO', 'PRI', '', 'auto_increment');
INSERT INTO `structure` VALUES ('multiple_depart', 'depart_id1', 'int(2)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('multiple_depart', 'depart_id2', 'int(2)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('office_sit', 'ward_id', 'int(4)', 'NO', 'PRI', '', 'auto_increment');
INSERT INTO `structure` VALUES ('office_sit', 'ward_name', 'varchar(150)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_id', 'varchar(13)', 'NO', 'PRI', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_prefix', 'int(2)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_firstname', 'varchar(100)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_lastname', 'varchar(100)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_sex', 'enum(\'1\',\'2\')', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_cult', 'enum(\'1\',\'2\',\'3\',\'4\')', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_blood', 'int(2)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_status', 'enum(\'1\',\'2\',\'3\',\'4\',\'5\')', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_birth', 'date', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_no', 'varchar(10)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_moo', 'varchar(5)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_road', 'varchar(100)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_tumbon', 'varchar(7)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_amphur', 'varchar(5)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_province', 'varchar(3)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_postcode', 'varchar(5)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_noT', 'varchar(10)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_mooT', 'varchar(5)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_roadT', 'varchar(100)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_tumbonT', 'varchar(7)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_amphurT', 'varchar(5)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_provinceT', 'varchar(3)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_postcodeT', 'varchar(5)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_tel', 'varchar(15)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_email', 'varchar(100)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_da', 'varchar(150)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_ma', 'varchar(150)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_nopo', 'varchar(50)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'position_id', 'varchar(10)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'money_id', 'int(2)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'typeac_id', 'int(2)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'ac_id', 'int(4)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'typeposition_id', 'int(2)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'wo_id', 'int(4)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'po_id', 'int(2)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'po_level_id', 'int(2)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'profession_id', 'int(2)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'office_id', 'int(4)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_singin', 'date', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_state', 'int(2)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_univer', 'varchar(150)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_course', 'varchar(150)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_startdate', 'date', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_enddate', 'date', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_username', 'varchar(15)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_password', 'varchar(50)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_datetime', 'datetime', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_op', 'enum(\'0\',\'1\')', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'person_photo', 'varchar(30)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'CRS_system', 'text', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'NurseManage_system', 'text', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'Productivity_system', 'text', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'productivity_depart_id', 'int(4)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'Supply_system', 'text', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('personal', 'Assessment_system', 'text', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('position', 'position_id', 'int(10)', 'NO', 'PRI', '', '');
INSERT INTO `structure` VALUES ('position', 'position_name', 'varchar(150)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('prefix', 'prefix_id', 'int(2)', 'NO', 'PRI', '', 'auto_increment');
INSERT INTO `structure` VALUES ('prefix', 'prefix_name', 'varchar(100)', 'NO', '', '', '');
INSERT INTO `structure` VALUES ('product_data', 'data_id', 'int(30)', 'NO', 'PRI', '', 'auto_increment');
INSERT INTO `structure` VALUES ('product_data', 'items_code', 'varchar(255)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('product_data', 'data_value', 'decimal(10,2)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_data', 'data_date', 'date', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('product_data', 'data_shift', 'varchar(250)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('product_data', 'data_user', 'varchar(255)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_data', 'data_dept', 'int(255)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_data', 'create_date', 'datetime', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_data', 'last_update', 'timestamp', 'YES', '', '', 'on update CURRENT_TIMESTAMP');
INSERT INTO `structure` VALUES ('product_form', 'form_code', 'varchar(5)', 'NO', 'PRI', '', '');
INSERT INTO `structure` VALUES ('product_form', 'form_name', 'varchar(255)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('product_form', 'form_view', 'enum(\'products\',\'operative\')', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_form', 'form_note', 'varchar(255)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_form', 'form_frequency', 'enum(\'days\',\'month\',\'year\')', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_form', 'form_create_date', 'datetime', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_form', 'form_last_update', 'timestamp', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_form', 'index', 'varchar(50)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('product_form', 'status', 'enum(\'N\',\'Y\')', 'YES', '', 'Y', '');
INSERT INTO `structure` VALUES ('product_form_depart', 'form_depart_id', 'int(2)', 'NO', 'PRI', '', 'auto_increment');
INSERT INTO `structure` VALUES ('product_form_depart', 'form_code', 'varchar(5)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('product_form_depart', 'depart_id', 'int(2)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('product_items', 'items_code', 'varchar(10)', 'NO', 'PRI', '', '');
INSERT INTO `structure` VALUES ('product_items', 'items_name', 'varchar(255)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('product_items', 'items_type', 'enum(\'value\',\'sum\',\'function\')', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_items', 'items_formula', 'varchar(255)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_items', 'items_form', 'varchar(4)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_items', 'items_form_input', 'enum(\'number\',\'text\',\'select\')', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_items', 'items_form_input_readonly', 'enum(\'N\',\'Y\')', 'YES', '', 'N', '');
INSERT INTO `structure` VALUES ('product_items', 'items_font_bold', 'enum(\'N\',\'Y\')', 'YES', '', 'N', '');
INSERT INTO `structure` VALUES ('product_items', 'items_code_number', 'varchar(4)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_items', 'items_not_null', 'enum(\'Y\',\'N\')', 'YES', '', 'N', '');
INSERT INTO `structure` VALUES ('product_items', 'items_index', 'int(255)', 'YES', 'MUL', '0', '');
INSERT INTO `structure` VALUES ('product_items', 'items_status', 'enum(\'N\',\'Y\')', 'YES', '', 'Y', '');
INSERT INTO `structure` VALUES ('product_items', 'create_date', 'datetime', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_items', 'items_last_update', 'datetime', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_shift', 'form_code', 'varchar(20)', 'NO', 'PRI', '', '');
INSERT INTO `structure` VALUES ('product_shift', 'shift', 'enum(\'morning\',\'afternoon\',\'midnight\',\'intime\',\'outtime\')', 'NO', 'PRI', '', '');
INSERT INTO `structure` VALUES ('product_shift', 'status', 'enum(\'N\',\'Y\')', 'YES', '', 'Y', '');
INSERT INTO `structure` VALUES ('product_shift', 'sort', 'varchar(255)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('product_shift', 'hos_guid', 'varchar(38)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_shift_color', 'product_shift', 'enum(\'ช\',\'บ\',\'ด\')', 'NO', 'PRI', '', '');
INSERT INTO `structure` VALUES ('product_shift_color', 'product_shift_color', 'varchar(20)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_shift_color', 'sort', 'int(2)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('product_shift_color', 'hos_guid', 'varchar(38)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('shift_name', 'shift', 'enum(\'outtime\',\'intime\',\'midnight\',\'afternoon\',\'morning\')', 'NO', 'PRI', '', '');
INSERT INTO `structure` VALUES ('shift_name', 'shift_name', 'varchar(255)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('shift_name', 'status', 'enum(\'N\',\'Y\')', 'YES', '', 'Y', '');
INSERT INTO `structure` VALUES ('shift_name', 'sort', 'varchar(255)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('shift_name', 'hos_guid', 'varchar(38)', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('summary_report', 'summary_report_id', 'int(11)', 'NO', 'PRI', '', 'auto_increment');
INSERT INTO `structure` VALUES ('summary_report', 'items_code', 'varchar(10)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('summary_report', 'items_form', 'varchar(4)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('summary_report', 'summary_report_name', 'enum(\'reportsPerDays\',\'reportsPerMonths\',\'reportsPerYear\')', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('summary_report', 'items_index', 'varchar(255)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('summary_report', 'items_status', 'enum(\'N\',\'Y\')', 'YES', '', 'Y', '');
INSERT INTO `structure` VALUES ('summary_report', 'create_date', 'datetime', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('summary_report', 'last_update', 'datetime', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('ward', 'ward', 'varchar(4)', 'NO', 'PRI', '', '');
INSERT INTO `structure` VALUES ('ward', 'name', 'varchar(250)', 'YES', 'MUL', '', '');
INSERT INTO `structure` VALUES ('ward', 'status', 'enum(\'Y\',\'N\')', 'YES', '', '', '');
INSERT INTO `structure` VALUES ('ward', 'hos_guid', 'varchar(38)', 'YES', 'MUL', '', '');
