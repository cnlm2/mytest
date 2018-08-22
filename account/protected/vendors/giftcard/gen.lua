
dofile "card.lua"
dofile "common.lua"

GenLuaConfig()
GenPyConfig()
GenPhpConfig()


-- Gen(Class, Offset, Number)
	-- Class: 礼品卡类型,不同的礼品卡对应了不同的奖励和作用
	-- Offset: 从第几张卡开始生成
	-- Number: 一共生成多少张

-- Gen(10004, 10000, 15000)  --11月20日，叶子猪媒体卡补号

-- Gen(10002, 0, 5000) -- 13.11.20 5000个坐骑最受欢迎奖
-- Gen(10003, 0, 5000) -- 13.11.20 5000个坐骑参与奖

-- Gen(10005, 0, 1000) -- 13.12.11 1000个游久独家礼包

-- Gen(10011, 0, 100000) -- 14.01.02 10W个网易独家礼包
-- Gen(10012, 0, 100000) -- 14.01.02 10W个新浪独家礼包
-- Gen(10013, 0, 100000) -- 14.01.02 10W个多玩独家礼包
-- Gen(10014, 0, 10000) -- 14.01.02 11W个公会礼包
-- Gen(10015, 0, 2000) -- 14.01.02 二线媒体
-- Gen(10016, 0, 2000) -- 14.01.02 二线媒体
-- Gen(10017, 0, 2000) --  14.01.02 二线媒体
-- Gen(10018, 0, 2000) --  14.01.02 二线媒体
-- Gen(10019, 0, 2000) --  14.01.02 二线媒体
-- Gen(10020, 0, 2000) --  14.01.02 二线媒体
-- Gen(10021, 0, 2000) --  14.01.02 二线媒体
-- Gen(10022, 0, 2000) --  14.01.02 二线媒体
-- Gen(10023, 0, 2000) --  14.01.02 二线媒体
-- Gen(10024, 0, 2000) --  14.01.02 二线媒体
-- Gen(10025, 0, 10000) --  14.01.02 三线媒体
-- Gen(10026, 0, 50000) --  14.01.02 腾讯独家礼包
-- Gen(10027, 0, 5000) --  14.01.10 U9独家礼包5000个

-- Gen(10025, 0, 10000) --  14.01.06 三线媒体

-- Gen(10028, 0, 50000) --  14.01.07 多玩新手卡，和三线媒体的通用

-- Gen(10017, 0, 3000) --  14.01.10 叶子猪媒体卡

-- Gen(10029, 0, 1000) --  14.01.10 汴京吧礼包

-- Gen(10026, 0, 100000) --  14.01.13 腾讯独家礼包10W

-- Gen(10049, 0, 5000) --  14.01.16 2014春节限量媒体礼包_U9独家
-- Gen(10048, 0, 30000) --  14.01.16 2014春节限量媒体礼包_多玩独家
-- Gen(10047, 0, 30000) --  14.01.16 2014春节限量媒体礼包_新浪独家
-- Gen(10046, 0, 30000) --  14.01.16 2014春节限量媒体礼包_网易独家
-- Gen(10045, 0, 10000) --  14.01.16 2014春节限量媒体礼包_其他媒体
-- Gen(10044, 0, 500) --  14.01.16 2014春节限量媒体礼包_顺网
-- Gen(10042, 0, 500) --  14.01.16 2014春节限量媒体礼包_兔友网
-- Gen(10041, 0, 1000) --  14.01.16 2014春节限量媒体礼包_爱拍
-- Gen(10040, 0, 500) --  14.01.16 2014春节限量媒体礼包_天极网
-- Gen(10039, 0, 1000) --  14.01.16 2014春节限量媒体礼包_5617
-- Gen(10038, 0, 500) --  14.01.16 2014春节限量媒体礼包_硅谷动力
-- Gen(10037, 0, 2000) --  14.01.16 2014春节限量媒体礼包_万宇
-- Gen(10036, 0, 2000) --  14.01.16 2014春节限量媒体礼包_太平洋
-- Gen(10035, 0, 3000) --  14.01.16 2014春节限量媒体礼包_电玩巴士
-- Gen(10034, 0, 2000) --  14.01.16 2014春节限量媒体礼包_131
-- Gen(10033, 0, 2000) --  14.01.16 2014春节限量媒体礼包_766
-- Gen(10032, 0, 2000) --  14.01.16 2014春节限量媒体礼包_178
-- Gen(10031, 0, 3000) --  14.01.16 2014春节限量媒体礼包_52PK
-- Gen(10030, 0, 5000) --  14.01.16 2014春节限量媒体礼包_叶子猪

