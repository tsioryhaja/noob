from ftplib import FTP
import os

LOG_PATH=""
SERVER_IP="41.188.10.3"

MAX_LENGTH=10

DOMAIN="wiximg"

def sendAllLog():
	f = open(LOG_PATH+"logemu.log", "r")
	c = f.read()
	s_c = c.split("\n")
	try:
		ftp=FTP(SERVER_IP)
		con_res=ftp.login(user="wixi",passwd="    ")
		print con_res
	except Exception as e:
		print("Error",e)
		return -1

	ftp.cwd("DB_CONNLOG")
	if len(s_c)>=MAX_LENGTH:
		print("1")
		f=open(LOG_PATH+"logemu.log", "r")
		c=f.read()
		os.system('echo "" > '+LOG_PATH+'logemu.log')
		print("2")
		f_name="log_emu_"+DOMAIN+"_"+str(now.year)+"-"+str(now.month)+"-"+str(now.day)+"_"+str(now.hours)+"-"+str(now.minutes)+"-"+str(now.seconds)+".log"
		f=open(LOG_PATH+f_name,"w")
		f.write(c)
		fop=open(LOG_PATH+f_name,"r")
		x=ftp.storlines("STOR "+f_name,fop)
		print(x)
		os.remove(LOG_PATH+f_name)
	return 0

while true:
	sendAllLog()