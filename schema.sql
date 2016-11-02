

CREATE TABLE `user` (
  `id` INT PRIMARY KEY AUTO_INCREMENT,
  `username` VARCHAR(63) DEFAULT '',
  `password` VARCHAR(127) DEFAULT '',
  `power` INT DEFAULT 1,
  `status` INT DEFAULT 0,
  `remark` VARCHAR(1023) DEFAULT ''
);

INSERT INTO `user` (`username`, `password`, `power`) VALUES ('admin', '30ea328eb728bcd6823825f99032d3de', 0);

















