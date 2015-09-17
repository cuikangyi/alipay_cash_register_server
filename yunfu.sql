-- phpMyAdmin SQL Dump
-- version 4.3.11.1
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Generation Time: 2015-03-21 16:13:21
-- 服务器版本： 5.6.23
-- PHP Version: 5.5.23

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `yunfu`
--

-- --------------------------------------------------------

--
-- 表的结构 `yunfu_admin`
--

CREATE TABLE IF NOT EXISTS `yunfu_admin` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `nickname` varchar(20) NOT NULL,
  `is_admin` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- 表的结构 `yunfu_cashier`
--

CREATE TABLE IF NOT EXISTS `yunfu_cashier` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `cashier_name` varchar(20) NOT NULL,
  `password` varchar(30) NOT NULL,
  `cashier_no` varchar(30) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=MyISAM AUTO_INCREMENT=85 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `yunfu_cashier`
--

INSERT INTO `yunfu_cashier` (`id`, `uid`, `cashier_name`, `password`, `cashier_no`, `status`) VALUES
(1, 1, 'admin', 'admin', '', 1),
(2, 2, '收银员11111', 'aaaaaa', 'test111111', 0),
(3, 2, '收银员1111', 'aaaaaaaaaa', 'test111111', 1),
(5, 2, '001', '1', '1', 1),
(4, 2, '收银员001', 'aaaaaa', '001', 1),
(6, 2, '002', '2', '1', 1),
(7, 0, 'test', 'aaaaaa', '1', 1),
(8, 0, 'test', 'aaaaaa', '312', 0),
(9, 0, 'test', 'aaaaaa', '32131', 0),
(10, 2, 'test', 'aaaaaa', '123', 0),
(11, 2, 'test11', 'aaaaaa', '31231', 1),
(12, 2, 'test', 'aaaaaa', '4342343', 0),
(13, 2, '测试', '1111111', '测试', 0),
(14, 2, '22222', '2222222', '2222222', 0),
(15, 2, 'test', 'aaaaaa', '啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊啊', 1),
(16, 2, 'test', 'aaaaaa', '32131231', 0),
(17, 2, 'aaaa', 'aaaa', 'aaaaa', 1),
(18, 2, '你是谁呀', 'aaaa', 'aaaaaaaa', 1),
(19, 2, '你是谁呀', 'aaaa', 'aaaaaaaa', 1),
(20, 2, '你是谁呀', 'aaaa', 'aaaaaaaa', 1),
(21, 2, '你是谁呀', 'aaaa', 'aaaaaaaa', 1),
(76, 2, '2', '1', '1', 0),
(23, 2, '猜测是', 'aaaaaaaa', 'aaaaaa', 1),
(78, 2, '2', '1', '1', 1),
(67, 2, '1', '3', '2', 1),
(27, 2, 'aaaa', 'aaaa', 'aaaa', 1),
(77, 2, '2', '1', '1', 0),
(30, 2, 'a', 'a', 'a', 0),
(81, 2, 'aaa', 'aaa', 'aaa', 1),
(82, 2, 'a', 'x', 'a', 1),
(83, 2, 'a13231231', 'x123123', 'a12312', 1),
(84, 2, 'aa', 'asdasda', 'asd', 1),
(80, 2, '1', '3', '2', 1),
(42, 2, 'cccqqqqq', 'xcz', 'zzzaaaaaa', 1),
(79, 2, '2', '1222', '1', 1),
(62, 2, 'a', 'c', 'x', 0),
(63, 2, 'a', 'c', 'x', 0),
(64, 2, 'a', 'c', 'x', 0),
(65, 2, 'a', 'c', 'x', 0);

-- --------------------------------------------------------

--
-- 表的结构 `yunfu_config`
--

CREATE TABLE IF NOT EXISTS `yunfu_config` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `partner` varchar(16) NOT NULL,
  `pkey` varchar(32) NOT NULL,
  `pname` varchar(15) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `yunfu_config`
--

INSERT INTO `yunfu_config` (`id`, `uid`, `email`, `partner`, `pkey`, `pname`) VALUES
(1, 1, 'alipay-test20@alipay.com', '2088201565141845', 'sstyxmh3erotgsjpbgukdz2y5dde46o0', '申请编号'),
(2, 2, '123@123.com', '208820156312312', '1111qqqasdasd432423', 'XX公司');