-- Gen(10054, 0, 50000) --  2014年3月21日开服网易独家如意礼包
-- Gen(10055, 0, 100000) --  2014年3月21日新浪独家风云礼包
-- Gen(10056, 0, 100000) --  2014年3月21日YY独家珍珑礼包
-- Gen(10057, 0, 10000) --  2014年3月21日360&U9独家七巧礼包
-- Gen(10058, 0, 20000) --  2014年3月21日再战江湖新手卡礼包_通用媒体
-- Gen(10059, 0, 5000) --  2014年3月21日再战江湖新手卡礼包_叶子猪
-- Gen(10060, 0, 5000) --  2014年3月21日再战江湖新手卡礼包_52PK
-- Gen(10061, 0, 3000) --  2014年3月21日再战江湖新手卡礼包_178
-- Gen(10062, 0, 3000) --  2014年3月21日再战江湖新手卡礼包_766
-- Gen(10063, 0, 1000) --  2014年3月21日再战江湖新手卡礼包_131
-- Gen(10064, 0, 3000) --  2014年3月21日再战江湖新手卡礼包_电玩巴士
-- Gen(10065, 0, 2000) --  2014年3月21日再战江湖新手卡礼包_太平洋游戏
-- Gen(10066, 0, 2000) --  2014年3月21日再战江湖新手卡礼包_万宇在线
-- Gen(10067, 0, 1000) --  2014年3月21日再战江湖新手卡礼包_硅谷动力
-- Gen(10068, 0, 1000) --  2014年3月21日再战江湖新手卡礼包_5617
-- Gen(10069, 0, 1000) --  2014年3月21日再战江湖新手卡礼包_天极网游戏
-- Gen(10070, 0, 1000) --  2014年3月21日再战江湖新手卡礼包_爱拍
-- Gen(10071, 0, 1000) --  2014年3月21日再战江湖新手卡礼包_兔友网
-- Gen(10072, 0, 50000) --  2014年3月21日开服腾讯独家闪亮礼包

-- Gen(10058, 20000, 20000) --  2014年3月21日再战江湖新手卡礼包_通用媒体补卡
-- ~ Gen(10073, 0, 20000) --  2014年5月9日官方礼包
-- ~ Gen(10074, 0, 100000) --  2014年5月9日开服新浪独家传世礼包
-- ~ Gen(10075, 0, 100000) --  2014年5月9日YY独家至尊礼包
-- ~ Gen(10076, 0, 100000) --  2014年5月9日网易独家风云礼包
-- ~ Gen(10077, 0, 100000) --  2014年5月9日腾讯独家玲珑礼包
-- ~ Gen(10078, 0, 100000) --  2014年5月9日《大侠Q传》新手卡_通用媒体
-- ~ Gen(10079, 0, 100000) --  2014年5月9日备用礼包
-- ~ Gen(10080, 0, 100000) --  2014年5月9日360 U9独家稀世礼包


-- Gen(10081, 0, 30000) --  2014年6月27日 17173独家变身礼包
-- Gen(10082, 0, 20000) --  2014年6月27日 新浪独家变身礼包
-- Gen(10083, 0, 20000) --  2014年6月27日 腾讯独家变身礼包
-- Gen(10084, 0, 20000) --  2014年6月27日 网易独家变身礼包
-- Gen(10085, 0, 30000) --  2014年6月27日 多玩独家变身礼包
-- Gen(10086, 0, 5000) --  2014年6月27日 U9独家变身礼包

-- Gen(10087, 0, 1000) --  2014年6月27日 360变身礼包
-- Gen(10088, 0, 2000) --  2014年6月27日 叶子猪变身礼包
-- Gen(10089, 0, 1000) --  2014年6月27日 52PK变身礼包
-- Gen(10090, 0, 1000) --  2014年6月27日 178变身礼包
-- Gen(10091, 0, 1000) --  2014年6月27日 766变身礼包
-- Gen(10092, 0, 1000) --  2014年6月27日 131变身礼包
-- Gen(10093, 0, 1000) --  2014年6月27日 电玩巴士变身礼包
-- Gen(10094, 0, 1000) --  2014年6月27日 太平洋变身礼包
-- Gen(10095, 0, 500) --  2014年6月27日 万宇在线变身礼包
-- Gen(10096, 0, 10000) --  2014年6月27日 其他媒体变身礼包


-- Gen(10097, 0, 10000) --  2014年6月27日 下载客户端抽奖如意卷
-- Gen(10098, 0, 10000) --  2014年6月27日 下载客户端抽奖回春汤
-- Gen(10099, 0, 10000) --  2014年6月27日 下载客户端抽奖优质牧草
-- Gen(10100, 0, 10000) --  2014年6月27日 下载客户端抽奖洗髓丹

-- Gen(10101, 0, 2000) --  2014年6月27日 公会礼包

-- Gen(10102, 0, 30010) --  2014年6月27日 多玩独家龙宝包

-- Gen(10103, 0, 1000) --  2014年6月27日 汴京吧游侠礼包
-- Gen(10104, 0, 1000) --  2014年6月27日 汴京吧侠客礼包
-- Gen(10105, 0, 200) --  2014年6月27日 汴京吧大侠礼包
-- Gen(10106, 0, 50) --  2014年6月27日 汴京吧豪侠礼包

-- Gen(10107, 0, 60010) --  2014年6月27日 多玩每日礼包
-- Gen(10108, 0, 3010) --  2014年6月27日 多玩竞拍礼包

-- Gen(10102, 30010, 50000) --  2014年6月27日 新增多玩独家龙宝包
-- Gen(10107, 60010, 40000) --  2014年6月27日 新增多玩每日礼包


-- Gen(10109, 0, 20000) --  2014年8月15日 17173独家变形礼包
-- Gen(10110, 0, 10000) --  2014年8月15日 新浪独家变形礼包
-- Gen(10111, 0, 10000) --  2014年8月15日 腾讯独家变形礼包
-- Gen(10112, 0, 10000) --  2014年8月15日 网易独家变形礼包
-- Gen(10113, 0, 20000) --  2014年8月15日 多玩独家变形礼包
-- Gen(10114, 0, 5000) --  2014年8月15日 U9独家变形礼包
-- Gen(10115, 0, 1000) --  2014年8月15日 360变形礼包
-- Gen(10116, 0, 1000) --  2014年8月15日 叶子猪变形礼包
-- Gen(10117, 0, 1000) --  2014年8月15日 52PK变形礼包
-- Gen(10118, 0, 1000) --  2014年8月15日 178变形礼包
-- Gen(10119, 0, 1000) --  2014年8月15日 766变形礼包
-- Gen(10120, 0, 500) --  2014年8月15日 131变形礼包
-- Gen(10121, 0, 1000) --  2014年8月15日 电玩巴士变形礼包
-- Gen(10122, 0, 1000) --  2014年8月15日 太平洋游戏变形礼包
-- Gen(10123, 0, 500) --  2014年8月15日 万宇在线变形礼包
-- Gen(10124, 0, 10000) --  2014年8月15日 其他媒体变形礼包


