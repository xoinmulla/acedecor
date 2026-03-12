--
-- Stand-in structure for view `availableqty`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `availableqty`;
CREATE TABLE IF NOT EXISTS `availableqty` (
`AvailableQty` decimal(33,0)
,`MONTH` varchar(9)
);

-- Stand-in structure for view `customerbalanceamt`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `customerbalanceamt`;
CREATE TABLE IF NOT EXISTS `customerbalanceamt` (
`Total` decimal(33,0)
,`Id` varchar(100)
,`CustomerId` varchar(100)
);

--
-- Stand-in structure for view `customerlastm`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `customerlastm`;
CREATE TABLE IF NOT EXISTS `customerlastm` (
`Customers` bigint
,`MONTH` varchar(9)
);

--
-- Stand-in structure for view `customerpaymentlastq`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `customerpaymentlastq`;
CREATE TABLE IF NOT EXISTS `customerpaymentlastq` (
`ReceivedAmt` decimal(32,0)
,`MONTH` varchar(9)
);

--
-- Stand-in structure for view `enquirylastm`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `enquirylastm`;
CREATE TABLE IF NOT EXISTS `enquirylastm` (
`Enquiries` bigint
,`MONTH` varchar(9)
);

--
-- Stand-in structure for view `inwardedlastq`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `inwardedlastq`;
CREATE TABLE IF NOT EXISTS `inwardedlastq` (
`ReceivedQty` decimal(32,0)
,`MONTH` varchar(9)
);

--
-- Stand-in structure for view `projectslastm`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `projectslastm`;
CREATE TABLE IF NOT EXISTS `projectslastm` (
`Projects` bigint
,`MONTH` varchar(9)
);

--
-- Stand-in structure for view `supplierbalanceamt`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `supplierbalanceamt`;
CREATE TABLE IF NOT EXISTS `supplierbalanceamt` (
`Total` decimal(33,0)
,`Id` int
,`Supplier_id` int
);

--
-- Stand-in structure for view `supplierpaymentlastq`
-- (See below for the actual view)
--
DROP VIEW IF EXISTS `supplierpaymentlastq`;
CREATE TABLE IF NOT EXISTS `supplierpaymentlastq` (
`PaidAmt` decimal(32,0)
,`MONTH` varchar(9)
);

--
-- Structure for view `availableqty`
--
DROP TABLE IF EXISTS `availableqty`;

DROP VIEW IF EXISTS `availableqty`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `availableqty`  AS SELECT (sum(`s`.`ReceivedQty`) - `a`.`AllocatedQty`) AS `AvailableQty`, monthname((now() + interval -(2) month)) AS `MONTH` FROM (`item_stock` `s` join `itemallocation` `a`) WHERE (monthname(`s`.`modifiedOn`) = monthname((now() + interval -(2) month)))union select (sum(`s`.`ReceivedQty`) - `a`.`AllocatedQty`) AS `AvailableQty`,monthname((now() + interval -(1) month)) AS `MONTH` from (`item_stock` `s` join `itemallocation` `a`) where (monthname(`s`.`modifiedOn`) = monthname((now() + interval -(1) month))) union select (sum(`s`.`ReceivedQty`) - `a`.`AllocatedQty`) AS `AvailableQty`,monthname((now() - 1)) AS `MONTH` from (`item_stock` `s` join `itemallocation` `a`) where (monthname(`s`.`modifiedOn`) = monthname((now() - 1)))  ;

-- --------------------------------------------------------

--
-- Structure for view `customerbalanceamt`
--
DROP TABLE IF EXISTS `customerbalanceamt`;

DROP VIEW IF EXISTS `customerbalanceamt`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customerbalanceamt`  AS SELECT (sum(`cp`.`total_amount`) - sum(`cp`.`received_amount`)) AS `Total`, `cp`.`customer_id` AS `Id`, `c`.`customerCode` AS `CustomerId` FROM (`customerpaymentinfo` `cp` join `customer` `c` on((convert(`c`.`customerCode` using utf8mb3) = `cp`.`customer_id`))) ;

-- --------------------------------------------------------

--
-- Structure for view `customerlastm`
--
DROP TABLE IF EXISTS `customerlastm`;

DROP VIEW IF EXISTS `customerlastm`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customerlastm`  AS SELECT count(0) AS `Customers`, monthname((now() + interval -(2) month)) AS `MONTH` FROM `quotation_details` WHERE ((monthname(`quotation_details`.`modifiedon`) = monthname((now() + interval -(2) month))) AND (`quotation_details`.`quo_status` = 'Approved'))union select count(0) AS `Customers`,monthname((now() + interval -(1) month)) AS `MONTH` from `quotation_details` where ((monthname(`quotation_details`.`modifiedon`) = monthname((now() + interval -(1) month))) and (`quotation_details`.`quo_status` = 'Approved')) union select count(0) AS `Customers`,monthname((now() - 1)) AS `MONTH` from `quotation_details` where ((monthname(`quotation_details`.`modifiedon`) = monthname((now() - 1))) and (`quotation_details`.`quo_status` = 'Approved'))  ;

-- --------------------------------------------------------

--
-- Structure for view `customerpaymentlastq`
--
DROP TABLE IF EXISTS `customerpaymentlastq`;

