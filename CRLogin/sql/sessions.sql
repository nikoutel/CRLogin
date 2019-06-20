CREATE TABLE IF NOT EXISTS crl_sessions
(
    id     varchar(32)      NOT NULL default '',
    access int(10) unsigned NOT NULL,
    data   text,
    PRIMARY KEY (id)
) ENGINE = MyISAM