-- Gen(10125, 0, 10000) --  2014年8月15日 评选名人抽奖道具
-- Gen(10126, 0, 10000) --  2014年8月15日 评选名人抽奖道具
-- Gen(10127, 0, 10000) --  2014年8月15日 评选名人抽奖道具
-- Gen(10128, 0, 10000) --  2014年8月15日 评选名人抽奖道具


-- Gen(10129, 0, 100000) --  2014年8月15日 17173每日礼包
-- Gen(10130, 0, 100000) --  2014年8月15日 17173每日礼包


-- Gen(10101, 2000, 8000) --  2014年8月15日 公会礼包
-- Gen(10131, 0, 20000) --  2014年8月15日 公会礼包


-- Gen(10132, 0, 28000) --  2015年1月23日 拍拍投YY礼包
-- Gen(10133, 0, 3000) --  2015年1月23日 拍拍投17173礼包
-- Gen(10134, 0, 3000) --  2015年1月23日 拍拍投新浪礼包
-- Gen(10135, 0, 1000) --  2015年1月23日 拍拍投叶子猪礼包
-- Gen(10136, 0, 5000) --  2015年1月23日 拍拍投普通媒体礼包


-- Gen(10133, 3000, 3000) --  2015年1月23日 拍拍投17173礼包
-- Gen(10133, 6000, 4000) --  2015年1月23日 拍拍投17173礼包
-- Gen(10135, 1000, 5000) --  2015年1月23日 拍拍投叶子猪礼包
-- Gen(10133, 10000, 10000) --  2015年1月23日 拍拍投17173礼包

-- Gen(10137, 0, 30000) --  2015年1月23日 拍拍投移动端礼包
-- Gen(10138, 0, 300000) --  2015年1月23日 YY老玩家礼包
-- Gen(10134, 3000, 3000) --  2015年1月23日 拍拍投新浪礼包
-- Gen(10133, 20000, 2000) --  2015年1月23日 拍拍投17173礼包
-- Gen(10133, 22000, 2000) --  2015年1月23日 拍拍投17173礼包
-- Gen(10136, 5000, 3000) --  2015年1月23日 拍拍投普通媒体礼包

-- Gen(10137, 30000, 5000) --  2015年1月23日 拍拍投移动端礼包
-- Gen(10133, 24000, 20000) --  2015年1月23日 拍拍投17173礼包

-- Gen(10134, 6000, 5000) --  2015年1月23日 拍拍投新浪礼包
-- Gen(10135, 6000, 5000) --  2015年1月23日 拍拍投叶子猪礼包


-- Gen(10133, 44000, 10000) --  2015年1月23日 拍拍投17173礼包
-- Gen(10132, 28000, 20000) --  2015年1月23日 拍拍投YY礼包
-- Gen(10135, 11000, 10000) --  2015年1月23日 拍拍投叶子猪礼包
-- Gen(10134, 11000, 5000) --  2015年1月23日 拍拍投新浪礼包
-- Gen(10136, 8000, 5000) --  2015年1月23日 拍拍投普通媒体礼包

-- Gen(10139, 0, 5000) --  2015年2月6日 拍拍投YY新春礼包
-- Gen(10140, 0, 5000) --  2015年2月6日 拍拍投论坛礼包

-- Gen(10133, 54000, 10000) --  2015年1月23日 拍拍投17173礼包
-- Gen(10132, 48000, 10000) --  2015年1月23日 拍拍投YY礼包
-- Gen(10135, 21000, 8000) --  2015年1月23日 拍拍投叶子猪礼包
-- Gen(10134, 16000, 8000) --  2015年1月23日 拍拍投新浪礼包
-- Gen(10136, 13000, 5000) --  2015年1月23日 拍拍投普通媒体礼包

-- Gen(10141, 5000, 10000) --  2015年3月4日 拍拍投新论坛礼包

-- Gen(10133, 64000, 10000) --  2015年1月23日 拍拍投17173礼包

-- Gen(10142, 0, 10000) --  2015年3月13日 拍拍投17173礼包
-- Gen(10143, 0, 5000) --  2015年3月13日 拍拍投新浪礼包
-- Gen(10144, 0, 5000) --  2015年3月13日 拍拍投叶子猪礼包
-- Gen(10145, 0, 10000) --  2015年3月13日 拍拍投多玩礼包
-- Gen(10146, 0, 10000) --  2015年3月13日 拍拍投普通媒体礼包

-- Gen(10143, 5000, 5000) --  2015年3月13日 拍拍投新浪礼包

-- Gen(10147, 0, 10000) --  2015年3月13日 YY幸运大礼包


-- Gen(10142, 10000, 10000) --  2015年3月13日 拍拍投17173礼包
-- Gen(10145, 10000, 10000) --  2015年3月13日 拍拍投多玩礼包


-- Gen(10146, 10000, 2000) --  2015年3月13日 拍拍投普通媒体礼包

-- Gen(10146, 10000, 2000) --  2015年3月13日 拍拍投普通媒体礼包