DROP VIEW IF EXISTS `customerpaymentlastq`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `customerpaymentlastq`  AS SELECT sum(`customerpaymentinfo`.`received_amount`) AS `ReceivedAmt`, monthname((now() + interval -(2) month)) AS `MONTH` FROM `customerpaymentinfo` WHERE (monthname(`customerpaymentinfo`.`modifieddate`) = monthname((now() + interval -(2) month)))union select sum(`customerpaymentinfo`.`received_amount`) AS `ReceivedAmt`,monthname((now() + interval -(1) month)) AS `MONTH` from `customerpaymentinfo` where (monthname(`customerpaymentinfo`.`modifieddate`) = monthname((now() + interval -(1) month))) union select sum(`customerpaymentinfo`.`received_amount`) AS `ReceivedAmt`,monthname((now() - 1)) AS `MONTH` from `customerpaymentinfo` where (monthname(`customerpaymentinfo`.`modifieddate`) = monthname((now() - 1)))  ;

-- --------------------------------------------------------

--
-- Structure for view `enquirylastm`
--
DROP TABLE IF EXISTS `enquirylastm`;

DROP VIEW IF EXISTS `enquirylastm`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `enquirylastm`  AS SELECT count(0) AS `Enquiries`, monthname((now() + interval -(2) month)) AS `MONTH` FROM `enquiry_details` WHERE (monthname(`enquiry_details`.`enq_createdOn`) = monthname((now() + interval -(2) month)))union select count(0) AS `Enqueries`,monthname((now() + interval -(1) month)) AS `MONTH` from `enquiry_details` where (monthname(`enquiry_details`.`enq_createdOn`) = monthname((now() + interval -(1) month))) union select count(0) AS `Enqueries`,monthname((now() - 1)) AS `MONTH` from `enquiry_details` where (monthname(`enquiry_details`.`enq_createdOn`) = monthname((now() - 1)))  ;

-- --------------------------------------------------------

--
-- Structure for view `inwardedlastq`
--
DROP TABLE IF EXISTS `inwardedlastq`;

DROP VIEW IF EXISTS `inwardedlastq`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `inwardedlastq`  AS SELECT sum(`item_stock`.`ReceivedQty`) AS `ReceivedQty`, monthname((now() + interval -(2) month)) AS `MONTH` FROM `item_stock` WHERE (monthname(`item_stock`.`modifiedOn`) = monthname((now() + interval -(2) month)))union select sum(`item_stock`.`ReceivedQty`) AS `ReceivedQty`,monthname((now() + interval -(1) month)) AS `MONTH` from `item_stock` where (monthname(`item_stock`.`modifiedOn`) = monthname((now() + interval -(1) month))) union select sum(`item_stock`.`ReceivedQty`) AS `ReceivedQty`,monthname((now() - 1)) AS `MONTH` from `item_stock` where (monthname(`item_stock`.`modifiedOn`) = monthname((now() - 1)))  ;

-- --------------------------------------------------------

--
-- Structure for view `projectslastm`
--
DROP TABLE IF EXISTS `projectslastm`;

DROP VIEW IF EXISTS `projectslastm`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `projectslastm`  AS SELECT count(0) AS `Projects`, monthname((now() + interval -(2) month)) AS `MONTH` FROM `projects` WHERE ((`projects`.`project_status` = 'Completed') AND (monthname(`projects`.`createdOn`) = monthname((now() + interval -(2) month))))union select count(0) AS `Projects`,monthname((now() + interval -(1) month)) AS `MONTH` from `projects` where ((`projects`.`project_status` = 'Completed') and (monthname(`projects`.`createdOn`) = monthname((now() + interval -(1) month)))) union select count(0) AS `Projects`,monthname((now() - 1)) AS `MONTH` from `projects` where ((`projects`.`project_status` = 'Completed') and (monthname(`projects`.`createdOn`) = monthname((now() - 1))))  ;

-- --------------------------------------------------------

--
-- Structure for view `supplierbalanceamt`
--
DROP TABLE IF EXISTS `supplierbalanceamt`;

DROP VIEW IF EXISTS `supplierbalanceamt`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `supplierbalanceamt`  AS SELECT (`sp`.`total_amount` - sum(`sp`.`received_amount`)) AS `Total`, `sp`.`supplierId` AS `Id`, `s`.`item_compid` AS `Supplier_id` FROM (`supplierpaymentinfo` `sp` join `item_companydetails` `s` on((convert(`s`.`item_compid` using utf8mb3) = `sp`.`supplierId`))) GROUP BY `Id` ;

-- --------------------------------------------------------

--
-- Structure for view `supplierpaymentlastq`
--
DROP TABLE IF EXISTS `supplierpaymentlastq`;

DROP VIEW IF EXISTS `supplierpaymentlastq`;
CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `supplierpaymentlastq`  AS SELECT sum(`supplierpaymentinfo`.`received_amount`) AS `PaidAmt`, monthname((now() + interval -(2) month)) AS `MONTH` FROM `supplierpaymentinfo` WHERE (monthname(`supplierpaymentinfo`.`modifieddate`) = monthname((now() + interval -(2) month)))union select sum(`supplierpaymentinfo`.`received_amount`) AS `PaidAmt`,monthname((now() + interval -(1) month)) AS `MONTH` from `supplierpaymentinfo` where (monthname(`supplierpaymentinfo`.`modifieddate`) = monthname((now() + interval -(1) month))) union select sum(`supplierpaymentinfo`.`received_amount`) AS `PaidAmt`,monthname((now() - 1)) AS `MONTH` from `supplierpaymentinfo` where (monthname(`supplierpaymentinfo`.`modifieddate`) = monthname((now() - 1)))  ;
COMMIT;