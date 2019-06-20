CREATE TABLE IF NOT EXISTS crl_challenge
(
    challenge varchar(64) NOT NULL default '',
    sessionid varchar(64) NOT NULL default '',
    timestamp int(11)     NOT NULL default '0'
) ENGINE = MyISAM