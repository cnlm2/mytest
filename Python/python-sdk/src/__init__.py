# coding=utf-8
from openapi_client import openapi_client as client
from core.rsa_client import rsa_client as rsa
import pickle
import json
import time
import datetime
import os
import base64
import threading
from time import ctime,sleep

appid = "799985c92ad74b2d84ced92748645a25"


def log(*msg):
    print("msg:",msg,"================>",time.strftime("%Y-%m-%d %H:%M:%S", time.localtime()))


def getListingIdList():
    access_url = "https://openapi.ppdai.com/listing/openapiNoAuth/loanList"
    data = {
        "PageIndex": 1,
        "StartDateTime": "2015-11-11 12:00:00.000"
    }
    sort_data = rsa.sort(data)
    sign = rsa.sign(sort_data)
    list_result = client.send(access_url, json.dumps(data) , appid, sign)
    if (list_result["Result"] != 1):
        log("error getListingIdList")
        return []
    ListingIds = []
    for LoanInfo in list_result["LoanInfos"]:
        if LoanInfo["CreditCode"] != "AA":
            ListingIds.append(LoanInfo["ListingId"])
    return ListingIds

def getListingIdInfo(ListingIds):
    access_url = "https://openapi.ppdai.com/listing/openapiNoAuth/batchListingInfo"

    data = {
        "ListingIds": ListingIds
    }
    sort_data = rsa.sort(data)
    sign = rsa.sign(sort_data)
    list_result = client.send(access_url, json.dumps(data) , appid, sign)
    if (list_result["Result"] != 1):
        log("error getListingIdInfo")
    return list_result["LoanInfos"] 

class User:
    def __init__(self, code, token):

        #pp web return
        self.code = code
        self.token = token
        # authorizeObj
        # {"OpenID":"xx","AccessToken":"xxx","RefreshToken":"xxx","ExpiresIn":604800}
        self.authorizeObj = None
        self.balance = 0
        self.init()

    def init(self):
        if not self.token:
            self.auth()
        self.getBalance()

    def auth(self):
        authorizeStr = client.authorize(appid=appid, code=self.code) #获得授权
        self.authorizeObj = json.loads(authorizeStr)  # 将返回的authorize对象反序列化成对象，成功得到 OpenID、AccessToken、RefreshToken、ExpiresIn
        self.token = self.authorizeObj["AccessToken"]
        log("auth end",self.token)
    
    def getBalance(self):
        access_url = "https://openapi.ppdai.com/balance/balanceService/QueryBalance"
        data = {}
        sort_data = rsa.sort(data)
        sign = rsa.sign(sort_data)
        list_result = client.send(access_url, json.dumps(data), appid, sign, self.token)
        self.balance = list_result["Balance"][0]["Balance"]
        log("balance end",self.balance)
        return self.balance
    
    def bid(self,ListingId):
        access_url = "https://openapi.ppdai.com/listing/openapi/bid"
        access_token = self.token
        data = {
        "ListingId": ListingId, 
        "Amount": 50,
        "UseCoupon":"true"
        }
        sort_data = rsa.sort(data)
        sign = rsa.sign(sort_data)
        list_result = client.send(access_url,json.dumps(data) , appid, sign,access_token)
        if list_result["Result"] != 0:
            log("bid faild",list_result)
        else:
            log("bid success",list_result)
#code 信息
code_list = [
    ["9d552f93ca6f48e194e88a42a601cd0a","7ddc87625943f0aaeaa76576fe093f57a502db3b718406e0829cdef944f5c6c26bc0d95465528aa1003ad5d20da0af6f6cb6e8ea678b72b04cfdebe7"],
    ["8188df0b70744dc69ac50e35347547b8","2edf8330594dfda5ecab6c79f6093f57afff6c64c0a32708801131095dc767b9d6b2bd8a50a0b6af9eac58eea9b4dbd245a0b3a9151337fe33d6bb8c"]
]

