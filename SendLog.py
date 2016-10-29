from ftplib import FTP
import glob
import os
from json import load
from urllib2 import urlopen

FTP_USER = "wixi"
FTP_PASS = "    "
LOG_PATH = "/var/omnis/CONNLOG/"
SERVER_IP = "10.0.0.80"
DEFULT_IP = "192.168.1.1"

def sendAllLog():
    try:
        ftp = FTP(SERVER_IP)
        con_res = ftp.login(user=FTP_USER,passwd=FTP_PASS)
        print con_res
    except Exception as e:
        print ("Erreur de connexion "+SERVER_IP)
        return -1

    ftp.cwd("DB_CONNLOG")
    fs = glob.glob(LOG_PATH + "log_track_*")
    #fs = os.listdir(LOG_PATH)
    for f in fs:
        filename = str(f).split("/")[4]
        fop = open(f,"r")
        x = ftp.storlines("STOR " + filename,fop)
        print (x+" "+filename)
        os.remove(f)
    return 0


if __name__ == '__main__':
    print ('Public IP: ' + getPublicIP())
    sendAllLog()

