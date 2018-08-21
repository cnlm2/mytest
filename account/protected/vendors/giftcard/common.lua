
-- 激活码结构
-- AAAABBBBCCCCCCCCCCCC
-- A: 四位类型码 2^24 = 16777216 = 1677W个类型
-- B: 四位序列码 2^24 = 16777216 = 1677W张卡
-- C: 12位校验

local bit = require "bit"
local string = require "string"
local table = require "table"

local md5
if process and process.title == 'luvit' then
	local crypto = require('_crypto')
	function md5(message)
		return crypto.digest('md5', message, true)
	end
else
	local m = require "md5"
	function md5(message)
		return m.sum(message)
	end
end

local char = string.char
local byte = string.byte
local format = string.format
local sub = string.sub
local band = bit.band
local bxor = bit.bxor
local bnot = bit.bnot
local rshift = bit.rshift
local lshift = bit.lshift
local concat = table.concat
local insert = table.insert


--local code = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-."
--大写字母加数字
local code = "UYQR6DAEZTPF4HSGKX2I8BV59WN3LC7M"
local n2c = {}
local c2n = {}
local a2n = {}
for i = 1, 32 do
	local a = byte(code, i)
	local c = char(a)
	n2c[i-1] = c
	c2n[c] = i-1
	a2n[a] = i-1
end

local GiftcardConfig = require "./card"

function B32AtomEncode(Number, digits)
	local en = {}
	for i = 1, digits do
		table.insert(en, n2c[band(Number,31)])
		Number = rshift(Number, 5)
	end
	return concat(en)
end

function B32AtomDecode(Str)
	local Ret = 0
	for i = #Str, 1, -1 do
		Ret = lshift(Ret, 5)
		Ret = Ret + (a2n[byte(Str, i)] or 0)
	end
	return Ret
end

function CRC16(Str)
	local crc = 0xffff
	for i = 1, #Str do
		crc = bxor(crc, byte(Str, i))
		for j = 1, 8 do
			local c = band(crc, 1)
			crc = rshift(crc, 1);
			if c ~= 0 then
				crc = bxor(crc,0x8408)
			end
		end
	end
	return crc
end

--function StringToNumber(Str)
--	local Ret = 0
--	for i = #Str, 1, -1 do
--		Ret = lshift(Ret, 5)
--		Ret = Ret + byte(Str, i)
--	end
--	return Ret
--end
--
--function NumberToString(Number,digits)
--	local en = {}
--	for i = 1, digits do
--		table.insert(en, char(band(Number, 31)))
--		Number = rshift(Number, 5)
--	end
--	return concat(en)
--end

local CardLen = {
	[20] = true,
	[24] = true,
}

function VerifyCard(Card)
	Card = string.upper(Card)
	local length = #Card
	if not CardLen[length] then
	return false
	end
	if length == 24 then
		Card = sub(Card, 5, 24)
	end
	local TypeCode = sub(Card, 1, 3)
	local Type = B32AtomDecode(TypeCode)
	local CardInfo = GiftcardConfig[Type]
	if not CardInfo then return false end

	local SeqCode = sub(Card, 4, 8)
	local Md5Str = md5(concat {SeqCode, CardInfo.secret, TypeCode})
	local SeqCode1 = format("%04X",CRC16(sub(Md5Str,1,3)))
	local SeqCode2 = format("%04X",CRC16(sub(Md5Str,4,6)))
	local SeqCode3 = format("%04X",CRC16(sub(Md5Str,7,9)))
	if concat({SeqCode1, SeqCode2, SeqCode3}) == sub(Card, 9, 20) then
		CardInfo.prefix = TypeCode
		return CardInfo
	else
		return false
	end
end

function GenLuaConfig()
	local Outs = {}
	insert(Outs, "-- this file is auto-generated.")
	insert(Outs, "local Config = {")
	for Type, Info in pairs(GiftcardConfig) do
		local Prefix = B32AtomEncode(Type,3)
		insert(Outs, format("\t[\"%s\"] = {", Prefix))
		insert(Outs, format("\t\ttypeid = %d,", Type))
		insert(Outs, format("\t\tprefix = \"%s\",", Prefix))
		insert(Outs, format("\t\tdesc = \"%s\",",	Info.desc))
		insert(Outs, format("\t\treward = \"%s\",", Info.reward))
		insert(Outs, format("\t\ttype = \"%s\",",	Info.type))
		insert(Outs, format("\t\ttags = \"%s\",",	Info.tags))
		insert(Outs, format("\t\texpired = \"%s\",", Info.expired))
		insert(Outs, format("\t\tgame_type = %d,", Info.game_type))
		if Info.server then
			insert(Outs, format("\t\tserver = %s,",
				format("{%s}",table.concat(Info.server,',')) ))
		end
		if Info.server_min then
			insert(Outs, format("\t\tserver_min = %d,", Info.server_min))
		end
		if Info.server_max then
			insert(Outs, format("\t\tserver_max = %d,", Info.server_max))
		end
		if Info.task then
			insert(Outs, format("\t\ttask = %d,", Info.task))
		end
		insert(Outs, "\t},")
	end
	insert(Outs, "}")
	insert(Outs, "function GetCardConfig() return Config end")
	local out = io.open("card.auto.lua", "w")
	out:write(concat(Outs, "\n"))
	out:close()
end