-- Gen(10146, 12000, 400) --  2015年3月13日 拍拍投普通媒体礼包

-- Gen(10146, 12400, 400) --  2015年3月13日 拍拍投普通媒体礼包

-- Gen(10148, 0, 10000) --  2015年4月15日 拍拍投17173独家媒体礼包 临时伙伴敏敏郡主*1 火云邪神变身卡*1 如意卷*1 回春汤*1 天山紫绢*3 军令*1 10万银票券 妖气山使者称号 
-- Gen(10149, 0, 10000) --  2015年4月15日 拍拍投YY独家媒体礼包 临时伙伴悍娇虎*1 望月兔变身卡*1 如意卷*1 回春汤*1 天山紫绢*3 军令*1 10万银票券 YY霹雳使者称号
-- Gen(10150, 0, 30000) --  2015年4月15日 拍拍投YY每日媒体礼包 银票券10万 1级霹雳元星珠*1 沉思丸*2

-- Gen(10151, 0, 30000) --  2015年4月15日 拍拍投普通媒体媒体礼包 银票券10万 三醉芙蓉花*5 琉璃手环*1 天山紫绢*3 军令*1 闪电貂变身卡*1

-- Gen(10148, 10000, 1000) --  2015年4月15日 拍拍投17173独家媒体礼包 临时伙伴敏敏郡主*1 火云邪神变身卡*1 如意卷*1 回春汤*1 天山紫绢*3 军令*1 10万银票券 妖气山使者称号 

-- Gen(10151, 30000, 1000) --  2015年4月15日 拍拍投普通媒体媒体礼包 银票券10万 三醉芙蓉花*5 琉璃手环*1 天山紫绢*3 军令*1 闪电貂变身卡*1

-- Gen(10151, 31000, 2000) --  2015年4月15日 拍拍投普通媒体媒体礼包 银票券10万 三醉芙蓉花*5 琉璃手环*1 天山紫绢*3 军令*1 闪电貂变身卡*1

-- Gen(10150, 30000, 30000) --  2015年4月15日 拍拍投YY每日媒体礼包 银票券10万 1级霹雳元星珠*1 沉思丸*2

-- Gen(10151, 33000, 1000) --  2015年4月15日 拍拍投普通媒体媒体礼包 银票券10万 三醉芙蓉花*5 琉璃手环*1 天山紫绢*3 军令*1 闪电貂变身卡*1

-- Gen(10151, 34000, 1000) --  2015年4月15日 拍拍投普通媒体媒体礼包 银票券10万 三醉芙蓉花*5 琉璃手环*1 天山紫绢*3 军令*1 闪电貂变身卡*1

-- Gen(10150, 70000, 10000) --  2015年4月15日 拍拍投YY每日媒体礼包 银票券10万 1级霹雳元星珠*1 沉思丸*2

-- Gen(10151, 35000, 3000) --  2015年4月15日 拍拍投普通媒体媒体礼包 银票券10万 三醉芙蓉花*5 琉璃手环*1 天山紫绢*3 军令*1 闪电貂变身卡*1

-- Gen(10152, 0, 50000) --  2015年6月05日 拍拍投毕业狂欢礼包 如意卷*1 回春汤*1 天山紫绢*3 军令*1 冰凯熊变身卡*1 
-- Gen(10148, 11000, 3000) --  2015年4月15日 拍拍投17173独家媒体礼包 临时伙伴敏敏郡主*1 火云邪神变身卡*1 如意卷*1 回春汤*1 天山紫绢*3 军令*1 10万银票券 妖气山使者称号 

-- Gen(10153, 0, 50000) --  2015年6月05日 拍拍投激活码礼包 如意卷*1 回春汤*1 闪电貂变身卡*1 

-- Gen(10153, 50000, 50000) --  2015年6月05日 拍拍投激活码礼包 如意卷*1 回春汤*1 闪电貂变身卡*1 


-- Gen(10154, 0, 50000) --  2015年6月05日 拍拍投抽奖 - 侠义石*2
-- Gen(10155, 0, 10000) --  2015年6月05日 拍拍投抽奖 - 洗髓丹*10
-- Gen(10156, 0, 10000) --  2015年6月05日 拍拍投抽奖 - 龙纹手环*1
-- Gen(10157, 0, 10000) --  2015年6月05日 拍拍投抽奖 - 内丹*1
-- Gen(10158, 0, 10000) --  2015年6月05日 拍拍投抽奖 - 优质牧草*5

-- Gen(10153, 100000, 50000) --  2015年6月05日 拍拍投激活码礼包 如意卷*1 回春汤*1 闪电貂变身卡*1 

-- Gen(10149, 10000, 10000) --  2015年4月15日 拍拍投YY独家媒体礼包 临时伙伴悍娇虎*1 望月兔变身卡*1 如意卷*1 回春汤*1 天山紫绢*3 军令*1 10万银票券 YY霹雳使者称号

-- Gen(10148, 14000, 5000) --  2015年4月15日 拍拍投17173独家媒体礼包 临时伙伴敏敏郡主*1 火云邪神变身卡*1 如意卷*1 回春汤*1 天山紫绢*3 军令*1 10万银票券 妖气山使者称号 

