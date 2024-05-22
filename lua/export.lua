-- Import the json library
-- local json = require('json')
-- local lunajson = require('lunajson')

-- https://github.com/tiye/json-lua/blob/main/JSON.lua the one that actually works and is able to parse lua table containing nil values.
local JSON = require("JSON");

-- Import the Auctioneer module
local Auctioneer = require('Auctioneer')

-- Function to convert Lua table to JSON and write to a file
local function convertToJsonAndWriteToFile(luaTable, fileName)
    local jsonString = JSON:encode(luaTable)
    local file = io.open(fileName, "w")
    file:write(jsonString)
    file:close()
end

-- Call the function with the Auctioneer table
-- print(_G.AuctioneerItemDB)
convertToJsonAndWriteToFile(_G.AuctioneerItemDB, "AuctioneerItemDB.json")
convertToJsonAndWriteToFile(_G.AuctioneerSnapshotDB, "AuctioneerSnapshotDB.json")
convertToJsonAndWriteToFile(_G.AuctioneerHistoryDB, "AuctioneerHistoryDB.json")
convertToJsonAndWriteToFile(_G.AuctioneerFixedPriceDB, "AuctioneerFixedPriceDB.json")
convertToJsonAndWriteToFile(_G.AuctioneerTransactionDB, "AuctioneerTransactionDB.json")

-- print(_G.AuctioneerSnapshotDB)

local function printTable(t)
    for k, v in pairs(t) do
        if type(v) == "table" then
            printTable(v)
        else
            print(k, v)
        end
    end
end

-- printTable(_G.AuctioneerSnapshotDB)
