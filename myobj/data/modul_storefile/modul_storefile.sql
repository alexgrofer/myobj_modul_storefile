-- Stotage files
CREATE TABLE `setcms_modelarstorefile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `content_file_array` text NOT NULL,
  `createDate` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;