-- Gen(10149, 30000, 10000) --  2015年4月15日 拍拍投YY独家媒体礼包 临时伙伴悍娇虎*1 望月兔变身卡*1 如意卷*1 回春汤*1 天山紫绢*3 军令*1 10万银票券 YY霹雳使者称号
-- Gen(10149, 50000, 100000) --  2015年4月15日 拍拍投YY独家媒体礼包 临时伙伴悍娇虎*1 望月兔变身卡*1 如意卷*1 回春汤*1 天山紫绢*3 军令*1 10万银票券 YY霹雳使者称号
-- Gen(10160, 0, 50000) --  2015年7月10日 拍拍投随机礼包 10金票*2 如意卷*1 回春汤*1 10万银票券
-- Gen(10163, 14000, 5000) --  2015年7月30日 拍拍投17173礼包 临时伙伴朱姑娘*1 闪电貂变身卡*1 优质牧草*3 融炼露*3 江湖异闻录*3 10万银票券 妖气山使者称号 
-- Gen(10161, 0, 15000) --  2015年7月30日 拍拍投抢注礼包  火云邪神变身卡*1 天山紫绢*3 军令*1 10万银票券 琉璃手环*1
-- Gen(10162, 14000, 4000) --  2015年7月30日 拍拍投叶子猪礼包  如意卷*2 回春汤*2 临时伙伴盈盈姑娘*1 10万银票券 冰铠熊变身卡*1 天山紫娟*3
-- Gen(10164, 0, 10000) --  2015年7月30日 拍拍投YY礼包  如意卷*2 回春汤*2 临时伙伴令狐公子*1 镖信*1 九尾狐变身卡*1 军令*2
-- Gen(10165, 28000, 5000) --  2015年7月30日 拍拍投新手卡礼包  如意卷*1 回春汤*1 10万银票券 猴儿果*50 黑莲*50 我是新人王称号
-- Gen(10166, 0, 10000) --  2015年7月30日 拍拍投精英回馈礼包  镖信*6 魔光碎片*1 百色果*3 红玉*6
-- Gen(10167, 0, 20000) --  2015年7月30日 拍拍投新手见面礼包  如意卷*1 回春汤*1 猴儿果*50 黑莲*50
-- Gen(10168, 10000, 18000) --  2015年7月30日 拍拍投特权礼包  军令*2 镖信*2 龙纹手环*1 优质牧草*3 天山紫娟*3
-- Gen(10169, 0, 10000) --  2015年7月30日 拍拍投内测回馈礼包  魔光碎片*5 幻彩*5 祥云手镯*1 侠义石*5 百色果*5 有朋自远方来称号
-- Gen(10170, 0, 10000) --  2015年7月30日 拍拍投豪气冲天礼包  洗髓丹*10 龙纹手环*1 侠义石*2 10万银票券 豪气冲天称号

-- Gen(10171, 0, 3000) --  2015年8月06日 拍拍投抽奖 - 内丹*1
-- Gen(10172, 0, 15000) --  2015年8月06日 拍拍投抽奖 - 回春汤*1
-- Gen(10173, 0, 3000) --  2015年8月06日 拍拍投抽奖 - 龙纹手环*1
-- Gen(10174, 0, 5000) --  2015年8月06日 拍拍投抽奖 - 侠义石*1
-- Gen(10175, 0, 10000) --  2015年8月06日 拍拍投抽奖 - 如意卷*1
-- GenYY(10176, 0, 85000) --  2015年9月09日 拍拍投临时名人 - 聂隐娘*1
-- GenYY(10178, 0, 85000) --  2015年9月09日 拍拍投临时名人 - 聂隐娘*1
-- GenYY(10180, 0, 2) --  2015年9月09日 拍拍投临时名人测试 - 聂隐娘*1
-- GenYY(10179, 85000, 50) --  2015年9月18日 拍拍投QB宝箱 

-- Gen(10181, 3500000, 200, "GHRW") --  2015年9月18日 拍拍投公会礼包 - 如意卷*1 回春汤*1 冰铠熊变身卡*1 10万银票券
-- Gen(10177, 85000, 800) --  2015年9月09日 拍拍投官方礼包 - 如意卷*1 回春汤*1 冰铠熊变身卡*1 10万银票券
-- Gen(10182, 20000, 1000) --  2015年9月18日 拍拍投官方礼包 - 优质牧草*1 三醉芙蓉花*5 九尾狐变身卡*1 10万银票券
-- Gen(10183, 150, 10000) --  2015年10月10日 拍拍投随机测试礼包 - 优质牧草*1 
-- Gen(10205, 0, 5000) --  2016年1月17日 拍拍投随机测试礼包 - 优质牧草*1 

-- Gen(10184, 30000, 1) --  2015年10月15日 拍拍投17173特权礼包 - 如意卷*1 回春汤*1 三醉芙蓉花*5 红玉*1 火云邪神变身卡*1 妖气山庄称号
-- Gen(10185, 20000, 100) --  2015年10月15日 拍拍投新浪游戏特权礼包 - 镖信*1 银票券10万 天山紫绢*1 醒神丸*1 功夫猫变身卡*1 目空一切称号
-- Gen(10186, 20000, 1) --  2015年10月15日 拍拍投多玩游戏特权礼包 - 双倍经验丹*1 杨柳仙露*1 军令*1 聚神符*1 九尾狐变身卡*1 杀气腾腾称号
-- Gen(10187, 20000, 1) --  2015年10月15日 拍拍投叶子猪游戏特权礼包 - 优质牧草*1 琉璃手环*1 婚礼焰火*5 武林札记*10 望月兔变身卡*1 情义江湖称号

