CREATE TABLE c_rotator (
   id int(11) unsigned NOT NULL auto_increment,
   title varchar(200) NOT NULL default '',
   text text NOT NULL,
   image varchar(256) NOT NULL default '',
   link varchar(256) NOT NULL default '',
   PRIMARY KEY (id)
) TYPE=MyISAM;