function GenPyConfig()
	local Outs = {}
	insert(Outs, "# this file is auto-generated.")
	insert(Outs, "# -*- coding: utf-8 -*-")
	insert(Outs, "Config = {")
	for Type, Info in pairs(GiftcardConfig) do
		local Prefix = B32AtomEncode(Type, 3)
		insert(Outs, format("\t[\"%s\"] = {", Prefix))
		insert(Outs, format("\t\t'typeid' = %d,", Type))
		insert(Outs, format("\t\t'prefix' : \"%s\",", Prefix))
		insert(Outs, format("\t\t'desc' : \"%s\",",	Info.desc))
		insert(Outs, format("\t\t'reward' : \"%s\",", Info.reward))
		insert(Outs, format("\t\t'type' : \"%s\",",	Info.type))
		insert(Outs, format("\t\t'tags' : \"%s\",",	Info.tags))
		insert(Outs, format("\t\t'expired' : \"%s\",", Info.expired))
		insert(Outs, format("\t\t'game_type' : %d,", Info.game_type))
		if Info.server then
			insert(Outs, format("\t\t'server' : %s,",
				format("[%s]",table.concat(Info.server,",")) ))
		end
		if Info.server_min then
			insert(Outs, format("\t\t'server_min' : %d,", Info.server_min))
		end
		if Info.server_max then
			insert(Outs, format("\t\t'server_max' : %d,", Info.server_max))
		end
		if Info.task then
			insert(Outs, format("\t\t'task' : %d,", Info.task))
		end
		insert(Outs, "\t},")
	end
	insert(Outs, "}")
	local out = io.open("card.auto.py", "w")
	out:write(concat(Outs, "\n"))
	out:close()
end

function GenPhpConfig()
	local Outs = {}
	insert(Outs, "<?php")
	insert(Outs, "# this file is auto-generated.")
	insert(Outs, "$GiftCardConfig = array(")
	for Type, Info in pairs(GiftcardConfig) do
		local Prefix = B32AtomEncode(Type,3)
		insert(Outs, format("\t'%s' => array(", Prefix))
		insert(Outs, format("\t\t'type' => \"%s\",", Type))
		insert(Outs, format("\t\t'desc' => \"%s\",",	Info.desc))
		insert(Outs, format("\t\t'reward' => \"%s\",", Info.reward))
		insert(Outs, format("\t\t'type' => \"%s\",",	Info.type))
		insert(Outs, format("\t\t'tags' => \"%s\",",	Info.tags))
		insert(Outs, format("\t\t'secret' => \"%s\",",	Info.secret))
		insert(Outs, format("\t\t'expired' => \"%s\",", Info.expired))
		insert(Outs, format("\t\t'game_type' => %d,", Info.game_type))
		if Info.server then
			insert(Outs, format("\t\t'server' => %s,",
				format("array(%s)",table.concat(Info.server,',')) ))
		end
		if Info.server_min then
			insert(Outs, format("\t\t'server_min' => %d,", Info.server_min))
		end
		if Info.server_max then
			insert(Outs, format("\t\t'server_max' => %d,", Info.server_max))
		end
		if Info.task then
			insert(Outs, format("\t\t'task' => %d,", Info.task))
		end
		insert(Outs, "\t),")
	end
	insert(Outs, ");")
	local out = io.open("card.auto.php", "w")
	out:write(concat(Outs, "\n"))
	out:close()
end

function GenCode(Type, Offset, Number)
	local CardInfo = assert(GiftcardConfig[Type])
	local Ret = {}
	for Seq = Offset, Offset + Number - 1 do
		local TypeCode = B32AtomEncode(Type, 3)
		local SeqCode = B32AtomEncode(Seq, 5)
		local Md5Str = md5(concat{SeqCode, CardInfo.secret, TypeCode})
		local SeqCode1 = format("%04X",CRC16(sub(Md5Str,1,3)))
		local SeqCode2 = format("%04X",CRC16(sub(Md5Str,4,6)))
		local SeqCode3 = format("%04X",CRC16(sub(Md5Str,7,9)))
		Ret[concat{TypeCode, SeqCode, SeqCode1, SeqCode2, SeqCode3}] = true
	end
	return Ret, CardInfo
end

function Gen(Class, Offset, Number, prefix)
	local Code, CardInfo = GenCode(Class, Offset, Number)
	local TypeName = string.gsub(CardInfo.type, "%s+", ".")
	local TagName = string.gsub(CardInfo.tags, "%s+", ".")
	local FileName = Class.."."..TypeName.."."..TagName..".csv"
	local OutFile = io.open(FileName, "w")
	for Card, _ in pairs(Code) do
		assert(VerifyCard(Card))

		if prefix then
			OutFile:write(prefix .. Card)
		else
			OutFile:write(Card)
		end
		OutFile:write("\n")
	end
	OutFile:close()
end

--local Ascii = {
--	{48,57},
--	{65,90},
--	{97,122},
--}
--
--
--function IsLetterAndMumber(n)
--	for _, v in pairs(Ascii) do
--		if n >= v[1] and n <= v[2] then
--			return true
--		end
--	end
--end
--
--function IsCardLetterAndMumber(Card)
--	for i=1, #Card do
--		local n = byte(Card,i)
--		if not IsLetterAndMumber(n) then
--			return
--		end
--	end
--	return true
--end
--
--function GenYY(Class, Offset, Number, prefix)
--	local Code, CardInfo = GenCode(Class, Offset, Number)
--	local TypeName = string.gsub(CardInfo.type, "%s+", ".")
--	local TagName = string.gsub(CardInfo.tags, "%s+", ".")
--	local FileName = Class.."."..TypeName.."."..TagName..".csv"
--	local OutFile = io.open(FileName, "w")
--	for Card, _ in pairs(Code) do
--		if IsCardLetterAndMumber(Card) then
--			if prefix then
--				OutFile:write(prefix .. Card)
--			else
--				OutFile:write(Card)
--			end
--			OutFile:write("\n")
--		end
--	end
--	OutFile:close()
--end


return {
	Gen = Gen,
	VerifyCard = VerifyCard,
}