-- Gen(10188, 0, 10) --  2015年10月20日 拍拍投盛典礼包 - 霹雳奔雷虎7天*1 头像秀7天*1 万人敬仰称号
-- Gen(10189, 10000, 5000) --  2015年10月20日 拍拍投抢注礼包 - 银票券10万 军令*1 优质牧草*1 天山紫娟*3
-- Gen(10190, 0, 20000) --  2015年10月20日 拍拍投媒体礼包 - 银票券10万 三醉芙蓉花*5 天山紫绢*1 军令*1 闪电貂变身卡*1
-- Gen(10191, 0, 20000) --  2015年10月20日 拍拍投新手礼包 - 猴儿果*50 黑莲*50 银票券10万 如意卷*1 回春汤*1
-- Gen(10192, 0, 20000) --  2015年10月20日 拍拍投媒体加成礼包 - 银票券10万 藏宝图*3 望月兔变身卡*1 红玉*2
-- Gen(10193, 0, 5000) --  2015年10月20日 拍拍投精英特权礼包 - 龙纹手环*1 洗髓丹*30 侠义石*5 百色果*3 有朋自远方来称号
-- Gen(10194, 5000, 10000) --  2015年10月20日 拍拍投至尊礼包 - 如意卷*2 回春汤*2 龙纹手环*1 二级乌金*1 八方聚首称号

-- Gen(10195, 0, 10000) --  2015年11月28号 临时名人神雕大侠
-- Gen(10196, 0, 10000) --  2015年11月28号 临时名人龙姑娘
-- Gen(10197, 0, 10000) --  2015年11月28号 临时名人一点红
-- Gen(10198, 0, 10000) --  2015年11月28号 临时名人陆小凤
-- Gen(10199, 0, 10000) --  2015年11月28号 临时名人西门飞雪

-- Gen(10200, 0, 50000) --  2015年11月28号 洗点道具 - 洗骨经残本*1
-- Gen(10201, 10000, 500) --  2015年12月08号 招贤纳士礼包 - 琉璃手环*1 银票券10万 优质牧草*1 天山紫娟*3
-- Gen(10202, 0, 20000) --  2015年12月08号 求贤若渴礼包 - 1级霹雳元星珠*1 银票券10万 三醉芙蓉花*5 军令*1 闪电貂变身卡*1
-- Gen(10203, 0, 50000) --  2015年11月28号 隐藏角色千鸟激活码
-- Gen(10204, 0, 200000) --  2015年12月18日 拍拍投QB宝箱 

-- Gen(10206, 0, 10000) --  2016年1月12号 临时名人神雕大侠
-- Gen(10207, 0, 10000) --  2016年1月12号 临时名人龙姑娘
-- Gen(10208, 0, 10000) --  2016年1月12号 临时名人一点红
-- Gen(10209, 0, 10000) --  2016年1月12号 临时名人陆小凤
-- Gen(10210, 0, 10000) --  2016年1月12号 临时名人西门飞雪

-- Gen(10211, 0, 50000) --  2016年1月12号 洗点道具 - 洗骨经残本*1
-- Gen(10212, 0, 50000) --  2016年1月12号 隐藏角色千鸟激活码
-- Gen(10213, 0, 50000) --  2016年1月12号 拍拍投QB宝箱 

-- Gen(10214, 0, 20000) --  2016年1月12号 拍拍投摸金礼包 — 宝图卷轴*1 聚神符*1 一级宝石袋*3 地味补血膏*1 10万银票券
-- Gen(10215, 0, 10000) --  2016年1月12号 拍拍投盗墓礼包 — 红玉*1 天山紫绢*2 慧眼*5 杨柳仙露*1 10万银票券

-- Gen(10216, 0, 9000) --  2016年3月11号 拍拍投17173无双礼包 — 昆仑石*1 如意卷*2 回春汤*2 镖信*2 醒神丸*2 军令*2 优质牧草*2 火云邪神变身卡*2 称号
-- Gen(10217, 0, 7500) --  2016年3月11号 拍拍投多玩至尊礼包 — 昆仑石*1 如意卷*2 回春汤*2 镖信*2 醒神丸*2 军令*2 优质牧草*2 功夫猫变身卡*2 称号
-- Gen(10218, 0, 4000) --  2016年3月11号 拍拍投新浪绝世礼包 — 昆仑石*1 如意卷*2 回春汤*2 镖信*2 醒神丸*2 军令*2 优质牧草*2 九尾狐变身卡*2 称号
-- Gen(10219, 0, 5000) --  2016年3月11号 拍拍投叶子猪逍遥礼包 — 昆仑石*1 如意卷*2 回春汤*2 镖信*2 醒神丸*2 军令*2 优质牧草*2 望月兔变身卡*2 称号
-- Gen(10220, 0, 5000) --  2016年3月11号 拍拍投52PK笑傲礼包 — 昆仑石*1 如意卷*2 回春汤*2 镖信*2 醒神丸*2 军令*2 优质牧草*2 冰铠熊变身卡*2 称号
-- Gen(10221, 0, 6000) --  2016年3月11号 拍拍投公会霸道礼包 — 昆仑石*1 如意卷*2 回春汤*2 镖信*2 醒神丸*2 军令*2 优质牧草*2 闪电貂变身卡*2 称号
-- Gen(10222, 0, 20000) --  2016年3月11日 拍拍投有朋至远方来温暖礼包 - 龙纹手环*1 洗髓丹*30 侠义石*5 百色果*3 称号
-- Gen(10223, 0, 15000) --  2016年3月11日 拍拍投多玩飞升包 - 银票券10万 如意卷*1 回春汤*1 小布驴变身卡*1
 
