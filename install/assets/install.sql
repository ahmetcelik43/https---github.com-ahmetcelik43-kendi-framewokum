CREATE TABLE `members` (
  `member_id` int(11) NOT NULL,
  `member_name` varchar(255) NOT NULL,
  `member_email` varchar(255) NOT NULL,
  `member_password` varchar(255) NOT NULL,
  `member_status` tinyint(1) NOT NULL DEFAULT 1,
  `member_created_at` datetime NOT NULL,
  `member_updated_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `permissions` (
  `permissionid` int(11) NOT NULL,
  `permissionname` varchar(255) NOT NULL,
  `permissions` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


CREATE TABLE `users` (
  `userid` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `useremail` varchar(255) NOT NULL,
  `userpermission` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE `members`
  ADD PRIMARY KEY (`member_id`);

ALTER TABLE `permissions`
  ADD PRIMARY KEY (`permissionid`);

ALTER TABLE `users`
  ADD PRIMARY KEY (`userid`);

ALTER TABLE `members`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `permissions`
  MODIFY `permissionid` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `users`
  MODIFY `userid` int(11) NOT NULL AUTO_INCREMENT;
