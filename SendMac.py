from ftplib import FTP
import glob
import datetime
import shutil
import time
import os

LOG_PATH = "/var/omnis/CONNLOG/"
SERVER_IP = "10.0.0.80"
FTP_USER = "omnis"
FTP_PASS = "omnis"
MAX_LENGTH = 5

DOMAIN="wiximg"

def sendAllLog():
	count = 0
	for line in open(LOG_PATH+"logemu.log"):
		count +=3
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
			f_name = "log_emu_" + DOMAIN + "_" + str(now.year) + "-" + str(now.month) + "-" + str(now.day) + "_" + str(now.hour) + "-" + str(now.minute) + "-" + str(now.second) + "_" + str(getPublicIP())
			shutil.copy(LOG_PATH+"logemu.log",LOG_PATH+f_name)
			os.system("rm " + LOG_PATH + "logemu.log")
			os.system("service ulogd2 restart")
		except Exception as e:
			print ("Erreur dans ouverture de logemu")
			return -1

		files = glob.glob(LOG_PATH+"log_emu_*")
		for f in files:
			fop=open(f,"r")
			x=ftp.storlines("STOR "+f_name,fop)
			print(x + " "+f_name)
			os.remove(f)
	time.sleep(3)
	return 0

def getPublicIP():
    try:
        ip = load(urlopen('https://api.ipify.org/?format=json'))['ip']
        return ip
    except Exception as e:
	return DEFAULT_IP

while True:
	sendAllLog()
	time.sleep(3)