-- Gen(10224, 0, 5000) --  2016年3月11号 拍拍投腾讯超越礼包 — 昆仑石*1 如意卷*2 回春汤*2 镖信*2 醒神丸*2 军令*2 优质牧草*2 火云邪神变身卡*2 称号
-- Gen(10225, 0, 5000) --  2016年3月11号 拍拍投电玩巴士礼包 — 昆仑石*1 如意卷*2 回春汤*2 镖信*2 醒神丸*2 军令*2 优质牧草*2 功夫猫变身卡*2 称号
-- Gen(10226, 0, 5000) --  2016年3月11号 拍拍投178仁义礼包 — 昆仑石*1 如意卷*2 回春汤*2 镖信*2 醒神丸*2 军令*2 优质牧草*2 九尾狐变身卡*2 称号
-- Gen(10227, 0, 5000) --  2016年3月11号 拍拍投766勇气礼包 — 昆仑石*1 如意卷*2 回春汤*2 镖信*2 醒神丸*2 军令*2 优质牧草*2 望月兔变身卡*2 称号
-- Gen(10228, 0, 5000) --  2016年3月11号 拍拍投网易祥云礼包 — 昆仑石*1 如意卷*2 回春汤*2 镖信*2 醒神丸*2 军令*2 优质牧草*2 望月兔变身卡*2 称号

-- Gen(10229, 10000, 50) --  2016年3月11号 拍拍投17173特权礼包 — 镖信*1 银票券10万 天山紫绢*1 醒神丸*1 洗髓丹*20 伙伴洗骨丸*1
-- Gen(10230, 10000, 50) --  2016年3月11号 拍拍投多玩特权礼包 — 双倍经验丹*1 杨柳仙露*1 军令*1 聚神符*1 洗髓丹*20 洗骨丸*1
-- Gen(10231, 10000, 50) --  2016年3月11号 拍拍投腾讯特权礼包 — 优质牧草*1 龙纹手环*1 镖信*1 慧眼*4 洗髓丹*20 侠义石*1

-- Gen(10232, 0, 5) --  2016年3月11号 固定激活码微信礼包 — 50金票*1 如意卷*1 回春汤*1 银票券10万
-- Gen(10233, 5000, 200) --  2016年3月11号 公会礼包 — 银票券10万 如意卷*1 回春汤*1 醒神丸*1

-- Gen(10234, 0, 20000) --  2016年4月20号 拍拍投豪侠媒体礼包 — 如意卷*2 回春汤*2 镖信*2 醒神丸*2 军令*2 优质牧草*2 火云邪神变身卡*2

-- Gen(10235, 0, 10000) --  2016年4月20号 拍拍投腾讯独家礼包 — 地味补血糕*1 融炼露*1 醒神丸*1 三倍经验丹*1 洗髓丹*10 大洗骨丸*1 称号
-- Gen(10236, 0, 10000) --  2016年4月20号 拍拍投多玩独家礼包 — 双倍经验丹* 杨柳仙露*3 军令*1 聚神符*1 洗髓丹*10 洗骨丸*1 称号
-- Gen(10237, 0, 10000) --  2016年4月20号 拍拍投17173独家礼包 — 天山紫绢*1 镖信*1 三醉芙蓉花*5 侠义石*1 洗髓丹*10 未知的2级元星珠*1 称号
-- Gen(10238, 0, 10000) --  2016年4月20号 拍拍投新浪独家礼包 — 优质牧草*1 琉璃手环*1 镖信*1 慧眼*4 洗髓丹*10 侠义石*1 称号
-- Gen(10239, 0, 10000) --  2016年4月20号 拍拍投叶子猪独家礼包 — 天香益气汤*2 帮派幸运符*2 红玉*2 江湖小喇叭*1 洗髓丹*10 大伙伴洗骨丸*1 称号 
-- Gen(10240, 0, 10000) --  2016年4月20号 拍拍投网易独家礼包 — 镖信*2 银票券10万 天山紫绢*2 醒神丸*1 洗髓丹*10 伙伴洗骨丸*1 称号

-- Gen(10241, 0, 20000) --  2016年5月28号 拍拍投豪侠媒体礼包 — 如意卷*2 回春汤*2 镖信*2 醒神丸*2 军令*2 优质牧草*2 火云邪神变身卡*2

-- Gen(10242, 0, 5000) --  2016年5月28号 拍拍投新浪独家礼包 — 地味补血糕*1 融炼露*1 醒神丸*1 三倍经验丹*1 洗髓丹*10 大洗骨丸*1 称号 
-- Gen(10243, 0, 5000) --  2016年5月28号 拍拍投叶子猪独家礼包 — 双倍经验丹* 杨柳仙露*3 军令*1 聚神符*1 洗髓丹*10 洗骨丸*1 称号 
-- Gen(10244, 0, 5000) --  2016年5月28号 拍拍投网易独家礼包 — 天山紫绢*1 镖信*1 三醉芙蓉花*5 侠义石*1 洗髓丹*10 未知的2级元星珠*1 称号 
-- Gen(10245, 0, 5000) --  2016年5月28号 拍拍投腾讯独家礼包 — 优质牧草*1 琉璃手环*1 镖信*1 慧眼*4 洗髓丹*10 侠义石*1 称号
-- Gen(10246, 0, 5000) --  2016年5月28号 拍拍投多玩独家礼包 — 天香益气汤*1 帮派幸运符*1 红玉*2 江湖小喇叭*1 洗髓丹*10 大伙伴洗骨丸*1 称号 
-- Gen(10247, 0, 5000) --  2016年5月28号 拍拍投17173独家礼包 — 镖信*2 银票券10万 天山紫绢*2 醒神丸*1 洗髓丹*10 伙伴洗骨丸*1 称号

