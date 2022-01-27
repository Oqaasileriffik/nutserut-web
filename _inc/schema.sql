PRAGMA auto_vacuum = INCREMENTAL;
PRAGMA case_sensitive_like = ON;
PRAGMA foreign_keys = ON;
PRAGMA journal_mode = WAL;
PRAGMA locking_mode = EXCLUSIVE;
PRAGMA synchronous = NORMAL;
PRAGMA threads = 4;
PRAGMA trusted_schema = OFF;

CREATE TABLE translations (
	t_id INTEGER NOT NULL,
	t_hash TEXT NOT NULL,
	t_pair TEXT NOT NULL,
	t_result TEXT NOT NULL,
	t_ctime INTEGER NOT NULL DEFAULT (strftime('%s', 'now')),
	t_atime INTEGER NOT NULL DEFAULT (strftime('%s', 'now')),
	t_hits INTEGER NOT NULL DEFAULT 0,
	PRIMARY KEY(t_id AUTOINCREMENT),
	UNIQUE(t_hash)
	);

CREATE TABLE shares (
	t_id INTEGER NOT NULL,
	s_slug TEXT NOT NULL,
	s_ctime INTEGER NOT NULL DEFAULT (strftime('%s', 'now')),
	s_ip TEXT NOT NULL,
	PRIMARY KEY(t_id),
	UNIQUE(s_slug),
	FOREIGN KEY(t_id) REFERENCES translations(t_id) ON UPDATE CASCADE ON DELETE CASCADE
	);

CREATE TABLE feedback (
	f_id INTEGER NOT NULL,
	t_id INTEGER NOT NULL,
	f_which INTEGER NOT NULL,
	f_comment TEXT NOT NULL,
	f_email TEXT NOT NULL,
	f_ctime INTEGER NOT NULL DEFAULT (strftime('%s', 'now')),
	f_ip TEXT NOT NULL,
	PRIMARY KEY(f_id AUTOINCREMENT),
	FOREIGN KEY(t_id) REFERENCES translations(t_id) ON UPDATE CASCADE ON DELETE CASCADE
	);
