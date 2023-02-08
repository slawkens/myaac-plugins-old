--[[
	Gesior Shop System v2.0
	
	Originally written by Gesior, modified by slawkens for MyAAC.
	This script should work with ANY distro.
	
	don't forget to paste this into globalevents.xml:
	
	<globalevent name="gesior-shop-system" interval="30000" script="gesior-shop-system.lua" />
	
	change 30000 to 30 if other values in this file are low
]]--

local messageType = MESSAGE_EVENT_ORANGE
local displayExecutionTime = true -- how time script took in console (true/false)

-- don't edit anything below this line
if(displayExecutionTime) then
	function doSecondsFormat(i)
		local str, found = string.gsub(i, "(%d)(%d%d%d)$", "%1.%2", 1), 0
		repeat
			str, found = string.gsub(str, "(%d)(%d%d%d),", "%1.%2,", 1)
		until found == 0
		return str
	end
end

if(not messageType) then
	messageType = MESSAGE_STATUS_CONSOLE_ORANGE
	if(not messageType) then
		messageType = MESSAGE_INFO_DESCR
	end
end

if(not getPlayerByName) then
	function getPlayerByName(name) local p = Player(name) return p ~= nil and p:getId() or false end
end


if(not isPlayer) then
	function isPlayer(cid) return Player(cid) ~= nil end
end

if(not doPlayerSave) then
	function doPlayerSave(cid)
		if(Player and type(Player) == "table" and Player.save and type(Player.save) == "function") then
			local player = Player(cid)
			if(player) then
				player:save()
			end
		end
		
		return true
	end
end

function getResults()
	if(db.storeQuery ~= nil and result.free ~= nil) then -- TFS 1.0+
		local resultId = db.storeQuery("SELECT * FROM z_ots_comunication;")
		if(resultId == false) then
			return false
		end
		
		local results = {}
		repeat
			local tmp = {}
			tmp.name = result.getDataString(resultId, "name")
			
			-- better performance when no player found
			tmp.exist = false
			tmp.cid = getPlayerByName(tmp.name)
			if(tmp.cid and isPlayer(tmp.cid)) then
				tmp.exist = true
				
				tmp.id = result.getDataInt(resultId, "id")
				tmp.action = result.getDataString(resultId, "action")
				tmp.delete_it = result.getDataInt(resultId, "delete_it")
				
				tmp.param1 = result.getDataInt(resultId, "param1")
				tmp.param2 = result.getDataInt(resultId, "param2")
				tmp.param3 = result.getDataInt(resultId, "param3")
				tmp.param4 = result.getDataInt(resultId, "param4")
				tmp.param5 = result.getDataString(resultId, "param5")
				tmp.param6 = result.getDataString(resultId, "param6")
			end
			
			table.insert(results, tmp)
		until not result.next(resultId)
		result.free(resultId)
		
		return results
	else -- TFS 0.3
		if(db.getResult ~= nil) then
			local result_plr = db.getResult("SELECT * FROM z_ots_comunication;")
			if(result_plr:getID() == -1) then
				return false
			end

			local results = {}
			repeat
				local tmp = {}
				tmp.name = tostring(result_plr:getDataString("name"))

				-- better performance when no player found
				tmp.exist = false
				tmp.cid = getPlayerByName(tmp.name)
				if(tmp.cid and isPlayer(tmp.cid)) then
					tmp.exist = true

					tmp.id = tonumber(result_plr:getDataInt("id"))
					tmp.action = tostring(result_plr:getDataString("action"))
					tmp.delete_it = tonumber(result_plr:getDataInt("delete_it"))
					
					tmp.param1 = tonumber(result_plr:getDataInt("param1"))
					tmp.param2 = tonumber(result_plr:getDataInt("param2"))
					tmp.param3 = tonumber(result_plr:getDataInt("param3"))
					tmp.param4 = tonumber(result_plr:getDataInt("param4"))
					tmp.param5 = tostring(result_plr:getDataString("param5"))
					tmp.param6 = tostring(result_plr:getDataString("param6"))
				end
				
				table.insert(results, tmp)
			until not(result_plr:next())

			result_plr:free()
			return results
		else
			print('[ERROR - gesior-shop-system.lua] Your distribution is not supported')
		end
	end
	
	return false
end

function doQuery(query)
	if(db.asyncQuery ~= nil) then
		db.asyncQuery(query)
	elseif(db.query ~= nil) then
		db.query(query)
	elseif(db.executeQuery ~= nil) then
		db.executeQuery(query)
	else
		return false
	end
	
	return true
end

if(not getItemWeightById) then
	getItemWeightById = getItemWeight
end

if(not doCreateItemEx) then
	function doCreateItemEx(itemid, count)
		if(Game and type(Game) == "table" and Game.createItem and type(Game.createItem) == "function") then
			local item = Game.createItem(itemid, count)
			if item then
				return item:getUniqueId()
			end
			return false
		else
			print("[ERROR - gesior-shop-system] Error code: 1. Please contact slawkens at www.otland.net")
		end
	end
end

