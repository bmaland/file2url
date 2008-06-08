CREATE TABLE users (
    id SERIAL,

    api_key VARCHAR(64) NOT NULL,
    email VARCHAR(255) NOT NULL,

    CONSTRAINT pk_entrywords PRIMARY KEY (id),
    CONSTRAINT u_api_key UNIQUE (api_key),
    CONSTRAINT u_email UNIQUE (email)
);

CREATE TABLE files (
    id SERIAL,

    user_id integer NOT NULL,

    access_code CHAR(5) NOT NULL,

    file_name VARCHAR(255) NOT NULL,

    active smallint NOT NULL DEFAULT 1,

    upload_ip VARCHAR(15) NOT NULL,

    upload_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT pk_files PRIMARY KEY (id),
    CONSTRAINT u_access_code UNIQUE (access_code),
    CONSTRAINT fk_file_user FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE
);

CREATE TABLE download_logs (
    id SERIAL,

    file_id integer NOT NULL,

    download_ip VARCHAR(15) NOT NULL,

    download_date TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT pk_download_logs PRIMARY KEY (id),
    CONSTRAINT fk_download_log_file FOREIGN KEY (file_id) REFERENCES files (id) ON DELETE CASCADE
);