--Gen(10248, 80000, 5000) --  2016年9月20号 拍拍投豪侠媒体礼包 — 如意卷*2 回春汤*2 镖信*2 醒神丸*2 军令*2 优质牧草*2 人鱼公主变身卡 

-- Gen(10249, 15000, 5000) --  2016年9月20号 拍拍投叶子猪独家礼包 — 地味补血糕*1 融炼露*1 醒神丸*1 三倍经验丹*1 洗髓丹*10 大洗骨丸*1 人鱼公主变身卡 称号  
-- Gen(10250, 15000, 5000) --  2016年9月20号 拍拍投网易独家礼包 — 双倍经验丹* 杨柳仙露*3 军令*1 聚神符*1 洗髓丹*10 洗骨丸*1 人鱼公主变身卡 称号
-- Gen(10251, 25000, 5000) --  2016年9月20号 拍拍投腾讯独家礼包 — 天山紫绢*1 镖信*1 三醉芙蓉花*5 侠义石*1 洗髓丹*10 未知的2级元星珠*1 人鱼公主变身卡 称号 
-- Gen(10252, 35000, 5000) --  2016年9月20号 拍拍投多玩独家礼包 — 优质牧草*1 琉璃手环*1 镖信*1 慧眼*4 洗髓丹*10 侠义石*1 人鱼公主变身卡 称号
-- Gen(10253, 15000, 5000) --  2016年9月20号 拍拍投17173独家礼包 — 天香益气汤*1 帮派幸运符*1 红玉*2 江湖小喇叭*1 洗髓丹*10 大伙伴洗骨丸*1 人鱼公主变身卡 称号 
-- Gen(10254, 15000, 5000) --  2016年9月20号 拍拍投新浪独家礼包 — 镖信*2 银票券10万 天山紫绢*2 醒神丸*1 洗髓丹*10 伙伴洗骨丸*1 人鱼公主变身卡 称号

-- Gen(10255, 0, 5000) --  2016年7月6号 拍拍投多玩逍遥礼包 — 龙纹手环*1 侠义石*2 洗髓丹*20 百色果*1 镖信*3

-- Gen(10256, 0, 5000) --  2016年8月20号 微信每月礼包 — 50金票*1 如意卷*1 回春汤*1 银票券10万 洗髓丹*10

--Gen(10257, 29000, 1000) --  2016年8月20号 多玩注册激活码渠道标记— 变身卡*1 如意卷*1 回春汤*1 银票券10万 
--Gen(10257, 40000, 3000) --  2016年10月22号 多玩注册激活码渠道标记— 变身卡*1 如意卷*1 回春汤*1 银票券10万 

--Gen(10259, 0, 40000) --  2016年12月1号 17173礼包


--Gen(10260, 0, 10000) --  2016年12月3号 其他媒体礼包

--Gen(10261, 0, 10000) --  2016年12月3号 多玩媒体礼包
--Gen(10262, 0, 10000) --  2016年12月3号 叶子猪媒体礼包
--Gen(10263, 0, 10000) --  2016年12月3号 新浪媒体礼包
--Gen(10264, 0, 10000) --  2016年12月3号 腾讯媒体礼包
--Gen(10265, 0, 10000) --  2016年12月3号 官网礼包

--Gen(10257, 43000, 3000) --  2016年10月22号 多玩注册激活码渠道标记— 变身卡*1 如意卷*1 回春汤*1 银票券10万 

--Gen(10266, 40001, 30000) --  2016年12月24号 17173媒体礼包

--Gen(10267, 70001, 10000) --  2017年3月10号 17173媒体礼包

--Gen(10268, 0, 40000) --  2017年4月6号 顺网特权礼包
--Gen(10269, 0, 40000) --  2017年4月6号 顺网特权礼包

--Gen(10270, 80001, 20000) --  2017年4月11号 17173媒体礼包

--Gen(10270, 100000, 20000) --  2017年5月6号 17173媒体礼包

--Gen(10264, 10000, 500) --  2016年12月3号 腾讯媒体礼包
--Gen(10262, 10000, 500) --  2016年12月3号 叶子猪媒体礼包

--Gen(10263, 10001, 2000) --  2017年5月31号 新浪媒体礼包
--Gen(10264, 10501, 2000) --  2017年5月31号 腾讯媒体礼包

--Gen(10271, 0, 40000) --  2017年6月23号 官网点击礼包
--Gen(10272, 0, 10000) --  2017年6月30号 回归礼包
--Gen(10273, 0, 3000) --  2017年7月28日逗游特权礼包
--Gen(10274, 0, 1000) --  2017年8月17日超罗特权礼包
--Gen(10275, 0, 100000) --  2017年8月17日飞火新手礼包
--Gen(10276, 0, 50000) --  2017年8月17日飞火手机绑定礼包
--Gen(10277, 0, 20000) --  2017年8月17日飞火豪侠特权礼包
--Gen(10278, 0, 20000) --  2017年8月17日飞火盖世特权礼包
--Gen(10279, 0, 1000) --  2017年8月17日飞火金钻会员礼包
--Gen(10261, 10001, 3000) --  2017年9月16号 多玩媒体礼包
--Gen(10270, 120001, 20000) --  2017年10月11号 17173媒体礼包
--Gen(10278, 20001, 100) --  2017年11月16日飞火盖世特权礼包
--Gen(10280, 30001, 1000) --  2018年2月2日手游盖世特权礼包
--Gen(10281, 0, 10000) --  2018年1月23日官网微信公众号礼包
-- Gen(10282, 0, 10000) --  2018年1月23日心游微信公众号礼包
Gen(10283, 30001, 1000) --  2018年2月2日手游盖世特权礼包