function onThink(interval)
	if(interval > 1000) then
		interval = interval / 1000
	end

	local started = os.mtime and os.mtime() or os.time()
	local addedItems, waitingItems = 0, 0
	local added = false

	local results = getResults()
	if(not results) then
		return true
	end
	
	for i, v in ipairs(results) do
		added = false
		local id = v.id
		local action = v.action
		local delete = v.delete_it

		if(v.exist) then
			local cid = v.cid
			local param1, param2, param3, param4 = v.param1, v.param2, v.param3, v.param4
			local add_item_type = v.param5
			local add_item_name = v.param6
			local received_item, full_weight, items_weight, item_weigth = 0, 0, 0, 0
			local item_doesnt_exist = false

			if(add_item_type == 'container' or add_item_type == 'item') then
				local item_weigth = getItemWeightById(param1, 1)
				if(type(item_weigth) == 'boolean') then -- item doesn't exist
					print("[ERROR - gesior-shop-system] Invalid item id: " .. param1 .. ". Change/Fix `itemid1` in `z_shop_offers` then delete it from `z_ots_comunication`")
					item_doesnt_exist = true
				else
					if(add_item_type == 'container') then
						container_weight = getItemWeightById(param3, 1)
						if(type(container_weight) == 'boolean') then -- container item doesn't exist
							print("[ERROR - gesior-shop-system] Invalid container id: " .. param3 .. ". Change/Fix `itemid2` in `z_shop_offers` then delete it from `z_ots_comunication`")
							item_doesnt_exist = true
						else
							if(isItemRune(param1)) then
								items_weight = param4 * item_weigth
							else
								items_weight = param4 * getItemWeightById(param1, param2)
							end
							
							full_weight = items_weight + container_weight
						end
					elseif(add_item_type == 'item') then
						full_weight = getItemWeightById(param1, param2)
						if(isItemRune(param1)) then
							full_weight = getItemWeightById(param1, 1)
						end
					end
				end
				
				if(not item_doesnt_exist) then
					local free_cap = getPlayerFreeCap(cid)
					if(full_weight <= free_cap) then
						if(add_item_type == 'container') then
							local new_container = doCreateItemEx(param3, 1)
							for x = 1, param4 do
								doAddContainerItem(new_container, param1, param2)
							end
							received_item = doPlayerAddItemEx(cid, new_container)
						else
							local new_item = doCreateItemEx(param1, param2)
							received_item = doPlayerAddItemEx(cid, new_item)
						end

						if(received_item == RETURNVALUE_NOERROR) then
							doPlayerSendTextMessage(cid, messageType, "You received >> ".. add_item_name .." << from OTS shop.")
							doQuery("DELETE FROM `z_ots_comunication` WHERE `id` = " .. id .. ";")
							doQuery("UPDATE `z_shop_history` SET `trans_state`='realized', `trans_real`=" .. os.time() .. " WHERE comunication_id = " .. id .. ";")
							doPlayerSave(cid)
							added = true
						else
							doPlayerSendTextMessage(cid, messageType, '>> '.. add_item_name ..' << from OTS shop is waiting for you. Please make place for this item in your backpack/hands and wait about '.. interval ..' seconds to get it.')
						end
					else
						doPlayerSendTextMessage(cid, messageType, '>> '.. add_item_name ..' << from OTS shop is waiting for you. It weight is '.. full_weight ..' oz., you have only '.. free_cap ..' oz. free capacity. Put some items in depot and wait about '.. interval ..' seconds to get it.')
					end
				end
			elseif(add_item_type == 'addon') then
				doPlayerSendTextMessage(cid, messageType, "You received >> ".. add_item_name .." << from OTS shop.")
				doSendMagicEffect(getCreaturePosition(cid), CONST_ME_GIFT_WRAPS)
				doPlayerAddOutfit(cid, param1, param3)
				doPlayerAddOutfit(cid, param2, param4)
				doQuery("DELETE FROM `z_ots_comunication` WHERE `id` = " .. id .. ";")
				doQuery("UPDATE `z_shop_history` SET `trans_state`='realized', `trans_real`=" .. os.time() .. " WHERE comunication_id = " .. id .. ";")
				doPlayerSave(cid)
				added = true
			elseif(add_item_type == 'mount') then
				if(not doPlayerAddMount) then
					print("[ERROR - gesior-shop-system] Your server doesn't support mounts. Remove all items in database from your `z_shop_offers` table where `offer_type` = mount and also in `z_ots_comunication` where `param5` = mount.")
				else
					doPlayerAddMount(cid, param1)
					doPlayerSendTextMessage(cid, messageType, "You received >> ".. add_item_name .." << from OTS shop.")
					doSendMagicEffect(getCreaturePosition(cid), CONST_ME_GIFT_WRAPS)

					doQuery("DELETE FROM `z_ots_comunication` WHERE `id` = " .. id .. ";")
					doQuery("UPDATE `z_shop_history` SET `trans_state`='realized', `trans_real`=" .. os.time() .. " WHERE comunication_id = " .. id .. ";")
					doPlayerSave(cid)
					added = true
				end
			end
		end

		if(added) then
			addedItems = addedItems + 1
		else
			waitingItems = waitingItems + 1
		end
	end

	local message = ">> Shopsystem, added " .. addedItems .. " items. Still waiting with " .. waitingItems .. " items."

	if(displayExecutionTime) then
		local done, str = os.time() - started, ""
		if(os.mtime) then
			done = os.mtime() - started
			if(done < 100) then
				str = "0.0" .. done
			elseif(done < 1000) then
				str = "0." .. done
			else
				str = doSecondsFormat(done)
				if(str:len() == 0) then str = "0.0" end
			end
		end

		message = message .. " Done in: " .. str .. "s."
	end

	print(message)
	return true
end