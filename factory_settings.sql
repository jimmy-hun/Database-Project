CREATE TABLE MEMBERS
(
  id INT NOT NULL AUTO_INCREMENT,
  member_gname VARCHAR(20) NOT NULL,
  member_mname VARCHAR(20) NULL,
  member_fname VARCHAR(20) NOT NULL,
  member_address VARCHAR(100) NOT NULL,
  member_postcode INT(4) NOT NULL,
  member_email VARCHAR(100) NOT NULL,
  member_phone INT(10) NOT NULL,
  member_mobile INT(10) NOT NULL,
  active tinyint(1) NOT NULL DEFAULT '0',
  CONSTRAINT member_PK PRIMARY KEY (id)
);

CREATE TABLE ROLES (
  id INT NOT NULL  AUTO_INCREMENT PRIMARY KEY,
  role_name VARCHAR(128) NOT NULL,
  role_desc VARCHAR(200) NULL
);

CREATE TABLE USERS (
  id INT UNSIGNED AUTO_INCREMENT,
  member_id INT NOT NULL,
  role_id INT NOT NULL,
  password VARCHAR(128) NOT NULL,
  email VARCHAR(128) NOT NULL,
  created DATETIME DEFAULT NULL,
  modified DATETIME DEFAULT NULL,
  active tinyint(1) NOT NULL DEFAULT '1',
  CONSTRAINT user_PK PRIMARY KEY (id),
  CONSTRAINT user_FK1 FOREIGN KEY (member_id) REFERENCES MEMBERS(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT user_FK2 FOREIGN KEY (role_id) REFERENCES ROLES(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE COURSES
(
  id INT NOT NULL AUTO_INCREMENT,
  course_code VARCHAR(8) NOT NULL,
  course_name VARCHAR(50) NOT NULL,
  description VARCHAR(1000) NOT NULL,
  max_enrol_limit INT(3) NOT NULL,
  current_enrolled INT(3) NOT NULL,
  difficulty VARCHAR(20) NOT NULL,
  essentials VARCHAR(500) NOT NULL,
  active tinyint(1) NOT NULL DEFAULT '1',
  CONSTRAINT course_PK PRIMARY KEY (id)
);

CREATE TABLE COURSEENROLMENTS
(
  id INT NOT NULL AUTO_INCREMENT,
  course_id INT NOT NULL,
  member_id INT NOT NULL,
  status VARCHAR(100) NOT NULL,
  grade VARCHAR(3) NULL,
  created DATETIME DEFAULT NULL,
  modified DATETIME DEFAULT NULL,
  active tinyint(1) NOT NULL DEFAULT '1',
  CONSTRAINT courseenrolments_PK PRIMARY KEY (id),
  CONSTRAINT courseenrolments_FK1 FOREIGN KEY (course_id) REFERENCES COURSES(id) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT courseenrolments_FK2 FOREIGN KEY (member_id) REFERENCES MEMBERS(id) ON DELETE CASCADE ON UPDATE CASCADE
);

CREATE TABLE `token_hash` (
  `User_id` int(10) unsigned NOT NULL,
  `hash` varchar(100) DEFAULT NULL,
  `datetime` datetime NOT NULL,
  UNIQUE KEY `User_id_2` (`User_id`),
  KEY `User_id` (`User_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `token_hash` ADD CONSTRAINT `token_hash_ibfk_1` FOREIGN KEY (`User_id`) REFERENCES `USERS` (`id`) ON DELETE CASCADE;

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `hash` varchar(255) DEFAULT NULL,
  `data` varchar(255) DEFAULT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `hashs` (`hash`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


/* For ACL Extras... modifying things related to ACL Extras can cause severe problems !!! */
CREATE TABLE acos (
  id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  parent_id INTEGER(10) DEFAULT NULL,
  model VARCHAR(255) DEFAULT '',
  foreign_key INTEGER(10) UNSIGNED DEFAULT NULL,
  alias VARCHAR(255) DEFAULT '',
  lft INTEGER(10) DEFAULT NULL,
  rght INTEGER(10) DEFAULT NULL,
  PRIMARY KEY  (id)
);

CREATE TABLE aros_acos (
  id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  aro_id INTEGER(10) UNSIGNED NOT NULL,
  aco_id INTEGER(10) UNSIGNED NOT NULL,
  _create CHAR(2) NOT NULL DEFAULT 0,
  _read CHAR(2) NOT NULL DEFAULT 0,
  _update CHAR(2) NOT NULL DEFAULT 0,
  _delete CHAR(2) NOT NULL DEFAULT 0,
  PRIMARY KEY(id)
);

CREATE TABLE aros (
  id INTEGER(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  parent_id INTEGER(10) DEFAULT NULL,
  model VARCHAR(255) DEFAULT '',
  foreign_key INTEGER(10) UNSIGNED DEFAULT NULL,
  alias VARCHAR(255) DEFAULT '',
  lft INTEGER(10) DEFAULT NULL,
  rght INTEGER(10) DEFAULT NULL,
  PRIMARY KEY  (id)
);

/* MySQL Triggers */
delimiter //
CREATE TRIGGER `increment` BEFORE INSERT ON `courseenrolments`
 FOR EACH ROW begin
update courses
set current_enrolled = current_enrolled + 1
where courses.id = NEW.course_id;
end;//
delimiter ;

delimiter //
CREATE TRIGGER `decrement` BEFORE DELETE ON `courseenrolments`
 FOR EACH ROW begin
update courses
set current_enrolled = current_enrolled - 1
where courses.id = OLD.course_id;
end;//
delimiter ;

delimiter //
CREATE TRIGGER `member_email_update` BEFORE UPDATE ON `users`
 FOR EACH ROW begin
update members
set member_email = NEW.email
where members.id = OLD.member_id;
end;//
delimiter ;

/* U3A Roles */
INSERT INTO `roles` (`id`, `role_name`, `role_desc`) VALUES
(1, 'Super User', 'Super Users have full access to every function.'),
(2, 'Office Volunteer', 'Office Volunteers have the same privileges as the Super User but is unable to delete records.'),
(3, 'Course Conveyor', 'Course Conveyors are in charge of managing courses: adding, modifying and removing.'),
(4, 'Teaching Staff', 'Teaching Staff are in charge of keeping track of Members enrolled in their assigned Courses. This includes marking and specifying their current status in the Course.'),
(5, 'Member', 'Members will make up most of U3A as they are the majority which enroll in Courses. They will also be able to view their own profile.');

/* AROS Role Table */
INSERT INTO `aros` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, 'Role', 1, '', 1, 2),
(2, NULL, 'Role', 2, '', 3, 4),
(3, NULL, 'Role', 3, '', 5, 6),
(4, NULL, 'Role', 4, '', 7, 8),
(5, NULL, 'Role', 5, '', 9, 10);

/* ACOS Role Table */
INSERT INTO `acos` (`id`, `parent_id`, `model`, `foreign_key`, `alias`, `lft`, `rght`) VALUES
(1, NULL, NULL, NULL, 'controllers', 1, 116),
(2, 1, NULL, NULL, 'Courseenrolments', 2, 13),
(3, 2, NULL, NULL, 'course_members', 3, 4),
(4, 2, NULL, NULL, 'add', 5, 6),
(5, 2, NULL, NULL, 'edit', 7, 8),
(6, 2, NULL, NULL, 'delete', 9, 10),
(7, 2, NULL, NULL, 'isAuthorized', 11, 12),
(8, 1, NULL, NULL, 'Courses', 14, 37),
(9, 8, NULL, NULL, 'index', 15, 16),
(10, 8, NULL, NULL, 'detailedcourse', 17, 18),
(11, 8, NULL, NULL, 'add', 19, 20),
(12, 8, NULL, NULL, 'enroll_now', 21, 22),
(13, 8, NULL, NULL, 'delete_enroll', 23, 24),
(14, 8, NULL, NULL, 're_enroll', 25, 26),
(15, 8, NULL, NULL, 'cancel_enroll', 27, 28),
(16, 8, NULL, NULL, 'edit', 29, 30),
(17, 8, NULL, NULL, 'delete', 31, 32),
(18, 8, NULL, NULL, 'reactivate', 33, 34),
(19, 8, NULL, NULL, 'isAuthorized', 35, 36),
(20, 1, NULL, NULL, 'Members', 38, 61),
(21, 20, NULL, NULL, 'index', 39, 40),
(22, 20, NULL, NULL, 'inactive_list', 41, 42),
(23, 20, NULL, NULL, 'activate', 43, 44),
(24, 20, NULL, NULL, 'deactivate', 45, 46),
(25, 20, NULL, NULL, 'detailedmember', 47, 48),
(26, 20, NULL, NULL, 'add', 49, 50),
(27, 20, NULL, NULL, 'edit', 51, 52),
(28, 20, NULL, NULL, 'edit_profile', 53, 54),
(29, 20, NULL, NULL, 'delete', 55, 56),
(30, 20, NULL, NULL, 'profile', 57, 58),
(31, 20, NULL, NULL, 'isAuthorized', 59, 60),
(32, 1, NULL, NULL, 'Pages', 62, 69),
(33, 32, NULL, NULL, 'display', 63, 64),
(34, 32, NULL, NULL, 'logout', 65, 66),
(35, 32, NULL, NULL, 'isAuthorized', 67, 68),
(36, 1, NULL, NULL, 'Roles', 70, 83),
(37, 36, NULL, NULL, 'index', 71, 72),
(38, 36, NULL, NULL, 'view', 73, 74),
(39, 36, NULL, NULL, 'add', 75, 76),
(40, 36, NULL, NULL, 'edit', 77, 78),
(41, 36, NULL, NULL, 'delete', 79, 80),
(42, 36, NULL, NULL, 'isAuthorized', 81, 82),
(43, 1, NULL, NULL, 'Users', 84, 113),
(44, 43, NULL, NULL, 'login', 85, 86),
(45, 43, NULL, NULL, 'logout', 87, 88),
(46, 43, NULL, NULL, 'add', 89, 90),
(47, 43, NULL, NULL, 'add_account', 91, 92),
(48, 43, NULL, NULL, 'change_password', 93, 94),
(49, 43, NULL, NULL, 'change_email', 95, 96),
(50, 43, NULL, NULL, 'delete', 97, 98),
(51, 43, NULL, NULL, 'activate', 99, 100),
(52, 43, NULL, NULL, 'randomPassword', 101, 102),
(53, 43, NULL, NULL, 'reset_password', 103, 104),
(54, 43, NULL, NULL, 'reset', 105, 106),
(55, 43, NULL, NULL, 'forgot', 107, 108),
(56, 43, NULL, NULL, 'initDB', 109, 110),
(57, 43, NULL, NULL, 'isAuthorized', 111, 112),
(58, 1, NULL, NULL, 'AclExtras', 114, 115);

/* AROS_ACOS Role Table */
INSERT INTO `aros_acos` (`id`, `aro_id`, `aco_id`, `_create`, `_read`, `_update`, `_delete`) VALUES
(1, 1, 1, '1', '1', '1', '1'),
(2, 2, 1, '1', '1', '1', '1'),
(3, 2, 29, '-1', '-1', '-1', '-1'),
(4, 2, 50, '-1', '-1', '-1', '-1'),
(5, 2, 41, '-1', '-1', '-1', '-1'),
(6, 2, 17, '-1', '-1', '-1', '-1'),
(7, 2, 6, '-1', '-1', '-1', '-1'),
(8, 3, 1, '1', '1', '1', '1'),
(9, 3, 8, '1', '1', '1', '1'),
(10, 3, 20, '-1', '-1', '-1', '-1'),
(11, 3, 21, '1', '1', '1', '1'),
(12, 3, 30, '1', '1', '1', '1'),
(13, 3, 28, '1', '1', '1', '1'),
(14, 3, 25, '1', '1', '1', '1'),
(15, 3, 2, '-1', '-1', '-1', '-1'),
(16, 3, 3, '1', '1', '1', '1'),
(17, 3, 5, '1', '1', '1', '1'),
(18, 3, 36, '-1', '-1', '-1', '-1'),
(19, 3, 43, '-1', '-1', '-1', '-1'),
(20, 4, 1, '1', '1', '1', '1'),
(21, 4, 2, '-1', '-1', '-1', '-1'),
(22, 4, 3, '1', '1', '1', '1'),
(23, 4, 5, '1', '1', '1', '1'),
(24, 4, 20, '-1', '-1', '-1', '-1'),
(25, 4, 30, '1', '1', '1', '1'),
(26, 4, 28, '1', '1', '1', '1'),
(27, 4, 25, '1', '1', '1', '1'),
(28, 4, 8, '-1', '-1', '-1', '-1'),
(29, 4, 9, '1', '1', '1', '1'),
(30, 4, 10, '1', '1', '1', '1'),
(31, 4, 12, '1', '1', '1', '1'),
(32, 4, 14, '1', '1', '1', '1'),
(33, 4, 15, '1', '1', '1', '1'),
(34, 4, 36, '-1', '-1', '-1', '-1'),
(35, 4, 43, '-1', '-1', '-1', '-1'),
(36, 5, 1, '1', '1', '1', '1'),
(37, 5, 20, '-1', '-1', '-1', '-1'),
(38, 5, 30, '1', '1', '1', '1'),
(39, 5, 28, '1', '1', '1', '1'),
(40, 5, 8, '-1', '-1', '-1', '-1'),
(41, 5, 9, '1', '1', '1', '1'),
(42, 5, 10, '1', '1', '1', '1'),
(43, 5, 12, '1', '1', '1', '1'),
(44, 5, 14, '1', '1', '1', '1'),
(45, 5, 15, '1', '1', '1', '1'),
(46, 5, 2, '-1', '-1', '-1', '-1'),
(47, 5, 36, '-1', '-1', '-1', '-1'),
(48, 5, 43, '-1', '-1', '-1', '-1');

/* Initial Super User Member Record */
INSERT INTO `members` (`id`, `member_gname`, `member_mname`, `member_fname`, `member_address`, `member_postcode`, `member_email`, `member_phone`, `member_mobile`, `active`) VALUES
(1, 'Super', '', 'User', 'U3A', 3174, 'u3a@u3a.com', 11111111, 1111111111, 0);

/* Initial Super User Account Record */
INSERT INTO `users` (`id`, `member_id`, `role_id`, `password`, `email`, `created`, `modified`, `active`) VALUES
(1, 1, 1, 'c4c3d30bf78bf34235c2949ae82387a1f0d75523', 'u3a@u3a.com', '2014-10-26 21:25:19', '2014-10-26 21:25:19', 1);