-- --------------------------------------------------------

--
-- 表的结构 `yunfu_device`
--

CREATE TABLE IF NOT EXISTS `yunfu_device` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `device_name` varchar(20) NOT NULL,
  `device_no` varchar(100) NOT NULL,
  `status` tinyint(1) NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=72 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `yunfu_device`
--

INSERT INTO `yunfu_device` (`id`, `uid`, `device_name`, `device_no`, `status`) VALUES
(3, 1, '呵呵', '11113231231', 0),
(4, 2, '12312', 'ab504369-a696-11e4-9442-3085a9726fde', 0),
(5, 2, '测试', 'aea6727b-a696-11e4-9442-3085a9726fde', 0),
(6, 2, '21342423', 'b7ab94aa-a696-11e4-9442-3085a9726fde', 1),
(7, 1, '1', '1', 1),
(8, 1, '2', '3', 1),
(9, 2, '333333333', '4', 0),
(70, 2, 'eqweqw', '17ee1014-ce06-11e4-85b7-fcaa146c7ee4', 1),
(66, 2, 'aaaaa', '096bc866-ce06-11e4-85b7-fcaa146c7ee4', 1),
(64, 2, 'aaaaaaaa', 'aaaa', 1),
(71, 2, '啊', 'ffa477eb-cee4-11e4-85b7-fcaa146c7ee4', 1),
(57, 0, '31231231', '21321312', 1),
(56, 0, '222222222222', '22222222', 0),
(49, 0, '3231', '2138028b-ade0-11e4-90ec-fcaa146c7ee4', 1),
(50, 2, '哈杀手11231', '255deee2-ade0-11e4-90ec-fcaa146c7ee4', 1),
(51, 2, '444', 'ab4fedbb-ae65-11e4-a0e0-fcaa146c7ee4', 0),
(52, 2, '4321231sdasd', 'f581250f-ade5-11e4-90ec-fcaa146c7ee4', 0),
(53, 2, '312', 'fd72de6c-ade6-11e4-90ec-fcaa146c7ee4', 1),
(55, 0, '1111', '111', 1);

-- --------------------------------------------------------

--
-- 表的结构 `yunfu_order`
--