#投标规则
rule_list = {
    u"ListingId":0,
    u"EducationDegree": lambda v: v!=None,
    u"CreditCode": lambda v: v in ["A","B","C"],
    u"SuccessCount": lambda v: v > 2,
    u"FailedCount":  lambda v: v <= 0,
    u"NormalCount": lambda v: v >= 12,
    u"OverdueLessCount": lambda v: v <=0,
    u"OverdueMoreCount": lambda v: v <=0,
   # u"EducateValidate":1,
    u"OwingAmount": lambda v: v, #待还金额
    u"OwingPrincipal":0, #待还本金
    u"HighestDebt":0, #历史最高负债
    u"TotalPrincipal":0, #累计借款金额
    u"HighestPrincipal":0, #单笔最高金额 
    u"CurrentRate":16,
    u"RemainFunding":0,
    u"Amount":0,
}
def ruleFunc(LoanInfo):
    return LoanInfo["EducationDegree"] != None and \
        LoanInfo["RemainFunding"] > 0 and \
        LoanInfo["CreditCode"] in ["B","C"] and \
        LoanInfo["SuccessCount"] >= 2 and \
        LoanInfo["FailedCount"] <= 0 and \
        LoanInfo["NormalCount"] >= 12 and \
        LoanInfo["OverdueLessCount"] == 0 and \
        LoanInfo["OverdueMoreCount"] == 0 and \
        LoanInfo["OwingAmount"]/LoanInfo["HighestDebt"] <= 0.3 and \
        (LoanInfo["OwingAmount"]+LoanInfo["Amount"]) / LoanInfo["TotalPrincipal"] <= 0.4 
        



#用户列表
user_list = []


#当前查询到的表的id列表
ProcessedListingIdList = []

#当前曾在处理的标列表
PendingListingIdList = { "First":0, "Last":-1}

#线程池
threads = []

def bidThreadFunc():
    global PendingListingIdList
    while(1):
        #log("bidThreadFunc Start")
        if PendingListingIdList["First"] <= PendingListingIdList["Last"]:
            ListingIds = PendingListingIdList[PendingListingIdList["First"]]
            del PendingListingIdList[PendingListingIdList["First"]]
            PendingListingIdList["First"] += 1
            #ListingIds = [134263786]
            LoanInfos = getListingIdInfo(ListingIds)
            for LoanInfo in LoanInfos:
                if ruleFunc(LoanInfo):
                    user = user_list[1]
                    user.bid(LoanInfo["ListingId"])
                    print("====================================")
                    for key in rule_list.keys():
                        #log("bidThreadFunc Info",key,LoanInfo[key])
                        print("=============>",key,LoanInfo[key])
                    print("====================================")
        else:
            time.sleep(1)
        #log("bidThreadFunc End")
def MainFunc():
    while(1):
        #log("MainFunc Start",)
        global ProcessedListingIdList
        global PendingListingIdList
        ListingIds = getListingIdList()
        if len(ListingIds) > 0:
            IdleListingIds = []
            for ListingId in ListingIds:
                if ListingId not in ProcessedListingIdList:
                    ProcessedListingIdList.append(ListingId)
                    IdleListingIds.append(ListingId)

            ListingId10 = [IdleListingIds[i:i+10] for i in range(0, len(IdleListingIds), 10)]
            for IdList in ListingId10:
                PendingListingIdList[PendingListingIdList["Last"]+1] = IdList
                PendingListingIdList["Last"] += 1
            #log("MainFunc End",len(ProcessedListingIdList),len(PendingListingIdList))
        time.sleep(1)

def init_all_user():
    for code_info in code_list:
        code,token = code_info
        user = User(code,token)
        user_list.append(user)
        log("init_all_user",user)

def __init__():
    init_all_user()
    t1 = threading.Thread(target=bidThreadFunc)
    threads.append(t1)
    t2 = threading.Thread(target=MainFunc)
    threads.append(t2)

    for t in threads:
        t.start()

__init__()



