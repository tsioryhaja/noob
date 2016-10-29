import ConnectionPrivateData
from ConnectionPrivateData import *
import DatabaseAccess
import time
import os
import glob

DOMAIN = "wiximg"

LOG_PATH = "/var/omnis/DB_CONNLOG/"  #Tokony hifarana amin'ny slash

def getData(row):
	if len(row) > 0:
		YEAR = "2016"
		_elements = row.split(" ")
		_conn = ConnectionPrivateData()
		for element in _elements:
			if element.find("=") > 0:
				data = element.split("=")
				if data[0]=="SRC":
					_conn.setIpSrc(data[1])
				elif data[0]=="DST":
					_conn.setIpDst(data[1])
				elif data[0]=="ACK":
					_conn.setAck(data[1])
				elif data[0]=="SEQ":
					_conn.setSeq(data[1])
				elif data[0]=="SPT":
					_conn.setSport(data[1])
				elif data[0]=="DPT":
					_conn.setDport(data[1])
				elif data[0]=="MAC":
					_conn.setMacs(data[1])
		date = YEAR+"-"+str(month(_elements[0]))+"-"+str(_elements[1])
		_conn.setDate(date)
		time = _elements[2]
		_conn.setTime(time)
		return _conn

def month(m):
	r = 0
	if m=="Jan":
		r=1
	elif m=="Feb":
		r=2
	elif m=="Mar":
		r=3
	elif m=="Apr":
		r=4
	elif m=="May":
		r=5
	elif m=="Jun":
		r=6
	elif m=="Jul":
		r=7
	elif m=="Aug":
		r=8
	elif m=="Sep":
		r=9
	elif m=="Oct":
		r=10
	elif m=="Nov":
		r=11
	elif m=="Dec":
		r=12
	return r

def readFile(filename):
	f_name = filename.split("/")
	f_n = f_name[len(f_name)-1]
	f_dom = f_n.split("_")
	DOMAIN = f_dom[2]
	f = open(filename,"r")
	content = f.read()
	lines = content.split("\n")
	l_c = list()
	for line in lines :
		co = getData(line)
		if co != None:
			co.setDomain(DatabaseAccess.getDomain(DOMAIN))
			co.setPublicIp(f_dom[5])
			l_c.append(co)
			print co.getMacDst()
	return l_c

def insertInDatabase(l_co):
	for e in l_co:
		if(DatabaseAccess.check(e)):
			print(str(e.getIpSrc())+" Not changing from MAC "+str(e.getMacSrc()))
		else:
			print(str(e.getIpSrc())+" change to "+str(e.getMacSrc()))
			DatabaseAccess.insert(e)

def insertAll():
	files = glob.glob(LOG_PATH+"log_emu_*")
	indexLogFile = 1
	nbLogFile = files.__len__()
	for f in files:
		if os.path.isfile(os.path.join(f)):
			print ( str(indexLogFile) + " " + str(nbLogFile) +"================================================="+f)
			l_co = readFile(f)
			insertInDatabase(l_co)
		indexLogFile+=1


#while True:
#	print "[Eval MAC] : ."
#	insertAll()
#	time.sleep(1)
insertAll()