CREATE TABLE IF NOT EXISTS `yunfu_order` (
  `id` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `device_id` int(11) NOT NULL,
  `cashier_id` int(11) NOT NULL,
  `out_trade_no` varchar(64) NOT NULL,
  `subject` varchar(100) NOT NULL,
  `total_fee` decimal(9,2) NOT NULL,
  `result_code` varchar(32) NOT NULL,
  `trade_no` varchar(64) NOT NULL,
  `trade_status` varchar(50) NOT NULL,
  `notify_id` varchar(100) NOT NULL,
  `seller_email` varchar(100) NOT NULL,
  `seller_id` varchar(30) NOT NULL,
  `buyer_email` varchar(100) NOT NULL,
  `buyer_id` varchar(20) NOT NULL,
  `gmt_create` datetime NOT NULL,
  `gmt_payment` datetime NOT NULL
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `yunfu_order`
--

INSERT INTO `yunfu_order` (`id`, `uid`, `device_id`, `cashier_id`, `out_trade_no`, `subject`, `total_fee`, `result_code`, `trade_no`, `trade_status`, `notify_id`, `seller_email`, `seller_id`, `buyer_email`, `buyer_id`, `gmt_create`, `gmt_payment`) VALUES
(1, 2, 1, 1, '11111111111111111111111111', '订单1111', '0.01', 'ORDER_SUCCESS_PAY_INPROCESS', '22222222222222222222222', 'TRADE_SUCCESS', '12312312312312312', '333333@qqq.om', '42341231231243231', '31113@qqq.om', '1242123124', '2015-01-14 00:00:00', '2015-01-14 00:00:00'),
(2, 2, 1, 1, '11111111111111111111111111', '订单1111', '0.01', 'ORDER_SUCCESS_PAY_INPROCESS', '22222222222222222222222', 'TRADE_SUCCESS', '12312312312312312', '333333@qqq.om', '42341231231243231', '31113@qqq.om', '1242123124', '2015-01-14 00:00:00', '2015-01-14 00:00:00'),
(3, 2, 1, 1, '11111111111111111111111111', '订单1111', '0.01', 'ORDER_SUCCESS_PAY_INPROCESS', '22222222222222222222222', 'TRADE_SUCCESS', '12312312312312312', '333333@qqq.om', '42341231231243231', '31113@qqq.om', '1242123124', '2015-01-14 00:00:00', '2015-01-14 00:00:00'),
(4, 2, 1, 1, '3243423423423', '订单234234234', '0.01', 'ORDER_SUCCESS_PAY_INPROCESS', '22222222222222222222222', 'TRADE_SUCCESS', '12312312312312312', '333333@qqq.om', '42341231231243231', '31113@qqq.om', '1242123124', '2015-01-14 00:00:00', '2015-01-14 00:00:00'),
(5, 2, 1, 1, '3243423423423', '订单234234234', '0.01', 'ORDER_SUCCESS_PAY_INPROCESS', '22222222222222222222222', 'TRADE_SUCCESS', '12312312312312312', '333333@qqq.om', '42341231231243231', '31113@qqq.om', '1242123124', '2015-01-14 00:00:00', '2015-01-14 00:00:00'),
(6, 2, 1, 1, '3243423423423', '订单234234234', '0.01', 'ORDER_SUCCESS_PAY_INPROCESS', '22222222222222222222222', 'TRADE_SUCCESS', '12312312312312312', '333333@qqq.om', '42341231231243231', '31113@qqq.om', '1242123124', '2015-01-14 00:00:00', '2015-01-14 00:00:00'),
(7, 2, 1, 1, '3243423423423', '订单234234234', '0.01', 'ORDER_SUCCESS_PAY_INPROCESS', '22222222222222222222222', 'TRADE_SUCCESS', '12312312312312312', '333333@qqq.om', '42341231231243231', '31113@qqq.om', '1242123124', '2015-01-14 00:00:00', '2015-01-14 00:00:00'),
(8, 2, 1, 1, '3243423423423', '订单234234234', '0.01', 'ORDER_SUCCESS_PAY_INPROCESS', '22222222222222222222222', 'TRADE_SUCCESS', '12312312312312312', '333333@qqq.om', '42341231231243231', '31113@qqq.om', '1242123124', '2015-01-14 00:00:00', '2015-01-14 00:00:00'),
(9, 2, 1, 1, '3243423423423', '订单234234234', '0.01', 'ORDER_SUCCESS_PAY_INPROCESS', '22222222222222222222222', 'TRADE_SUCCESS', '12312312312312312', '333333@qqq.om', '42341231231243231', '31113@qqq.om', '1242123124', '2015-01-14 00:00:00', '2015-01-14 00:00:00'),
(10, 2, 1, 1, '3243423423423', '订单234234234', '0.01', 'ORDER_SUCCESS_PAY_INPROCESS', '22222222222222222222222', 'TRADE_SUCCESS', '12312312312312312', '333333@qqq.om', '42341231231243231', '31113@qqq.om', '1242123124', '2015-01-14 00:00:00', '2015-01-14 00:00:00'),
(11, 2, 1, 1, '3243423423423', '订单234234234', '0.01', 'ORDER_SUCCESS_PAY_INPROCESS', '22222222222222222222222', 'TRADE_SUCCESS', '12312312312312312', '333333@qqq.om', '42341231231243231', '31113@qqq.om', '1242123124', '2015-01-14 00:00:00', '2015-01-14 00:00:00'),
(12, 2, 1, 1, '3243423423423', '订单234234234', '0.01', 'ORDER_SUCCESS_PAY_INPROCESS', '22222222222222222222222', 'TRADE_SUCCESS', '12312312312312312', '333333@qqq.om', '42341231231243231', '31113@qqq.om', '1242123124', '2015-01-14 00:00:00', '2015-01-14 00:00:00'),
(13, 2, 1, 1, '3243423423423', '订单234234234', '0.01', 'ORDER_SUCCESS_PAY_INPROCESS', '22222222222222222222222', 'TRADE_SUCCESS', '12312312312312312', '333333@qqq.om', '42341231231243231', '31113@qqq.om', '1242123124', '2015-01-14 00:00:00', '2015-01-14 00:00:00'),
(14, 2, 1, 1, '3243423423423', '订单234234234', '0.01', 'ORDER_SUCCESS_PAY_INPROCESS', '22222222222222222222222', 'TRADE_SUCCESS', '12312312312312312', '333333@qqq.om', '42341231231243231', '31113@qqq.om', '1242123124', '2015-01-14 00:00:00', '2015-01-14 00:00:00');

-- --------------------------------------------------------

--
-- 表的结构 `yunfu_user`
--

CREATE TABLE IF NOT EXISTS `yunfu_user` (
  `id` int(11) NOT NULL,
  `username` varchar(16) NOT NULL,
  `password` varchar(32) NOT NULL,
  `name` varchar(20) NOT NULL,
  `agent_id` varchar(11) NOT NULL COMMENT '代理商id'
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `yunfu_user`
--

INSERT INTO `yunfu_user` (`id`, `username`, `password`, `name`, `agent_id`) VALUES
(1, 'admin', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', '', '0'),
(2, 'test', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', '', '3'),
(3, 'daili', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', '', '0'),
(4, 'test1', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', '', '3'),
(5, 'test2', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', '', '3'),
(6, 'test3', '0b4e7a0e5fe84ad35fb5f95b9ceeac79', '', '7'),
(7, 'daili1', '786e5d6a0a32f21649a53503d6a37515', '', '0'),
(8, '31231123', 'e8e4e5b0b909cfe76053a79413131711', '', '0'),
(9, 'test32111', '6c5db163a4c1c2110d60f63c1b150925', '', '0'),
(10, 'dsadas', '6c5db163a4c1c2110d60f63c1b150925', '', '0'),
(11, 'dsadasaaa', 'b95b17ab4a352419aa61847772db1a2b', '', '0');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `yunfu_admin`
--
ALTER TABLE `yunfu_admin`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `yunfu_cashier`
--
ALTER TABLE `yunfu_cashier`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `yunfu_config`
--
ALTER TABLE `yunfu_config`
  ADD PRIMARY KEY (`id`), ADD KEY `uid` (`uid`);

--
-- Indexes for table `yunfu_device`
--
ALTER TABLE `yunfu_device`
  ADD PRIMARY KEY (`id`), ADD KEY `device_no` (`device_no`), ADD KEY `uid` (`uid`);

--
-- Indexes for table `yunfu_order`
--
ALTER TABLE `yunfu_order`
  ADD PRIMARY KEY (`id`), ADD KEY `out_trade_no` (`out_trade_no`), ADD KEY `uid` (`uid`), ADD KEY `device_id` (`device_id`), ADD KEY `cashier_id` (`cashier_id`), ADD KEY `total_fee` (`total_fee`), ADD KEY `result_code` (`result_code`), ADD KEY `trade_no` (`trade_no`), ADD KEY `trade_status` (`trade_status`), ADD KEY `gmt_create` (`gmt_create`), ADD KEY `gmt_payment` (`gmt_payment`), ADD KEY `uid_2` (`uid`,`out_trade_no`,`trade_no`);

--
-- Indexes for table `yunfu_user`
--
ALTER TABLE `yunfu_user`
  ADD PRIMARY KEY (`id`), ADD UNIQUE KEY `username` (`username`), ADD UNIQUE KEY `username_2` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `yunfu_admin`
--
ALTER TABLE `yunfu_admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `yunfu_cashier`
--
ALTER TABLE `yunfu_cashier`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=85;
--
-- AUTO_INCREMENT for table `yunfu_config`
--
ALTER TABLE `yunfu_config`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `yunfu_device`
--
ALTER TABLE `yunfu_device`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=72;
--
-- AUTO_INCREMENT for table `yunfu_order`
--
ALTER TABLE `yunfu_order`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=15;
--
-- AUTO_INCREMENT for table `yunfu_user`
--
ALTER TABLE `yunfu_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
