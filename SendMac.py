from ftplib import FTP
import datetime
import shutil
import time
import os

LOG_PATH = "/var/omnis/CONNLOG/"
SERVER_IP = "10.0.0.21"
FTP_USER = "omnis"
FTP_PASS = "omnis"
MAX_LENGTH = 20

DOMAIN="wiximg"

def sendAllLog():
	count = 0
	for line in open(LOG_PATH+"logemu.log"):
		count +=1
	print ("[MAC] : "+str(count))
	if count >= MAX_LENGTH:
		try:
			ftp = FTP(SERVER_IP)
			con_res = ftp.login(user=FTP_USER, passwd=FTP_PASS)
			print con_res
			ftp.cwd("DB_CONNLOG")
		except Exception as e:
			print("Erreur, Connexion FTP", e)
			return -1
		try:
			now = datetime.datetime.now()
			f_name = "log_emu_" + DOMAIN + "_" + str(now.year) + "-" + str(now.month) + "-" + str(now.day) + "_" + str(now.hour) + "-" + str(now.minute) + "-" + str(now.second)
			shutil.copy(LOG_PATH+"logemu.log",LOG_PATH+f_name)
			os.system("rm " + LOG_PATH + "logemu.log")
			os.system("service ulogd2 restart")
		except Exception as e:
			print ("Erreur dans ouverture de logemu")
			return -1

		fop=open(LOG_PATH+f_name,"r")
		x=ftp.storlines("STOR "+f_name,fop)
		print(x)
		os.remove(LOG_PATH+f_name)
	time.sleep(3)
	return 0

while True:
	sendAllLog()
	time.sleep(3)
