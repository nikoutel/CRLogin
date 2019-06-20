CREATE TABLE IF NOT EXISTS crl_user
(
    userid   int(11) unsigned NOT NULL auto_increment,
    username varchar(64)      NOT NULL default '',
    spass    varchar(64)      NOT NULL default '',
    usersalt varchar(64)      NOT NULL default '',
    PRIMARY KEY (userid)
) ENGINE = MyISAM