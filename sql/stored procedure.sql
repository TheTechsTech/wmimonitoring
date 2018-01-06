DROP PROCEDURE `stock_computer_by_manufacture`//
CREATE DEFINER=`root`@`localhost` PROCEDURE `stock_computer_by_manufacture`(IN date_start DATETIME, IN date_end DATETIME)
BEGIN
	SELECT DISTINCT(manufacturer) as name,
		(SELECT COUNT(*) FROM computer AS computer_stock WHERE computer_stock.manufacturer=computer.manufacturer AND (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM computer AS computer_stock WHERE computer_stock.manufacturer=computer.manufacturer AND computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM computer AS computer_stock WHERE computer_stock.manufacturer=computer.manufacturer AND computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM computer AS computer_stock WHERE computer_stock.manufacturer=computer.manufacturer AND (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM computer;
END

DROP PROCEDURE `stock_computer_by_os`//
CREATE DEFINER=`root`@`localhost` PROCEDURE `stock_computer_by_os`(IN date_start DATETIME, IN date_end DATETIME)
BEGIN
    SELECT DISTINCT CONCAT(`oscaption`,' SP ', servicepackmajorversion) as name,oscaption,servicepackmajorversion,
		(SELECT COUNT(*) FROM computer AS computer_stock WHERE computer_stock.oscaption=computer.oscaption AND computer_stock.servicepackmajorversion=computer.servicepackmajorversion AND (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM computer AS computer_stock WHERE computer_stock.oscaption=computer.oscaption AND computer_stock.servicepackmajorversion=computer.servicepackmajorversion AND computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM computer AS computer_stock WHERE computer_stock.oscaption=computer.oscaption AND computer_stock.servicepackmajorversion=computer.servicepackmajorversion AND computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM computer AS computer_stock WHERE computer_stock.oscaption=computer.oscaption AND computer_stock.servicepackmajorversion=computer.servicepackmajorversion AND (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM computer;
END

DROP PROCEDURE `stock_harware`//
CREATE DEFINER=`root`@`localhost` PROCEDURE `stock_harware`(IN date_start DATETIME, IN date_end DATETIME)
BEGIN
    SELECT 'base_board' as item,
		(SELECT COUNT(*) FROM base_board AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM base_board AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM base_board AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM base_board AS computer_stock WHERE (computer_stock.status='added' OR computer_stock.status='remove' AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM base_board
    UNION
    SELECT 'cdrom' as item,
		(SELECT COUNT(*) FROM cdrom AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM cdrom AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') OR computer_stock.status='remove' AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM cdrom AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM cdrom AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM cdrom
    UNION
    SELECT 'firewire' as item,
		(SELECT COUNT(*) FROM firewire AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM firewire AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM firewire AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM firewire AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM firewire
    UNION
    SELECT 'floppy' as item,
		(SELECT COUNT(*) FROM floppy AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM floppy AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM floppy AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM floppy AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM floppy
    UNION
    SELECT 'hardisk' as item,
		(SELECT COUNT(*) FROM hardisk AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM hardisk AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM hardisk AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM hardisk AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM hardisk
    UNION
    SELECT 'keyboard' as item,
		(SELECT COUNT(*) FROM keyboard AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM keyboard AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM keyboard AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM keyboard AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM keyboard
    UNION
    SELECT 'logicaldisk' as item,
		(SELECT COUNT(*) FROM logicaldisk AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM logicaldisk AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM logicaldisk AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM logicaldisk AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM logicaldisk
    UNION
    SELECT 'memory' as item,
		(SELECT COUNT(*) FROM memory AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM memory AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM memory AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM memory AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM memory
    UNION
    SELECT 'modem' as item,
		(SELECT COUNT(*) FROM modem AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM modem AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM modem AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM modem AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM modem
    UNION
    SELECT 'monitor' as item,
		(SELECT COUNT(*) FROM monitor AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM monitor AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM monitor AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM monitor AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM monitor
    UNION
    SELECT 'mouse' as item,
		(SELECT COUNT(*) FROM mouse AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM mouse AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM mouse AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM mouse AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM mouse
    UNION
    SELECT 'networkcard' as item,
		(SELECT COUNT(*) FROM networkcard AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM networkcard AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM networkcard AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM networkcard AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM networkcard
    UNION
    SELECT 'printer' as item,
		(SELECT COUNT(*) FROM printer AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM printer AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM printer AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM printer AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM printer
    UNION
    SELECT 'processor' as item,
		(SELECT COUNT(*) FROM processor AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM processor AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM processor AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM processor AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM processor
    UNION
    SELECT 'sound' as item,
		(SELECT COUNT(*) FROM sound AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM sound AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM sound AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM sound AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM sound
    UNION
    SELECT 'usb' as item,
		(SELECT COUNT(*) FROM usb AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM usb AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM usb AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM usb AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM usb
    UNION
    SELECT 'vga' as item,
		(SELECT COUNT(*) FROM vga AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(*) FROM vga AS computer_stock WHERE computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(*) FROM vga AS computer_stock WHERE computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(*) FROM vga AS computer_stock WHERE (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM vga order by item;
END

DROP PROCEDURE `stock_software_by_name`//
CREATE DEFINER=`root`@`localhost` PROCEDURE `stock_software_by_name`(IN date_start DATETIME, IN date_end DATETIME)
BEGIN
    SELECT DISTINCT name,
		(SELECT COUNT(DISTINCT name,hostname) FROM software AS computer_stock WHERE computer_stock.name=software.name AND (computer_stock.status IN ('added','remove') AND dateadded<date_start) OR (computer_stock.status='removed' AND dateremove>date_start AND dateadded<date_start)) AS start_stock,
		(SELECT COUNT(DISTINCT name,hostname) FROM software AS computer_stock WHERE computer_stock.name=software.name AND computer_stock.status IN ('added','remove','removed') AND dateadded BETWEEN date_start AND date_end) AS add_stock,
		(SELECT COUNT(DISTINCT name,hostname) FROM software AS computer_stock WHERE computer_stock.name=software.name AND computer_stock.status='removed' AND dateremove BETWEEN date_start AND date_end) AS remove_stock,
		(SELECT COUNT(DISTINCT name,hostname) FROM software AS computer_stock WHERE computer_stock.name=software.name AND (computer_stock.status IN ('added','remove') AND dateadded<date_end) OR (computer_stock.status='removed' AND dateremove>date_end AND dateadded<date_end)) AS end_stock 
	FROM software order by name;
END

DROP PROCEDURE `trace_report`//
CREATE DEFINER=`root`@`localhost` PROCEDURE `trace_report`(IN year INTEGER(11))
BEGIN
     SELECT 'process_trace' AS type,MONTH(`dateadded`) as month,COUNT(*) AS count FROM `log_process` WHERE `status`='distrusted' AND YEAR(`dateadded`)=year GROUP BY MONTH(`dateadded`) 
     UNION
     SELECT 'registry_trace' AS type,MONTH(`dateadded`) as month,COUNT(*) AS count FROM `registry_trace` WHERE `status`='distrusted' AND YEAR(`dateadded`)=year GROUP BY MONTH(`dateadded`);
END