CREATE TABLE blog_users (
    user_id     int(11) NOT NULL AUTO_INCREMENT,
    user_name   varchar(128) NOT NULL,
    user_hash   varchar(128) NOT NULL,
    user_email  varchar(255) NOT NULL,
    user_access int(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (user_id),
    UNIQUE KEY username (user_name)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE blog_categories (
    cat_id      int(11) NOT NULL AUTO_INCREMENT,
    cat_name    varchar(255) NOT NULL,
    PRIMARY KEY (cat_id)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE blog_content (
    cnt_id      int(11) NOT NULL AUTO_INCREMENT,
    cat_id      int(11) NOT NULL,
    user_id     int(11) NOT NULL,
    cnt_title   varchar(255) NOT NULL,
    cnt_body    text NOT NULL,
    cnt_date    timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    publish     int(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (cnt_id),
    FOREIGN KEY (user_id) REFERENCES blog_users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (cat_id) REFERENCES blog_categories(cat_id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;